<?php
/**
 * Single entry point of the Icosaedro Web Application, performing requests
 * routing to specific pages and bt_ dispatching.
 * Allows to access the IWA directly from the web, with or without a session.
 * Basically, if a bt_ session does already exit, process the request; if the
 * bt_ does not exit, the login page is served. Several special URL parameters
 * are also supported in order to serve some special pages:
 * 
 * <p><tt>https://www.icosaedro.it/iwa/index.php?p=MASK</tt>
 * <br>Serves the MASK page, one of "login", "registration", "forgot-password",
 * "login-as-a-guest"; this latter is not really a mask, but allows guest users
 * to bypass the login and land on the dashboard.</p>
 * 
 * <p><tt>https://www.icosaedro.it/iwa/index.php?comments=ENCODEDPAGE</tt>
 * <br>Serves comments bound to the specified page; the actual path of the page
 * is encoded; requests from logged-in and guest users are both supported.</p>
 * 
 * <p><tt>https://www.icosaedro.it/iwa/index.php?project_name=PRJ[&amp;issue_number=1234]</tt>
 * <br>Serves ITS pages related to the specified project; an issue number can
 * also be provided; requests from logged-in and guest users are both supported.</p>
 * <p>Before creating a guest session, a special temporary URL is sent to force
 * the browser to execute some JS code. This should prevent automated scanners
 * from wasting server resources creating useless guest sessions.</p>
 * 
 * @package index.php
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/10 17:36:16 $
 */
require_once __DIR__ . "/../../../../all.php";
use it\icosaedro\web\Log;
use it\icosaedro\web\Http;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\www\SiteSpecific;
use it\icosaedro\www\DashboardMask;
use it\icosaedro\www\user\LoginMask;
use it\icosaedro\www\user\RegistrationMask;
use it\icosaedro\www\user\ForgotPasswordMask;

Log::$logNotices = SiteSpecific::LOG_NOTICES;

/**
 * Last resort feedback page.
 * @param string $title
 * @access private
 */
function feedbackPage($title)
{
	Http::headerCacheControlNoStore();
	header("Content-Type: text/html");
	echo "<html><body><h1>$title</h1>",
	"Please try the login page <a href='", SiteSpecific::LOGIN_URL,
	"'>login page</a> to login or to recover a pending session.</body></html>";
}

/**
 * Scan-bots URL parameter trap. If the "age" parameter is present and valid,
 * returns TRUE. If the "age" parameter is missing, adds that parameter to a
 * temporary URL, then forces the browser to execute some JS to load that URL.
 * @return boolean True if the request is a valid temporary URL; processing may
 * continue. False if either the a temporary URL has been sent or an invalid or
 * expired URL has been received; processing of the request must stop here.
 */
function antiScannerCheckPassed()
{
	if( isset($_GET["age"]) ){
		$age = (int) $_GET["age"];
		$ok = time() - 10 < $age && $age <= time();
		if( ! $ok )
			feedbackPage("The temporary URL expired");
		return $ok;
	} else {
		$url = SiteSpecific::DISPATCHER_URL . "?" . $_SERVER["QUERY_STRING"]
			. "&age=" . time();
		Http::headerCacheControlNoStore();
		header("Content-Type: text/html");
		echo "<html><body><script>location='$url' + location.hash;</script></body>";
		return FALSE;
	}
}

try {
	
	// Check secure connection:
	if( SiteSpecific::REQUIRE_HTTPS && ! Http::isSecureConnection() ){
		// Lets UserSession fix this issue: destroy session, cookie and send
		// to the login page:
		Log::notice("unsafe connection detected - logout");
		new UserSession(
				NULL,
				SiteSpecific::BT_BASE_DIR,
				SiteSpecific::DISPATCHER_URL,
				SiteSpecific::LOGIN_URL,
				SiteSpecific::DASHBOARD_FUNCTION,
				TRUE
		);
		exit(0);
	}

	if( isset($_GET["p"]) ){
		$p = (string) $_GET["p"];
		if( $p === "login" ){
			(new LoginMask())->processRequest();
		} else if( $p === "registration" ){
			(new RegistrationMask())->processRequest();
		} else if( $p === "forgot-password" ){
			(new ForgotPasswordMask())->processRequest();
		} else if( $p === "login-as-a-guest" ){
			if( !antiScannerCheckPassed() )
				exit(0);
			LoginMask::createBtSessionForUser("guest");
			DashboardMask::enter();
		} else {
			feedbackPage("Invalid URL");
		}
		exit(0);
	}

	// Hack to intercept page comments request from the web page:
	if( isset($_GET['comments']) ){
		if( ! isset($_COOKIE[UserSession::COOKIE_NAME]) ){
			// No session. Create a guest session and jump to the comments:
			if( !antiScannerCheckPassed() )
				exit(0);
			LoginMask::createBtSessionForUser("guest");
			\it\icosaedro\www\comments\DirectAccess::enter();
		} else {
			// Session available. Recover session and jump to the comments:
			new UserSession(
					NULL,
					SiteSpecific::BT_BASE_DIR,
					SiteSpecific::DISPATCHER_URL,
					SiteSpecific::LOGIN_URL,
					\it\icosaedro\www\comments\DirectAccess::class . "::enter",
					SiteSpecific::REQUIRE_HTTPS
			);
		}

	// Hack to intercept project issues tracker request from the web page:
	} else if( isset($_GET['project_name']) ){
		if( ! isset($_COOKIE[UserSession::COOKIE_NAME]) ){
			// No session. Create a guest session and jump to the comments:
			if( !antiScannerCheckPassed() )
				exit(0);
			LoginMask::createBtSessionForUser("guest");
			\it\icosaedro\www\its\DirectAccess::enter();
		} else {
			// Session available. Recover session and jump to the comments:
			new UserSession(
					NULL,
					SiteSpecific::BT_BASE_DIR,
					SiteSpecific::DISPATCHER_URL,
					SiteSpecific::LOGIN_URL,
					\it\icosaedro\www\its\DirectAccess::class . "::enter",
					SiteSpecific::REQUIRE_HTTPS
			);
		}
		
	} else {
		// Regular bt_ postback dispatch:
		new UserSession(
				NULL,
				SiteSpecific::BT_BASE_DIR,
				SiteSpecific::DISPATCHER_URL,
				SiteSpecific::LOGIN_URL,
				SiteSpecific::DASHBOARD_FUNCTION,
				SiteSpecific::REQUIRE_HTTPS
		);
	}

}
catch(Exception $e){
	Log::error("$e");
	feedbackPage("Internal Server Error");
}