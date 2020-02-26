<?php
namespace it\icosaedro\www\user;
require_once __DIR__ . "/../../../../all.php";
use ErrorException;
use it\icosaedro\utils\Random;
use it\icosaedro\sql\SQLException;
use it\icosaedro\web\Html;
use it\icosaedro\web\Form;
use it\icosaedro\web\controls\Line;
use it\icosaedro\web\controls\Password;
use it\icosaedro\www\SiteSpecific;

/**
 * Dialog box to set a new password, as we cannot really recover the original
 * password. In order to set a new password, this dialog silently assumes the
 * user remembers exactly its login name and its email address as entered in the
 * preferences dialog. No feedback is given if these data does not match any
 * current user or if the specific user did not entered its email at all.
 * The entry point is the entry method, as usual.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/22 23:42:26 $
 */
class ForgotPasswordMask extends Form {
	
	/**
	 * Dialog phase:
	 * 0 = enter login name, email and new password;
	 * 1 = enter received OTP.
	 * @var int
	 */
	private $phase = 0;
	
	/**
	 * @var Line
	 */
	private $pretended_name;
	
	/**
	 * @var Line
	 */
	private $pretended_email;
	
	/**
	 * @var Password
	 */
	private $new_password;
	
	/**
	 * @var string
	 */
	private $generated_otp;
	
	/**
	 * @var Line
	 */
	private $entered_otp;
	
	function __construct() {
		parent::__construct(TRUE);
		$this->pretended_name = new Line($this, "pretended_name");
		$this->pretended_email = new Line($this, "pretended_email");
		$this->new_password = new Password($this, "new_password");
		$this->entered_otp = new Line($this, "entered_otp");
	}
	
	function save()
	{
		parent::save();
		$this->setData("phase", $this->phase);
		$this->setData("generated_otp", $this->generated_otp);
	}
	
	function resume()
	{
		parent::resume();
		$this->phase = (int) $this->getData("phase");
		$this->generated_otp = (string) $this->getData("generated_otp");
	}
	
	/**
	 * @param string $err
	 */
	function render($err = NULL)
	{
		Common::echoPageHeader("Forgot Password");
		$this->open();
		if( strlen($err) > 0 )
			Html::errorBox("<ul>$err</ul>");
		
		// Enter login name, email and new pass dialog:
		echo "<div", ($this->phase == 0? "" : " style='display: none;'"), ">";
		echo "<p>So you forgot your login password. It happens, sometimes. But you should at least remember your exact login name and your exact email address. Please enter them again here below.</p>";
		echo "<p><b>Enter your login name:</b><br>";
		$this->pretended_name->render();
		echo "<p><b>Please enter the email address you set in the preferences;</b> if you did not set an email address in your preferences dialog box, sorry but there is not a fallback:<br>";
		$this->pretended_email->addAttributes("size=50");
		$this->pretended_email->render();
		echo "<p><b>Choose your new preferred password:</b><br>";
		$this->new_password->render();
		echo "<p>By pressing the confirmation button here below, an OTP code will be sent to your email address to confirm the new password.</p>";
		$this->button("Send me the OTP", "saveButton");
		echo "</div>";
		
		// Confirm OTP dialog:
		echo "<div", ($this->phase == 1? "" : " style='display: none;'"), ">";
		echo "<p>An email has been sent to <b>", Html::text($this->pretended_email->getValue()), "</b> containing the OTP to confirm the new password. Please enter that OTP here below:</p>";
		$this->entered_otp->render();
		echo "<p>";
		$this->button("Confirm OTP", "saveButton");
		echo "&emsp;";
		$this->button("Try again", "tryAgain");
		echo "</div>";
		
		$this->close();
		Common::echoPageFooter();
	}
	
	function tryAgain()
	{
		$this->phase = 0;
		$this->render();
	}
	
	/**
	 * This "save" button performs the confirmation of the entered data specific
	 * of each phase of the dialog.
	 * @throws SQLException
	 * @throws ErrorException
	 */
	function saveButton()
	{
		$err = "";
		
		// Validate pretended name:
		$pretended_name = $this->pretended_name->getValue();
		if( strlen($pretended_name) == 0 )
			$err .= "<li>You must specify your login name.</li>";
		
		// Validate pretended email:
		$pretended_email = $this->pretended_email->getValue();
		if( strlen($pretended_email) == 0 )
			$err .= "<li>You must specify your email address.</li>";
		
		// Validate new password:
		$new_password = $this->new_password->getValue();
		if( strlen($new_password) == 0 )
			$err .= "<li>You must enter a new password.</li>";
		else if( strlen($new_password) > 100 )
			$err .= "<li>Password too long.</li>";
		
		if( strlen($err) > 0 ){
			$this->render($err);
			return;
		}
		
		// Lets the user wait a constant interval of time:
		$wait_until = time() + 5;
		
		// Check if that name + email do really exist:
		$db = SiteSpecific::getDB();
		$ps = $db->prepareStatement("select name, email from users where name=? and email=?");
		$ps->setString(0, $pretended_name);
		$ps->setString(1, $pretended_email);
		$res = $ps->query();
		$user_and_email_ok = $res->getRowCount() == 1;
		
		$otp_ok = strlen($this->generated_otp) > 0 && $this->generated_otp === $this->entered_otp->getValue();
		
		if( $this->phase == 0 ){
			
			// Generate and send OTP:
			// ======================
			$this->entered_otp->setValue("");
			if( $user_and_email_ok ){
				$this->generated_otp = base64_encode( Random::getCommon()->randomBytes(6) );
				mail($pretended_email, "Icosaedro WEB Application",
					$this->generated_otp,
					"From: " . SiteSpecific::ADMIN_EMAIL);
			} else {
				$this->generated_otp = "";
			}
			sleep($wait_until - time());
			$this->phase = 1;
			$this->render();
			
		} else if( $this->phase == 1 ){
			
			// Check OTP and change password:
			// ==============================
			if( ! $otp_ok ){
				sleep($wait_until - time());
				$this->render("<li>Invalid OTP.</li>");
				return;
			}
			$ps = $db->prepareStatement("update users where name=? set pass_hash=?");
			$ps->setString(0, $pretended_name);
			$ps->setString(1, md5($pretended_name . $new_password));
			$ps->update();
			sleep($wait_until - time());
			LoginMask::enter($pretended_name);
		}
	}
	
	/**
	 * Entry point of the password recovery dialog box.
	 * @param string $name Initial value of the user name text box, typically
	 * coming from the login mask the user was trying to complete with password.
	 * This dialog allows to edit that name, anyway.
	 */
	static function enter($name)
	{
		$f = new self();
		$f->pretended_name->setValue($name);
		$f->render();
	}
	
	function browserReloadEvent()
	{
		self::enter($this->pretended_name->getValue());
	}
	
}
