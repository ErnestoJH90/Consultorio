<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\Log;
use it\icosaedro\www\SiteSpecific;

/**
 * Allows direct access to the project dashboard or project issue from the web
 * pages. It is assumed the URL have the "project_name" and possibly the
 * "issue_number" parameters, like in the following example:
 * <pre>https://www.icosaedro.it/iwa/index.php?project_name=PRJ[&amp;issue_number=1234]</pre>
 * The request handler should detect the "project_name" parameter then it should
 * create a bt_ user's session, and finally invoke the enter() method to let the
 * user land on the requested mask.
 * 
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/30 05:19:34 $
 */
class DirectAccess {
	
	/**
	 * Returns the direct URL to the project dashboard or issue. If the project
	 * is world-readable, anyone from the web can access this URL, otherwise
	 * only logged-in members are allowed.
	 * @param int $project_id Project ID.
	 * @param int $issue_number Issue number, or -1 for the project dashboard.
	 */
	static function directLink($project_id, $issue_number)
	{
		$p = Project::getCachedProject($project_id);
		$url = SiteSpecific::DISPATCHER_URL . "?project_name=" . urlencode($p->name);
		if( $issue_number >= 0 )
			$url .= "&issue_number=$issue_number";
		return $url;
	}
	
	/**
	 * Something went wrong either in the request or in the server.
	 * @param string $msg
	 */
	private static function error($msg)
	{
		Log::error(__FILE__ . ": $msg");
		header("Content-Type: text/plain; charset=UTF-8");
		echo "ERROR: $msg";
	}
	
	/**
	 * Direct access from the request handler. It is assumed the URL contains
	 * the name of the requested project in the "project_name" parameter, and
	 * possibly the issue number in the "issue_number" parameter. If only the
	 * project name is given, lands on the project dashboard. If the issue
	 * number is also given, lands on the issue mask.
	 * @throws SQLException
	 */
	static function enter()
	{
		// Retrieve project ID base on the name and current user permissions:
		if( ! isset($_GET['project_name']) ){
			self::error("missing project_name in URL");
			return;
		}
		$project_name = (string) $_GET['project_name'];
		$user_id = Users::getCurrentUserID();
		$db = Common::getDB();
		$sql = <<< EOT
select distinct projects.id
from projects, permissions
where
	projects.name = ?
    and (
        projects.is_world_readable
    	or projects.id = permissions.project_id and permissions.user_id = ?
    )
EOT;
		$ps = $db->prepareStatement($sql);
		$ps->setString(0, $project_name);
		$ps->setInt(1, $user_id);
		$res = $ps->query();
		if( $res->getRowCount() == 0 ){
			self::error("no this project or no permissions: $project_name");
			return;
		}
		$res->moveToRow(0);
		$project_id = $res->getIntByName("id");
		
		// Retrieve issue number:
		$issue_number = -1;
		if( isset($_GET['issue_number']) ){
			$issue_number = (int) $_GET['issue_number'];
			$res = $db->query("select number from issues where project_id=$project_id and number=$issue_number");
			if( $res->getRowCount() == 0 ){
				self::error("$project_name: no this issue number: $issue_number");
				return;
			}
		}
		
		if( $issue_number >= 0 )
			IssueMask::enter($project_id, $issue_number, NULL);
		else
			ProjectDashboardMask::enter($project_id);
	}
}
