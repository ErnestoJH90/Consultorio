<?php
namespace it\icosaedro\www\user;
require_once __DIR__ . "/../../../../all.php";
use it\icosaedro\sql\SQLException;
use it\icosaedro\web\Http;
use it\icosaedro\web\bt_\Form;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\web\controls\Line;
use it\icosaedro\web\controls\Password;
use it\icosaedro\web\controls\Spinner;
use it\icosaedro\web\controls\Text;
use it\icosaedro\web\controls\ParseException;
use it\icosaedro\www\SiteSpecific;
use it\icosaedro\www\Common;

/**
 * Allows the registered user to set its preferences.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/10 09:01:20 $
 */
class PreferencesMask extends Form {
	
	/**
	 * Email regular expression as suggested in
	 * https://www.w3.org/TR/html5/sec-forms.html#email-state-typeemail
	 * See the reference for limitations.
	 * Note only ASCII allowed; internationalized email addresses should then be
	 * entered in punycode (RFC 5322).
	 */
	const EMAIL_REGEX = "/^[a-zA-Z0-9.!#\$%&'*+\\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*\$/sD";
	
	/**
	 * @var Password
	 */
	private $pass;
	
	/**
	 * @var string
	 */
	private $curr_email = "";
	
	/**
	 * @var Line
	 */
	private $email;
	
	/**
	 * @var Line
	 */
	private $current_name;
	
	/**
	 * @var Text
	 */
	private $signature;
	
	/**
	 * @var Spinner
	 */
	private $tz_hours;
	
	/**
	 * @var Spinner
	 */
	private $tz_minutes;
	
	function __construct()
	{
		parent::__construct();
		$this->pass = new Password($this, "pass");
		$this->email = new Line($this, "email");
		$this->current_name = new Line($this, "current_name");
		$this->signature = new Text($this, "signature");
		$this->tz_hours = new Spinner($this, "tz_hours");
		$this->tz_hours->setMinMaxStep(-12, 12, 1);
		$this->tz_minutes = new Spinner($this, "tz_minutes");
		$this->tz_minutes->setMinMaxStep(0, 45, 15);
	}
	
	/**
	 * @param string $err
	 */
	function render($err = NULL)
	{
		Http::headerContentTypeHtmlUTF8();
		echo "<html><body>";
		Common::echoNavBar();
		$this->open();
		echo "<h1>Preferences</h1>";
		
		if( strlen($err) > 0 )
			Common::info_box("/img/error.png", "Error", "<ul>$err</ul>");
		
		echo <<< EOT
<p><b>Change password.</b> The new password will replace the current one.<br>
EOT;
		$this->pass->render();
		
		echo <<< EOT
<p><b>Your email address.</b> It is not mandatory, but it allows to recover a
forgotten password and to receive notifications about projects you are member of. The email addresses are never displayed in the web site.<br>
EOT;
		$this->email->addAttributes("size=60");
		$this->email->render();

		echo <<< EOT
<p><b>Enter your displayed name.</b> This name will be displayed as the "From"
value of your messages. If omitted, the login name will be used instead.<br>
EOT;
		$this->current_name->addAttributes("size=60");
		$this->current_name->render();
	
		echo <<< EOT
<p><b>Signature of your messages.</b> It is automatically appended to any your
new message.<br>
EOT;
		$this->signature->addAttributes("cols=80 rows=5");
		$this->signature->render();
		
		echo "<p><b>Your time zone:</b> ";
		$this->tz_hours->addAttributes("style='width:4em;'");
		$this->tz_hours->render();
		echo ":";
		$this->tz_minutes->addAttributes("style='width:3em;'");
		$this->tz_minutes->render();

		echo "<p>";
		$this->button("Save", "saveButton");

		$this->close();
		Common::echoPageFooter();
	}
	
	/**
	 * @throws SQLException
	 */
	function saveButton()
	{
		$err = "";
		
		$pass = $this->pass->getValue();
		if( strlen($pass) > 100 )
			$err .= "<li>Password too long, max 100 bytes allowed.</li>";
		
		$email = $this->email->getValue();
		if( strlen($email) > 0 ){
			if( strlen($email) > 100 )
				$err .= "<li>Email too long, max 100 bytes allowed.</li>";
			else if( 1 != preg_match(self::EMAIL_REGEX, $email) ){
				$err .= "<li>Invalid email syntax.</li>";
			}
		}
		
		$current_name = $this->current_name->getValue();
		if( strlen($current_name) > 100 )
			$err .= "<li>Displayed name too long, max 100 bytes allowed.</li>";
		
		$signature = $this->signature->getValue();
		if( strlen($signature) > 400 )
			$err .= "<li>Signature too long, max 400 bytes allowed.</li>";
		
		if( strlen($err) > 0 ){
			$this->render($err);
			return;
		}
		
		$db = SiteSpecific::getDB();
		
		$name = UserSession::getSessionParameter("name");
		
		if( strlen($pass) > 0 ){
			$ps = $db->prepareStatement("update users set pass_hash=? where name=?");
			$ps->setString(0, md5($name.$pass));
			$ps->setString(1, $name);
			$ps->update();
		}
		
		if( strlen($current_name) == 0 )
			$current_name = $name;
		
		$ps = $db->prepareStatement("update users set current_name=?, signature=? where name=?");
		$ps->setString(0, $current_name);
		$ps->setString(1, $signature);
		$ps->setString(2, $name);
		$ps->update();
		
		UserSession::setSessionParameter('current_name', $current_name);
		UserSession::setSessionParameter('signature', $signature);
		
		if( $email !== $this->curr_email ){
			if( strlen($email) == 0 ){
				// Emptied email. Blindly store.
				$ps = $db->prepareStatement("update users set email='' where name=?");
				$ps->setString(0, $name);
				UserSession::setSessionParameter("email", "");
			} else {
				// New email requires confirmation.
				$this->returnTo("render");
				EmailConfirmationMask::enter($email);
				return;
			}
		}
		
		try {
			$tz_minutes = 60 * $this->tz_hours->parse();
			if( $tz_minutes >= 0 )
				$tz_minutes += $this->tz_minutes->parse();
			else
				$tz_minutes -= $this->tz_minutes->parse();
		}
		catch(ParseException $e){
			// who cares?
			$tz_minutes = 0;
		}
		\it\icosaedro\www\Common::setTZMinutes($tz_minutes);
		
		\it\icosaedro\www\DashboardMask::enter();
	}
	
	function save()
	{
		parent::save();
		$this->setData("curr_email", $this->curr_email);
	}
	
	function resume()
	{
		parent::resume();
		$this->curr_email = (string) $this->getData("curr_email");
	}
	
	static function enter()
	{
		$f = new self();
		$f->curr_email = UserSession::getSessionParameter("email");
		$f->email->setValue($f->curr_email);
		$f->current_name->setValue( UserSession::getSessionParameter("current_name") );
		$f->signature->setValue( UserSession::getSessionParameter("signature") );
		$tz_minutes = \it\icosaedro\www\Common::getTZMinutes();
		$f->tz_hours->setInt(intdiv($tz_minutes, 60));
		$f->tz_minutes->setInt(($tz_minutes >= 0? $tz_minutes : -$tz_minutes) % 60);
		$f->render();
	}
	
	function browserReloadEvent()
	{
		self::enter();
	}
	
	function browserBackEvent()
	{
		\it\icosaedro\www\DashboardMask::enter();
	}
	
}
