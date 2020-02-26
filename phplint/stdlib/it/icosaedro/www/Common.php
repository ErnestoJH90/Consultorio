<?php
namespace it\icosaedro\www;
require_once __DIR__ . "/../../../all.php";
use it\icosaedro\utils\UTF8;
use it\icosaedro\web\Http;
use it\icosaedro\web\Html;
use it\icosaedro\web\bt_\UserSession;
use RuntimeException;
use JsonException;

/*. require_module 'json'; .*/

const HSPACE = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
const VSPACE = "<pre>\n</pre>";
const CENTER = "<center>";
const CENTER_ = "</center>";

/**
 * IWA common definitions.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/31 12:23:05 $
 */
class Common {
	
	const FALLBACK_FUNCTION = "it\\icosaedro\\www\\DashboardMask::enter";
	
	/**
	 * The administrator may access the users' table, may remove any message.
	 */
	const PERMISSION_IS_ADMIN = 0;
	
	/**
	 * The user may access its preferences.
	 */
	const PERMISSION_PREFS = 1;
	
	/**
	 * The user may post new messages.
	 */
	const PERMISSION_MAY_POST = 2;
	
	/**
	 * The user may remove its own messages.
	 */
	const PERMISSION_MAY_DELETE = 3;
	
	/**
	 * If JobsMonitor.php may start new jobs. BEWARE: enabling this feature could
	 * be a security risk. Before doing this, ensure HTTPS be enabled and change
	 * the admin password.
	 */
	const JOBS_ALLOWS_START = TRUE;

	/**
	 * 
	 * @param string $s
	 * @param int $max
	 * @return string
	 */
	static function short($s, $max)
	{
		$len = UTF8::length($s);
		if( $len <= $max )
			return $s;
		return substr($s, 0, UTF8::byteIndex($s, $max)) . "[...]";
	}


	static function isGuest()
	{
		return strcmp(UserSession::getSessionParameter('name'), 'guest') == 0;
	}
	
	/**
	 * Returns true if the current user of the session has the specified permission
	 * number enabled.
	 * @param int $n Permission number starting from zero.
	 * @return boolean
	 */
	static function checkPermission($n)
	{
		if( $n < 0 )
			return FALSE;
		$permissions = UserSession::getSessionParameter("permissions");
		if( strlen($permissions) < $n+1 )
			return FALSE;
		return $permissions[$n] === '1';
	}
	
	
//	static function setPermission($s, $n, $value)
//	{
//		$len = 4;
//		if( !(0 <= $n && $n < $len) )
//			throw new RuntimeException("no this permission: $n");
//		$s = trim($s);
//		if( strlen($s) < 4 )
//			$s .= str_repeat ("0", $len - strlen($s));
//		else if( strlen($s) > $len )
//			$s = substr($s, 0, $len);
//		return substr($s, 0, $n) . ($value? "1":"0") . substr($s, $n+1);
//	}
	
	/**
	 * Displays the navigation bar.
	 */
	static function echoNavBar()
	{
		$window_title = "IWA";
		echo "<table width='100%' cellpadding=4 bgcolor='#dddddd'><tr><td>";
		echo "&emsp;";
		UserSession::anchor("IWA", "it\\icosaedro\\www\\DashboardMask::enter");
		echo ":";
		echo "&emsp;";
		UserSession::anchor("Comments", "it\\icosaedro\\www\\comments\\PagesMask::enter");
		echo "&emsp;";
		UserSession::anchor("ITS", "it\\icosaedro\\www\\its\\DashboardMask::enter");
		
		if( self::checkPermission(self::PERMISSION_IS_ADMIN) ){
			echo "&emsp;";
			UserSession::anchor("Users", "it\\icosaedro\\www\\admin\\UsersMask::enter");
			echo "&emsp;";
			UserSession::anchor("Jobs", "it\\icosaedro\\www\\admin\\JobsMonitor::enter");
		}
		
		echo "</td><td align=right><a href='", SiteSpecific::DISPATCHER_URL,
			"' target=_blank>New Window</a>";
		
		if( self::isGuest() ){
			echo "&emsp;";
			UserSession::setCallBackward(Common::FALLBACK_FUNCTION);
			UserSession::anchor('Registration', "it\\icosaedro\\www\\user\\RegistrationMask::enter", NULL);
		}
		
		if( self::checkPermission(Common::PERMISSION_PREFS)	){
			echo "&emsp;";
			UserSession::anchor("Preferences", "it\\icosaedro\\www\\user\\PreferencesMask::enter");
		}
		
		echo "&emsp;";
		$user_name = UserSession::getSessionParameter("name");
		echo Html::text($user_name), " ";
		UserSession::anchor("Logout", UserSession::class . "::logout");
		echo "&emsp;</td></tr></table>";
		try {
		echo "<script>document.title = ",
			json_encode($window_title, JSON_HEX_TAG), ";</script>";
		}
		catch(JsonException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
	
	
	static function echoPageHeader()
	{
		Http::headerContentTypeHtmlUTF8();
		self::echoNavBar();
	}
	
	
	static function echoPageFooter()
	{
		echo VSPACE, '<hr><small>';
		echo 'Go back to <a href="http://www.icosaedro.it/">',
			'<code>www.icosaedro.it</code></a>';
//		$b = UserSession::getSessionParameter('back-to');
//		if( strlen($b) > 0 ){
//			$r = preg_replace("@^http://@", "", $b);
//			echo ' - Back to <a href=', Html::text($b."#comments"), '><code>',
//				Html::text($r), '</code></a>.';
//		}
		echo ' - Site administrator <a href="mailto:salsi@icosaedro.it">',
			'Umberto Salsi</a>';
		echo '</small></BODY></HTML>';
	}

	/**
	 * 
	 * @param string $icon_resource
	 * @param string $title_html
	 * @param string $msg_html
	 */
	static function info_box($icon_resource, $title_html, $msg_html)
	{
		echo
			"<div style='border: 0.2em solid black; margin: 1em; padding: 0em;'>",
			"<table cellpadding=5><tr>",
			"<td valign=top><img src='$icon_resource'></td>",
			"<td valogn=top><big><b>$title_html</b></big><p>$msg_html</td>",
			"</tr></table>",
			"</div>";
	}

	/**
	 * 
	 * @param string $icon
	 * @param string $title
	 * @param string $msg
	 */
	static function information($icon, $title, $msg)
	{
		self::echoPageHeader();
		self::info_box($icon, $title, $msg);
		UserSession::formOpen();
		echo CENTER;
		UserSession::button("OK", UserSession::class . "::invokeCallBackward");
		echo CENTER_;
		UserSession::formClose();
		self::echoPageFooter();
	}

	/**
	 * 
	 * @param string $msg
	 */
	static function error($msg)
	{
		self::information("/img/error.png", "Error", $msg);
	}

	/**
	 * 
	 * @param string $msg
	 */
	static function warning($msg)
	{
		self::information("/img/warning.png", "Warning", $msg);
	}

	/**
	 * 
	 * @param string $msg
	 */
	static function notice($msg)
	{
		self::information("/img/notice.png", "Notice", $msg);
	}
	
	/**
	 * Confirmation dialog with false/no/cancel and true/yes/ok button.
	 * When the user chooses the button, the false or true value is passed
	 * as additional argument to the backward call in the bt stack.
	 * @param string $title Title of the dialog box, HTML encoded.
	 * @param string $msg Operaion requiring confirmation, HTML encoded.
	 * @param string $false_button False/no/cancel button caption.
	 * @param string $true_button True/yes/ok button caption.
	 */
	static function confirm($title, $msg, $false_button, $true_button)
	{
		self::echoPageHeader();
		UserSession::formOpen();
		self::info_box("/img/warning.png", $title, $msg);
		echo VSPACE;
		UserSession::button($false_button, UserSession::class . "::invokeCallBackward", FALSE);
		echo HSPACE;
		UserSession::button($true_button, UserSession::class . "::invokeCallBackward", TRUE);
		UserSession::formClose();
		self::echoPageFooter();
	}
	
	/**
	 * If user's preferred TZ has already been set in cache.
	 * @var boolean
	 */
	private static $cached_tz_set = FALSE;
	
	/**
	 * Current user's preferred TZ (minutes).
	 * @var int
	 */
	private static $cached_tz_minutes = 0;
	
	private static $cached_tz_name = "+00:00";
	
	/**
	 * Retrieves the current user preferred TZ.
	 * @return int User's preferred TZ (minutes).
	 */
	static function getTZMinutes()
	{
		if( ! self::$cached_tz_set ){
			$tz = self::$cached_tz_minutes = (int) UserSession::getUserPreferenceParameter("tz_minutes", "0");
			self::$cached_tz_name = sprintf("%+03d:%02d", intdiv($tz, 60), (int)abs((float)$tz)%60);
			self::$cached_tz_set = TRUE;
		}
		return self::$cached_tz_minutes;
	}
	
	/**
	 * Set current user preferred TZ.
	 * @param int $tz_minutes
	 */
	static function setTZMinutes($tz_minutes)
	{
		UserSession::setUserPreferenceParameter("tz_minutes", "$tz_minutes");
	}
	
	/**
	 * Format the timestamp according to the current user's preferred TZ.
	 * @param int $ts Unix timestamp (seconds since 1970-01-01).
	 * @return string Formatted timestamp as "YYYY-MM-DD HH:mm +99:99".
	 */
	static function formatTS($ts)
	{
		$tz_minutes = self::getTZMinutes();
		$s = date("c", $ts + 60*$tz_minutes);
		return substr($s, 0, 10)." ".substr($s, 11, 5)." ". self::$cached_tz_name;
	}


}
