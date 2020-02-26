<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

/*. require_module 'json'; .*/

use it\icosaedro\sql\SQLDriverInterface;
use it\icosaedro\sql\SQLException;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\web\Html;
use it\icosaedro\www\SiteSpecific;
use RuntimeException;
use JsonException;

/**
 * Common tools for the ITS (Issues Tracking System). ITS has its own DB.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/02/04 07:47:23 $
 */
class Common {
	
	/**
	 * DB connection.
	 * @var SQLDriverInterface
	 */
	private static $cached_db;
	
	/**
	 * Estimated max SQL query length (bytes).
	 * @var int
	 */
	private static $cached_max_allowed_data = -1;
	
	/**
	 * Returns connection to the ITS DB. The result is cached.
	 * @return SQLDriverInterface
	 * @throws SQLException
	 */
	static function getDB()
	{
		if( self::$cached_db === NULL )
			self::$cached_db = new \it\icosaedro\sql\mysql\Driver(
				["localhost", "root", "", "its"]);
		return self::$cached_db;
	}
	
	/**
	 * Resets the cached DB connection. Invoking this method is recommended to
	 * continue recovering after an SQL exception, that may reset the connection.
	 */
	static function resetCachedDB()
	{
		self::$cached_db = NULL;
	}
	
	/**
	 * Returns the maximum allowed data packet size for a single SQL statement.
	 * SQL statements longer than that are rejected by MySQL with error code
	 * 10053. Workaround: either ensure the final SQL statement is shorter than
	 * that or use DB streamed access.
	 * @return int
	 * @throws SQLException
	 */
	static function getMaxAllowedPacket()
	{
		if( self::$cached_max_allowed_data >= 0 )
			return self::$cached_max_allowed_data;
		$db = self::getDB();
		$res = $db->query("SHOW VARIABLES like 'max_allowed_packet'");
		$res->moveToRow(0);
		return self::$cached_max_allowed_data = $res->getIntByName("Value");
	}
	
	/**
	 * Displays the ITS sub-section navigation bar.
	 * @param int $project_id Current project ID, or -1 if not selected.
	 * @param int $issue_number Current issue number, or -1 if not available.
	 */
	static function echoNavBar($project_id, $issue_number)
	{
		$window_title = "IWA \u{25ba} ITS";
		echo "<table width='100%' cellpadding=4 bgcolor='#dddddd'><tr><td>";
		echo "&emsp;";
		UserSession::anchor("IWA", "it\\icosaedro\\www\\DashboardMask::enter");
		echo " \u{25ba} ";
		UserSession::anchor("ITS", "it\\icosaedro\\www\\its\\DashboardMask::enter");
		if( $project_id >= 0 ){
			$p = Project::getCachedProject($project_id);
			$window_title .= " \u{25ba} " . $p->name;
			echo " \u{25ba} ";
			UserSession::anchor(Html::text($p->name), "it\\icosaedro\\www\\its\\ProjectDashboardMask::enter", $project_id);
			echo ":";
			
			$im_site_admin = \it\icosaedro\www\Common::checkPermission(\it\icosaedro\www\Common::PERMISSION_IS_ADMIN);
			if( $im_site_admin || $p->im_admin ){
				echo "&emsp;";
				UserSession::anchor("Management", "it\\icosaedro\\www\\its\\ProjectMask::enter", $project_id);
			}
			
			echo "&emsp;";
			UserSession::anchor("Quick Search", "it\\icosaedro\\www\\its\\SearchQuickMask::enter", $project_id);
			
			echo "&emsp;";
			UserSession::anchor("Advanced Search", "it\\icosaedro\\www\\its\\SearchMask::enter", $project_id);
			
			if( $p->im_member ){
				echo "&emsp;";
				UserSession::anchor("New Issue", "it\\icosaedro\\www\\its\\CreateIssueMask::enter", $project_id);
			}
		}
		
		// Build a context aware "New Window" link:
		if( $project_id < 0 ){
			$url_params = "";
		} else {
			$p = Project::getCachedProject($project_id);
			$url_params = "?project_name=" . urlencode($p->name);
			if( $issue_number >= 0 )
				$url_params .= "&issue_number=$issue_number";
		}
		echo "</td><td align=right><a href='", SiteSpecific::DISPATCHER_URL,
			"$url_params' target=_blank>New Window</a>";
		
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
	
}
