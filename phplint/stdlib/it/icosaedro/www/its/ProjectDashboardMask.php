<?php

namespace it\icosaedro\www\its;
require_once __DIR__ . "/../../../../all.php";
use it\icosaedro\sql\SQLException;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\web\bt_\Form;
use it\icosaedro\web\Http;
use it\icosaedro\web\Html;
use RuntimeException;

/**
 * Project dashboard displaying a summary of the project.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/09 15:48:55 $
 */
class ProjectDashboardMask extends Form {
	
	/*. forward static void function enter(int $project_id); .*/
	
	/**
	 * @var int
	 */
	private $project_id = 0;
	
	/**
	 * Number of the latest view issue. Latest view issue is highlighted in the
	 * list to help finding the next one to view. Negative if not available.
	 * @var int
	 */
	private $latest_view_issue_number = 0;
	
	/**
	 * ID of the latest comment view. Latest view comment is highlighted in the
	 * list to help finding the next one to view. Negative if not available.
	 * @var int
	 */
	private $latest_view_comment_id = 0;
	
	function __construct()
	{
		parent::__construct();
	}
	
	function save()
	{
		parent::save();
		$this->setData("project_id", $this->project_id);
		$this->setData("latest_view_issue_number", $this->latest_view_issue_number);
		$this->setData("latest_view_comment_id", $this->latest_view_comment_id);
	}
	
	function resume()
	{
		parent::resume();
		$this->project_id = (int) $this->getData("project_id");
		$this->latest_view_issue_number = (int) $this->getData("latest_view_issue_number");
		$this->latest_view_comment_id = (int) $this->getData("latest_view_comment_id");
	}
	
	/**
	 * @param float $fraction Open issues fraction in [0.0,1.0].
	 */
	private static function echoFever($fraction)
	{
		$bar_len = 20.0; // "em" units
		$red_len = $fraction*$bar_len;
		if( $red_len < 0.5 && $fraction > 0 )
			$red_len = 0.5;
		else if( $red_len > $bar_len - 0.5 && $fraction < 1.0 )
			$red_len = $bar_len - 0.5;
		if( $red_len > 0 )
			echo "<span style='display: inline-block; border: solid 1px black; width: ", $red_len, "em; height: 0.8em; background-color: #ff6666;'></span>";
		if( $red_len < $bar_len )
			echo "<span style='display: inline-block; border: solid 1px black; width: ", ($bar_len - $red_len), "em; height: 0.8em; background-color: #55aa55;'></span>";
		echo " ", (int) (100 * $fraction + 0.5), "%";
	}
	
	
	/**
	 * Actual render() method that may throw exception.
	 * @throws SQLException
	 */
	private function render_exception()
	{
		$p = Project::getCachedProject($this->project_id);
		$s = new Statistics($this->project_id);

		$db = Common::getDB();
		
		// Retrieve admins names:
		$sql = <<< EOT
			select
				u.current_name
			from
				icodb.users as u,
				permissions as p
			where
				p.project_id = ?
				and p.is_admin
				and u.pk = p.user_id
			order by current_name
EOT;
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $this->project_id);
		$res = $ps->query();
		$admins = "";
		for($i = 0; $i < $res->getRowCount(); $i++){
			if( strlen($admins) > 0 )
				$admins .= ", ";
			$res->moveToRow($i);
			$admins .= $res->getStringByName("current_name");
		}

		// Retrieve summary latest submitted issues:
		$sql = <<< EOT
select
	number,
	created_time,
	is_open,
	category,
	tags,
	subject,
	assigned_to,
	icodb.users.current_name as user_name
from
	issues
left join
	icodb.users
on icodb.users.pk = assigned_to
where
	project_id=?
	and created_time >= ?
order by created_time desc limit 10
EOT;
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $this->project_id);
		$ps->setInt(1, time() - 15*24*86400); // search up to 15 days ago
		$latest_issues = $ps->query();

		// Retrieve summary latest messages added to the project:
		$sql = <<< EOT
select
	issues.number,
	issues.is_open,
	issues.category,
	issues.tags,
	issues.subject,
	messages.id,
	messages.created_time,
	messages.created_by,
	icodb.users.current_name as user_name
from
	issues, messages
left join
	icodb.users
on
	icodb.users.pk = messages.created_by
where
	messages.project_id = ?
	and issues.project_id = ?
	and messages.created_time >= ?
	and issues.number = messages.issue_number
order by messages.created_time desc limit 10
EOT;
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $this->project_id);
		$ps->setInt(1, $this->project_id);
		$ps->setInt(2, time() - 15*24*86400); // search up to 15 days ago
		$latest_messages = $ps->query();
			
		Http::headerContentTypeHtmlUTF8();
		echo "<html><body>";
		Common::echoNavBar($this->project_id, -1);
		echo "<h2>", Html::text($p->name), " Project</h2>";
		$this->open();
		echo nl2br( Html::text($p->description) );
		FolderDownload::render($p->folder_id);
		echo "<br>Administrators: ", Html::text($admins), ".";
		echo " Created: ", \it\icosaedro\www\Common::formatTS($p->created_time), ".";
		echo " Modified: ", \it\icosaedro\www\Common::formatTS($p->modified_time), ".";
		echo "<br>Issues summary: ", $s->total_issues, " total, ",
			$s->open_issues, " open, ",
			$s->open_assigned_issues, " assigned. ";
		if( $s->total_issues > 0 )
			self::echoFever((float)$s->open_issues / $s->total_issues);
		
		$url = DirectAccess::directLink($this->project_id, -1);
		echo "<br>Direct access URL: <a href='", Html::text($url), "'>", Html::text($url), "</a>";
		if( ! $p->is_world_readable )
			echo " (members only)";
		echo "<p>";
		
		if( $p->users_may_subscribe ){
			if( $p->im_admin )
				echo "<p><b>I'm administrator</b> of this project, then I may access the management page and I may set all the project properties and permissions.</p>";
			if( $p->im_member ){
				$this->button("Unsubscribe", "unsubscribeButton");
				echo " from this project, I don't want to receive email notifications anymore about new issues and new comments and I don't want to add new issues nor comments. I may re-subscribe later, though.";
				if( $p->im_admin )
					echo " BEWARE. By unsubscribing, I will loose the project administrator permissions; only another project administrator or the site administrator may restore this status again.";
				
			} else if( ! \it\icosaedro\www\Common::isGuest() ){
				$this->button("Subscribe", "subscribeButton");
				echo " myself to this project, so that I may add new issues and new comments and I will receive email notifications about new issues and new comments (a valid email must be set in the preferences in order this to work). I may unsubscribe later, though.";
			}
		}
		
		// Display latest submitted issues:
		if( $latest_issues->getRowCount() > 0 ){
			echo "<h3>Latest submitted issues</h3>";
			echo "<table cellspacing=0 cellpadding=3 border=0><tr bgcolor='#aaaaaa'><th>Created</th><th>Status</th><th>Category</th><th>Tags</th><th>Number</th><th>Subject</th><th>Assigned to</th></tr>";
			for($i = 0; $i < $latest_issues->getRowCount(); $i++){
				$latest_issues->moveToRow($i);
				$number = $latest_issues->getIntByName("number");
				$created_time = $latest_issues->getIntByName("created_time");
				$status = $latest_issues->getBooleanByName("is_open");
				$category = FieldCategory::codeToName($latest_issues->getIntByName("category"));
				$tags = $latest_issues->getStringByName("tags");
				$subject = $latest_issues->getStringByName("subject");
				$assigned_to = $latest_issues->getIntByName("assigned_to");
				if( $latest_issues->wasNull() )
					$assigned_to = -1;
				$user_name = $latest_issues->getStringByName("user_name");
				if( $user_name === NULL && $assigned_to > 0 )
						$user_name = "[delete user ID $assigned_to]"; // displays ID of deleted user
				if( $number == $this->latest_view_issue_number )
					$bgcolor = "bgcolor='#bbffbb'";
				else if( ($i & 1) == 1 )
					$bgcolor = "bgcolor='#dddddd'";
				else
					$bgcolor = "";
				echo "<tr $bgcolor><td>", \it\icosaedro\www\Common::formatTS($created_time);
				echo "</td><td>", ($status? "OPEN" : "CLOSED");
				echo "</td><td>$category";
				echo "</td><td>", Html::text($tags);
				echo "</td><td align=right>", $number;
				echo "</td><td>";
				$this->anchor(Html::text($subject), "viewIssueButton", $number);
				echo "</td><td>", ($user_name === NULL? "<i>nobody</i>" : Html::text($user_name));
				echo "</td></tr>";
			}
			echo "</table>";
		}
		
		// Display latest messages:
		if( $latest_messages->getRowCount() > 0 ){
			echo "<h3>Latest added messages</h3>";
			echo "<table cellspacing=0 cellpadding=3 border=0><tr bgcolor='#aaaaaa'><th>Date</th><th>Status</th><th>Category</th><th>Tags</th><th>Number</th><th>Subject</th><th>Submitted by</th></tr>";
			for($i = 0; $i < $latest_messages->getRowCount(); $i++){
				$latest_messages->moveToRow($i);
				$comment_id = $latest_messages->getIntByName("id");
				$created_time = $latest_messages->getIntByName("created_time");
				$created_by = $latest_messages->getIntByName("created_by");
				$user_name = $latest_messages->getStringByName("user_name");
				if( $user_name === NULL )
						$user_name = "[deleted user ID $created_by]"; // displays ID of deleted user
				$message_subject = $latest_messages->getStringByName("subject");
				$issue_number = $latest_messages->getIntByName("number");
				$status = $latest_messages->getBooleanByName("is_open");
				$category = FieldCategory::codeToName($latest_messages->getIntByName("category"));
				$tags = $latest_messages->getStringByName("tags");
				if( $comment_id == $this->latest_view_comment_id )
					$bgcolor = "bgcolor='#bbffbb'";
				else if( ($i & 1) == 1 )
					$bgcolor = "bgcolor='#dddddd'";
				else
					$bgcolor = "";
				echo "<tr $bgcolor><td>", \it\icosaedro\www\Common::formatTS($created_time);
				echo "</td><td>", ($status? "OPEN" : "CLOSED");
				echo "</td><td>$category";
				echo "</td><td>", Html::text($tags);
				echo "</td><td align=right>$issue_number";
				echo "</td><td>";
				$this->anchor(Html::text($message_subject), "viewCommentButton", $issue_number, $comment_id);
				echo "</td><td>", Html::text($user_name), "</td></tr>";
			}
		}
		echo "</table>";
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
		DashboardMask::enter();
	}
	
	/**
	 * @param int $issue_number
	 */
	function viewIssueButton($issue_number)
	{
		$this->latest_view_issue_number = $issue_number;
		$this->returnTo("render");
		IssueMask::enter($this->project_id, $issue_number, NULL);
	}
	
	/**
	 * View issue page and scroll to the specific comment.
	 * @param int $issue_number
	 * @param int $comment_id Comment ID of the comment to jump at.
	 */
	function viewCommentButton($issue_number, $comment_id)
	{
		$this->latest_view_comment_id = $comment_id;
		$this->returnTo("render");
		IssueMask::enter($this->project_id, $issue_number, "comment_$comment_id");
	}
	
	/**
	 * Subscribe the current user as a member of this project.
	 */
	function subscribeButton()
	{
		try {
			$db = Common::getDB();
			$ps = $db->prepareStatement("insert into permissions (project_id, user_id, is_admin) values(?,?,?)");
			$ps->setInt(0, $this->project_id);
			$ps->setInt(1, Users::getCurrentUserID());
			$ps->setBoolean(2, FALSE);
			$ps->update();
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		$this->render();
	}
	
	/**
	 * Delete membership from this project.
	 */
	function unsubscribeButton()
	{
		try {
			$db = Common::getDB();
			$ps = $db->prepareStatement("delete from permissions where project_id = ? and user_id = ?");
			$ps->setInt(0, $this->project_id);
			$ps->setInt(1, Users::getCurrentUserID());
			$ps->update();
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		$this->render();
	}
	
	/**
	 * Entry point of this mask.
	 * @param int $project_id
	 */
	static function enter($project_id)
	{
		$m = new self();
		$m->project_id = $project_id;
		$m->render();
	}
	
}
