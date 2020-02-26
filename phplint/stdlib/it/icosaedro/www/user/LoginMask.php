<?php
namespace it\icosaedro\www\user;
require_once __DIR__ . "/../../../../all.php";
use RuntimeException;
use it\icosaedro\web\Html;
use it\icosaedro\web\controls\Line;
use it\icosaedro\web\controls\Password;
use it\icosaedro\web\Form;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\www\SiteSpecific;
use Exception;

/*. require_module 'hash'; .*/

/**
 * Login mask. Note here we are using a sticky form, not a bt_ form because
 * a session is still to be established.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/30 05:34:52 $
 */
class LoginMask extends Form {
	
	/**
	 * @var Line
	 */
	private $name;
	
	/**
	 * @var Password
	 */
	private $pass;
	
	function __construct()
	{
		parent::__construct(FALSE);
		$this->name = new Line($this, "name");
		$this->pass = new Password($this, "pass");
	}

	/**
	 * 
	 * @param string $err
	 */
	function render($err = NULL)
	{
		Common::echoPageHeader("Login");
		$this->open();
		if( strlen($err) > 0 )
			Html::errorBox($err);
		echo "<center>";
		echo '<table cellspacing=10><tr><td>Name:</td><td>';
		$this->name->addAttributes("autofocus=autofocus");
		$this->name->render();
		echo '</td></tr><tr><td>Password:</td><td>';
		$this->pass->render();
		echo '</td></tr></table>';
		echo "<p>";
		$this->button("Login", "loginButton");
		echo "</center>";
		echo "<p align=right>";
		if( isset($_COOKIE["BTSESSION"]) )
			echo "<a href=\"", Html::text(SiteSpecific::DISPATCHER_URL),
				"\">Recover pending session</a> | ";
		echo "<a href='", Html::text(SiteSpecific::LOGIN_AS_A_GUEST_URL),
			"'>Login as a guest</a>";
		echo "</p>";
		$this->close();
		Common::echoPageFooter();
	}
	
	static function doNothing()
	{
	}
	
	/**
	 * @param string $name
	 * @throws Exception
	 */
	static function createBtSessionForUser($name)
	{
		$db = SiteSpecific::getDB();
		$ps = $db->prepareStatement("SELECT * FROM users WHERE name=?");
		$ps->setString(0, $name);
		$res = $ps->query();
		$res->moveToRow(0);
		
		new UserSession(
				$name,
				SiteSpecific::BT_BASE_DIR,
				SiteSpecific::DISPATCHER_URL,
				SiteSpecific::LOGIN_URL,
				self::class . "::doNothing",
				SiteSpecific::REQUIRE_HTTPS
		);
		
		UserSession::setSessionParameter('user_pk', $res->getStringByName('pk'));
		UserSession::setSessionParameter('name', $name);
		UserSession::setSessionParameter('email', $res->getStringByName('email'));
		UserSession::setSessionParameter('current_name', $res->getStringByName('current_name'));
		UserSession::setSessionParameter('permissions', $res->getStringByName('permissions'));
		UserSession::setSessionParameter('signature', $res->getStringByName('signature'));
		
		$ps = $db->prepareStatement("update users set last_login=? where name=?");
		$ps->setInt(0, time());
		$ps->setString(1, $name);
		$ps->update();
	}
	
	/**
	 * 
	 * @throws Exception
	 */
	function loginButton()
	{
		$name = $this->name->getValue();
		$pass = $this->pass->getValue();
		
		if(strlen($name) == 0 || strlen($pass) == 0 ){
			$this->render("Invalid name/password combination.");
			return;
		}
		
		// Check name and pass:
		$db = SiteSpecific::getDB();
		$ps = $db->prepareStatement("SELECT name, last_login FROM users WHERE name=? AND pass_hash=?");
		$ps->setString(0, $name);
		$ps->setString(1, md5($name.$pass));
		$res = $ps->query();
		if( $res->getRowCount() != 1 ){
			$this->render("Invalid name/password combination.");
			return;
		}
		
		// Create session:
		$res->moveToRow(0);
		$name = $res->getStringByName('name'); // safer to get the verbatim value
		$last_login = $res->getIntByName("last_login");
		self::createBtSessionForUser($name);

		\it\icosaedro\www\Common::echoPageHeader();
		\it\icosaedro\www\Common::info_box(
			"/img/notice.png", "Notice",
			"Welcome back to the icosaedro.it WEB Application!"
			."<p>Your last login was at "
			.\it\icosaedro\www\Common::formatTS($last_login));
		\it\icosaedro\www\Common::echoPageFooter();
	}
	
	function defaultButton()
	{
		try {
			$this->loginButton();
		}
		catch(Exception $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
	
	/**
	 * Performs an automatic login for user 'guest' and displays the comments
	 * related to the requested page.
	 * @throws Exception
	 */
	function guestLoginButton()
	{
		self::createBtSessionForUser("guest");
		\it\icosaedro\www\DashboardMask::enter();
	}
	
	/**
	 * Displays the login mask.
	 * @param string $name
	 */
	static function enter($name)
	{
		$f = new self();
		$f->name->setValue($name);
		$f->render();
	}

}
