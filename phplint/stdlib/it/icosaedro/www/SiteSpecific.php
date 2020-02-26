<?php
namespace it\icosaedro\www;
require_once __DIR__ . "/../../../all.php";
use it\icosaedro\sql\SQLDriverInterface as SQLDriver;
use it\icosaedro\sql\SQLException;

/**
 * Site specific parameters and constants. This file is intended to collect
 * values and features that are specific of each execution environment, for
 * example the test site and the production site.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/30 12:00:19 $
 */
class SiteSpecific {
	
	/** Notices should be enabled only for debugging. */
	const LOG_NOTICES = FALSE;
	
	/**
	 * Important events are notified to this email address.
	 * Events include: new registered user, new message.
	 * Comma separated list of addresses also allowed.
	 * Empty string to disable sending email.
	 */
	const ADMIN_EMAIL = "salsi@icosaedro.it";
	
	/**
	 * If HTTPS secure connection is required.
	 */
	const REQUIRE_HTTPS = TRUE;
	
	/**
	 * Base URL of all the pages.
	 */
	const WEB_BASE = "https://www.icosaedro.it/iwa";
	
	/**
	 * Document root path of the web site.
	 */
	const PATH_BASE = "/home/www.icosaedro.it/public_html";
	
	/**
	 * Bt_ working directory. BEWARE: this directory must be located outside
	 * the document root of the web server as it contains users' session
	 * sensitive data!
	 */
	const BT_BASE_DIR = "/home/www.icosaedro.it/BT_STATE";
	
	/**
	 * URL of the IWA routing and bt_ dispatcher page. This is the only
	 actual web page users will see.
	 */
	const DISPATCHER_URL = self::WEB_BASE . "/index.php";
	
	/** URL of the login page. */
	const LOGIN_URL = self::DISPATCHER_URL . "?p=login";
	
	/** URL of the user's self-registration form. */
	const REGISTRATION_URL = self::DISPATCHER_URL . "?p=registration";
	
	/** Forgotten password recovery form. */
	const FORGOT_PASSWORD_URL = self::DISPATCHER_URL . "?p=forgot-password";
	
	const LOGIN_AS_A_GUEST_URL = self::DISPATCHER_URL . "?p=login-as-a-guest";
	
	/** Landing page function after login. */
	const DASHBOARD_FUNCTION = "it\\icosaedro\\www\\DashboardMask::enter";
	
	/**
	 * SMTP server connection string used by it\icosaedro\email\Mailer.
	 */
	const MAILER_HOSTS = "localhost";
	
	/**
	 * Cached database connection.
	 * @var SQLDriver
	 */
	private static $cached_db;

	/**
	 * Returns an instance of the icodb database connection. The result is cached.
	 * If the connection fails, the general database check and creation is
	 * invoked in an attempt to create the initial structure. If even this
	 * fails, it is a fatal error.
	 * @return SQLDriver
	 * @throws SQLException
	 */
	static function getDB()
	{
		if( self::$cached_db !== NULL )
			return self::$cached_db;
		try {
			// Regular direct access to existing database:
			self::$cached_db = new \it\icosaedro\sql\mysql\Driver(array("localhost", "root", "", "icodb"));
		}
		catch(SQLException $e){
			// Try again checking and possibly creating the database:
			self::$cached_db = DBManagement::checkAll();
		}
		return self::$cached_db;
	}
}
