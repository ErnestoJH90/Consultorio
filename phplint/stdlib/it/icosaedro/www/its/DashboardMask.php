<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\bt_\Form;
use it\icosaedro\web\Http;
use it\icosaedro\web\Html;
use it\icosaedro\web\bt_\UserSession;
use RuntimeException;

/**
 * Dashboard for the Issues Tracking System (ITS) to list all the projects the
 * current user has access to. Admin users may create new projects.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/06 21:38:48 $
 */
class DashboardMask extends Form {
	
	/*. forward static void function enter(); .*/
	
	/**
	 * Actual render() method that may throw exception.
	 * @throws SQLException
	 */
	private function render_exception()
	{
		$im_admin = \it\icosaedro\www\Common::checkPermission(\it\icosaedro\www\Common::PERMISSION_IS_ADMIN);
		
		$user_id = Users::getCurrentUserID();
		
		if( $im_admin ){
			// Show all projects:
			$sql = "select name, id, modified_time, is_world_readable, users_may_subscribe from projects order by name";
		} else {
			// Show only projects world-readable or I'm member of:
			$sql = <<< EOT
select distinct
	projects.name,
	projects.id,
	projects.modified_time,
	projects.is_world_readable,
	projects.users_may_subscribe
from
	projects,
	permissions
where
	projects.is_world_readable
	or (
		projects.id = permissions.project_id
		and permissions.user_id = $user_id
	)
order by name
EOT;
		}
		
		$db = Common::getDB();
		$res = $db->query($sql);
		
		Http::headerContentTypeHtmlUTF8();
		echo "<html><body>";
		Common::echoNavBar(-1, -1);
		echo "<h2>Issues Tracking System</h2>";
		$this->open();
		echo "Projects:";
		if( $res->getRowCount() == 0 )
			echo "<center><i>No projects.</center>";
		for($i = 0; $i < $res->getRowCount(); $i++){
			$res->moveToRow($i);
			$id = $res->getIntByName("id");
			$name = $res->getStringByName("name");
			$modified_time = $res->getIntByName("modified_time");
			$is_world_readable = $res->getBooleanByName("is_world_readable");
			$users_may_subscribe = $res->getBooleanByName("users_may_subscribe");
			$stat = new Statistics($id);
			echo "<p>";
			$this->anchor(Html::text($name), "projectMaskButton", $id);
			echo ", ", $stat->total_issues, " issues total";
			echo ", ", $stat->open_issues, " open";
			echo ", ", $stat->open_assigned_issues, " open assigned";
			echo ", last updated ", \it\icosaedro\www\Common::formatTS($modified_time);
			echo ". Access: ";
			if( ! $is_world_readable )
				echo "<b>private</b> (only the granted members have access).";
			else if( ! $users_may_subscribe )
				echo "<b>protected</b> (granted members allowed only).";
			else
				echo "<b>public</b> (any user may read and any user except guests may subscribe as a member).";
		}
		echo "<p>";
		if( $im_admin )
			$this->button("Create New Project", "newProjectButton");
		$this->close();
		\it\icosaedro\www\Common::echoPageFooter();
	}
	
	function render()
	{
		UserSession::stackReset();
		try {
			$this->render_exception();
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
	
	function browserBackEvent()
	{
		\it\icosaedro\www\DashboardMask::enter();
	}
	
	function browserReloadEvent()
	{
		$this->render();
	}
	
	/**
	 * @param int $project_id
	 */
	function projectMaskButton($project_id)
	{
		ProjectDashboardMask::enter($project_id);
	}
	
	function newProjectButton()
	{
		ProjectMask::enter(-1);
	}

	static function enter()
	{
		$m = new self();
		$m->render();
	}
	
}
