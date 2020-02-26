<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\controls\CheckBox;
use it\icosaedro\web\controls\Line;
use it\icosaedro\web\controls\LineCombo;
use it\icosaedro\web\controls\Text;
use it\icosaedro\web\controls\Select;
use it\icosaedro\web\bt_\Form;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\web\Http;
use it\icosaedro\web\Html;
use it\icosaedro\web\Log;
use it\icosaedro\www\SiteSpecific;
use it\icosaedro\containers\BooleanClass;
use it\icosaedro\containers\IntClass;
use RuntimeException;
use UnexpectedValueException;

/*. require_module 'pcre'; .*/

/**
 * Displays an issue, allowing to change its status and to add a new comment
 * depending on the current user's permissions.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/30 16:54:04 $
 */
class IssueMask extends Form {
	
	/*. forward static void function enter(int $project_id, int $issue_number, string $scroll_at); .*/
	
	/**
	 * Project ID.
	 * @var int
	 */
	private $project_id = 0;
	
	/**
	 * Issue number.
	 * @var int
	 */
	private $issue_number = 0;
	
	/**
	 * Issue modified timestamp to detect concurrent changes while saving a new
	 * comment.
	 * @var int
	 */
	private $modified_time = 0;
	
	/**
	 * Issue current status: TRUE (open) or FALSE (closed).
	 * @var boolean
	 */
	private $status = FALSE;
	
	/**
	 * Issue current category.
	 * @var int
	 */
	private $category = 0;
	
	/**
	 * Issue current tags.
	 * @var string
	 */
	private $tags;
	
	/**
	 * Issue current subject.
	 * @var string
	 */
	private $subject;
	
	/**
	 * Issue currently assigned to ID.
	 * @var int
	 */
	private $assigned_to = 0;
	
	/**
	 * Issue currently assigned to user name.
	 * @var string
	 */
	private $assigned_to_user_name;
	
	/**
	 * If the "add comment" input area is visible.
	 * @var CheckBox
	 */
	private $add_comment_is_visible;
	
	/**
	 * Changed status.
	 * @var Select
	 */
	private $changed_status;
	
	/**
	 * Changed category.
	 * @var Select
	 */
	private $changed_category;
	
	/**
	 * @var LineCombo
	 */
	private $changed_tags;
	
	/**
	 * Changes assigned-to.
	 * @var Select
	 */
	private $changed_assigned_to;
	
	/**
	 * Changed subject.
	 * @var Line
	 */
	private $changed_subject;
	
	/**
	 * Content of the added comment.
	 * @var Text
	 */
	private $content;
	
	/**
	 * Files folder panel.
	 * @var FolderUploadPanel
	 */
	private $folder_panel;
	
	/**
	 * Name of the inner target anchor of the page to scroll at. Possible values
	 * are:
	 * - NULL: ignored.
	 * - "comment_ID" where ID is the ID of the comment.
	 * - "add_comment" for the "add comment" area.
	 * @var string
	 */
	private $scroll_at;
	
	function __construct()
	{
		parent::__construct();
		
		$this->add_comment_is_visible = new CheckBox($this, "add_comment", "Add comment to this issue");
		$this->add_comment_is_visible->setChecked(FALSE);
		
		$this->changed_status = new Select($this, "changed_status");
		$this->changed_status->addValue("OPEN", BooleanClass::getInstance(TRUE));
		$this->changed_status->addValue("CLOSED", BooleanClass::getInstance(FALSE));
		
		$this->changed_category = new Select($this, "changed_category");
		FieldCategory::fillMenu($this->changed_category);
		
		$this->changed_tags = new LineCombo($this, "changed_tags");
		
		$this->changed_assigned_to = new Select($this, "changed_assigned_to");
		$this->changed_assigned_to->addValue("--", new IntClass(-1));
		$this->changed_assigned_to->setValue(new IntClass(-1));
		
		$this->changed_subject = new Line($this, "changed_subject");
		$this->content = new Text($this, "content");
		$this->folder_panel = new FolderUploadPanel($this, "folder");
	}
	
	function save()
	{
		parent::save();
		$this->setData("project_id", $this->project_id);
		$this->setData("issue_number", $this->issue_number);
		$this->setData("modified_time", $this->modified_time);
		$this->setData("status", $this->status);
		$this->setData("category", $this->category);
		$this->setData("tags", $this->tags);
		$this->setData("assigned_to", $this->assigned_to);
		$this->setData("assigned_to_user_name", $this->assigned_to_user_name);
		$this->setData("subject", $this->subject);
		$this->setData("scroll_at", $this->scroll_at);
	}
	
	function resume()
	{
		parent::resume();
		$this->project_id = (int) $this->getData("project_id");
		$this->issue_number = (int) $this->getData("issue_number");
		$this->modified_time = (int) $this->getData("modified_time");
		$this->status = (boolean) $this->getData("status");
		$this->category = (int) $this->getData("category");
		$this->tags = (string) $this->getData("tags");
		$this->assigned_to = (int) $this->getData("assigned_to");
		$this->assigned_to_user_name = (string) $this->getData("assigned_to_user_name");
		$this->subject = (string) $this->getData("subject");
		$this->scroll_at = cast("string", $this->getData("scroll_at"));
		$this->changed_tags->setList(FieldTags::getCachedTagsForProject($this->project_id));
		Users::fillMembersMenu($this->project_id, $this->changed_assigned_to);
	}
	
	/**
	 * Render the "Add comment" input area.
	 * @param string $err Input validation errors.
	 */
	private function render_add_comment_area($err = NULL)
	{
		// Checkbox to make visible/invisible the "add comment" area:
		echo "<br><br>",
			"<a name=add_comment></a>",
			"<fieldset id=addCommentArea style='background-color: #dddddd;'>",
			"<legend>";
		$this->add_comment_is_visible->addAttributes("id=addCommentCheckbox onclick='setVisibilityToggle(\"addCommentCheckbox\", \"addCommentDiv\");'");
		$this->add_comment_is_visible->render();
		echo "</legend>";
		echo "<div id=addCommentDiv>";
		// Make the "add comment" input area visible according to the checkbox:
		echo "<script>setVisibilityToggle(\"addCommentCheckbox\", \"addCommentDiv\");</script>";
		
		// Validation errors go into the "add comment" area only:
		if( strlen($err) > 0 ){
			Html::errorBox($err);
			// Ensure the error message be visible:
			echo "<script> document.getElementById('addCommentArea').scrollIntoView(); </script>";
		}
		
		echo "<p>Issue <big><b>#", $this->issue_number, "</b></big>";

		echo "&emsp;Status: ";
		$this->changed_status->addAttributes("onchange='setStyleOnChange(this);'");
		$this->changed_status->render();
		
		echo "&emsp;Category: ";
		$this->changed_category->addAttributes("onchange='setStyleOnChange(this);'");
		$this->changed_category->render();
		
		echo "&emsp;Tags: ";
		$this->changed_tags->addAttributes("oninput='setStyleOnChange(this);'");
		$this->changed_tags->render();

		echo "&emsp;Assigned to: ";
		$this->changed_assigned_to->addAttributes("onchange='setStyleOnChange(this);'");
		$this->changed_assigned_to->render();

		echo "<p>Subject: ";
		$this->changed_subject->addAttributes("size=50 oninput='setStyleOnChange(this);'");
		$this->changed_subject->render();
		
		echo "<p>";
		$this->content->addAttributes("cols=80 rows=15");
		$this->content->render();
		$this->folder_panel->render();
		
		echo "<p>";
		$this->button("  Save  ", "saveButton");
		
		echo "</div></fieldset>";
	}
	
	/**
	 * Searches and replaces references to other issue numbers "#9999" with
	 * direct links to their issue pages.
	 * @param string $text HTML text of the comment.
	 * @return string Same comment but with rendered issues references.
	 */
	private function renderizeReferencesToOtherIssues($text)
	{
		$p = Project::getCachedProject($this->project_id);
		$name_encoded = urlencode($p->name);
		$regex = "/(^|[^&])#(\\d++)\\b/";
		$replacement = "<a target=_blank href='" . SiteSpecific::DISPATCHER_URL
			. "?project_name=$name_encoded&issue_number=\\2'>#\\2</a>";
		return preg_replace($regex, $replacement, $text, 50);
	}
	
	/**
	 * Actual render() method that may throw exception.
	 * @param string $err
	 * @throws SQLException
	 */
	private function render_exception($err = NULL)
	{
		$p = Project::getCachedProject($this->project_id);
		$db = Common::getDB();
		$sql = <<< EOT
select
	id,
	created_time,
	created_by,
	diff,
	content,
	folder_id,
	icodb.users.current_name as user_name
from messages
left join icodb.users
on created_by = icodb.users.pk
where
	project_id = ?
	and issue_number = ?
order by created_time asc
EOT;
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $this->project_id);
		$ps->setInt(1, $this->issue_number);
		$comments = $ps->query();
		
		Http::headerContentTypeHtmlUTF8();
		echo "<html><head>";
		
		// If allowed to submit, load styles and JS for the input mask:
		if( $p->im_member )
			include_once __DIR__ . "/FormStylesAndJS.php";
		
		echo "</head><body>";
		Common::echoNavBar($this->project_id, $this->issue_number);
		
		// Display general issue status fields:
		$this->open();
		echo "Issue <big><b>#" . $this->issue_number . "</b></big>";
		echo "&emsp;Status: <b>", ($this->status? "OPEN</b>" : "CLOSED</b>");
		echo "&emsp;Category: <b>", FieldCategory::codeToName($this->category), "</b>";
		echo "&emsp;Tags: <b>", Html::text($this->tags), "</b>";
		echo "&emsp;Assigned to: <b>", ($this->assigned_to_user_name === NULL? "<i>nobody</i>" : Html::text($this->assigned_to_user_name)), "</b>";
		echo "<br>Subject: <big><b>", Html::text($this->subject), "</b></big>";
		$url = DirectAccess::directLink($this->project_id, $this->issue_number);
		echo "<br>Direct access URL: <a href='", Html::text($url), "'>", Html::text($url), "</a>";
		if( ! $p->is_world_readable )
			echo " (members only)";
		
		// Displays comments sorted by ascending date:
		for($i = 0; $i < $comments->getRowCount(); $i++){
			$comments->moveToRow($i);
			$comment_id = $comments->getIntByName("id");
			$created_time = $comments->getIntByName("created_time");
			$created_by = $comments->getIntByName("created_by");
			$diff = $comments->getStringByName("diff");
			$user_name = $comments->getStringByName("user_name");
			if( $user_name === NULL )
				$user_name = "[deleted user ID $created_by]";
			$content = $comments->getStringByName("content");
			$folder_id = $comments->getIntByName("folder_id");
			if( $comments->wasNull() )
				$folder_id = -1;
			$target = "comment_$comment_id";
			if( $target === $this->scroll_at )
				$bgcolor = "style='background-color: #ddddff;'";
			else
				$bgcolor = '';
			// Date, time and user name:
			echo "<br><hr><a name=$target><span $bgcolor><b>", \it\icosaedro\www\Common::formatTS($created_time);
			echo "&emsp;", Html::text($user_name), "</b></span></a><br>";
			// Differences:
			if( strlen($diff) > 0 )
				echo "<pre style='background-color: #ffff99; margin: 0; padding: 0.5em;'>",
					Html::text($diff), "</pre>";
			// Content:
			// Split long lines, but preserves white spaces and horizontal tab:
			echo "<pre style=\"white-space: pre-wrap; margin-top: 0;\">",
				$this->renderizeReferencesToOtherIssues( Html::text($content) ),
				"</pre>";
			FolderDownload::render($folder_id);
		}
		
		if( $p->im_member )
			$this->render_add_comment_area($err);
		
		$this->close();
		
		// Scroll to the requested target in this page. If the "add comment"
		// area is visible, jump to that anyway.
		if( $this->add_comment_is_visible->isChecked() )
			$target = "add_comment";
		else
			$target = $this->scroll_at;
		if( $target !== NULL )
			echo "<script> location.hash = '#$target'; </script>";
		
		\it\icosaedro\www\Common::echoPageFooter();
	}
	
	/**
	 * @param string $err
	 */
	function render($err = NULL)
	{
		try {
			$this->render_exception($err);
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
	
	/**
	 * Retrieves from DB the state of the issue. This must be done entering the
	 * mask and whenever the user saves its new comment but the issue state
	 * changed in the meanwhile and the user must be warned about that.
	 */
	private function retrieveIssue()
	{
		try {
			$db = Common::getDB();
			$sql = <<< EOT
select
	is_open,
	modified_time,
	category,
	tags,
	subject,
	assigned_to,
	icodb.users.current_name as user_name
from issues
left join icodb.users
on icodb.users.pk = assigned_to
where project_id=? and number=?
EOT;
			$ps = $db->prepareStatement($sql);
			$ps->setInt(0, $this->project_id);
			$ps->setInt(1, $this->issue_number);
			$issue = $ps->query();
			$issue->moveToRow(0);
			$this->status = $issue->getBooleanByName("is_open");
			$this->modified_time = $issue->getIntByName("modified_time");
			$this->category = $issue->getIntByName("category");
			$this->tags = $issue->getStringByName("tags");
			$this->subject = $issue->getStringByName("subject");
			$this->assigned_to = $issue->getIntByName("assigned_to");
			if( $issue->wasNull() ){
				// Not assigned.
				$this->assigned_to = -1;
				$this->assigned_to_user_name = NULL;
			} else {
				// Assigned.
				$this->assigned_to_user_name = $issue->getStringByName("user_name");
				if( $this->assigned_to_user_name === NULL ){
					// ...to deleted user.
					$this->assigned_to_user_name = "[deleted user ID " . $this->assigned_to . "]";
					$this->assigned_to = -1;
				}
			}
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
	
	/**
	 * Entry point of this mask.
	 * @param int $project_id
	 * @param int $issue_number
	 * @param string $scroll_at Target hash in the page to scroll at. The target
	 * hash for comments is "comment_ID", where IS is the ID of the message.
	 * Ignored if NULL.
	 */
	static function enter($project_id, $issue_number, $scroll_at)
	{
		$p = Project::getCachedProject($project_id);
		$m = new self();
		$m->project_id = $project_id;
		$m->issue_number = $issue_number;
		$m->scroll_at = $scroll_at;
		$m->retrieveIssue();

		// Set initial values of the "add comment" area:
		if( $p->im_member ){
			$m->changed_status->setValue(BooleanClass::getInstance($m->status));
			$m->changed_category->setValue(new IntClass($m->category));
			Users::fillMembersMenu($m->project_id, $m->changed_assigned_to);
			$m->changed_tags->setList(FieldTags::getCachedTagsForProject($m->project_id));
			$m->changed_tags->setValue($m->tags);
			try {
				$m->changed_assigned_to->setValue(new IntClass($m->assigned_to));
			}
			catch(UnexpectedValueException $e){
				// Assignee user not member anymore or deleted. Workaround:
				$m->changed_assigned_to->setValue(new IntClass(-1));
			}
			$m->changed_subject->setValue($m->subject);
		}
		
		$m->render();
	}
	
	/**
	 * Save added comment and displays the final updated issue.
	 * @throws SQLException
	 */
	private function saveButton_exception()
	{
		$err = "";
		if( strlen($this->changed_subject->getValue()) == 0 )
			$err .= "Empty subject.<p>";
		
		// Create a summary of the changes:
		$diff = "";
		
		$changed_status = cast(BooleanClass::class, $this->changed_status->getValue())->getValue();
		if( $this->status != $changed_status )
			$diff .= "Status: " . ($this->status? "OPEN":"CLOSED")
				." --> " . ($changed_status? "OPEN":"CLOSED") . "\n";
		
		$changed_category = cast(IntClass::class, $this->changed_category->getValue())->getValue();
		if( $this->category != $changed_category )
			$diff .= "Category: " . FieldCategory::codeToName($this->category)
				." --> " . FieldCategory::codeToName($changed_category) . "\n";
		
		$changed_tags = $this->changed_tags->getValue();
		if( $this->tags !== $changed_tags )
			$diff .= "Tags: " . $this->tags . " --> $changed_tags\n";
		
		$changed_assigned_to = cast(IntClass::class, $this->changed_assigned_to->getValue())->getValue();
		if( $this->assigned_to != $changed_assigned_to ){
			$old_name = $this->assigned_to < 0? "nobody" : Users::getUserCurrentName($this->assigned_to);
			$new_name = $changed_assigned_to < 0? "nobody" : Users::getUserCurrentName($changed_assigned_to);
			
			$diff .= "Assigned to: $old_name --> $new_name\n";
		}
		
		if( strcmp($this->subject, $this->changed_subject->getValue()) != 0 )
			$diff .= "Subject: " . $this->subject
				.   "\n     --> " . $this->changed_subject->getValue() . "\n";
		
		// Adds summary of the changes to the content:
		$content = trim( $this->content->getValue() );
		if(  strlen($diff) == 0 && strlen($content) == 0 )
				$err .= "No changes, no content.<p>";
		
		if( strlen($err) > 0 ){
			$this->render($err);
			return;
		}
		
		// Validation passed; save new issue state and message.
		$now = time();
		$db = Common::getDB();
		
		// Update issue:
		$sql = <<< EOT
update issues set
	modified_time=?,
	is_open=?,
	category=?,
	tags=?,
	subject=?,
	assigned_to=?
where
	project_id=?
	and number=?
	and modified_time=?
EOT;
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $now);
		$ps->setBoolean(1, $changed_status);
		$ps->setInt(2, $changed_category);
		$ps->setString(3, $changed_tags);
		$ps->setString(4, $this->changed_subject->getValue());
		if( $changed_assigned_to < 0 )
			$ps->setNull(5);
		else
			$ps->setInt(5, $changed_assigned_to);
		$ps->setInt(6, $this->project_id);
		$ps->setInt(7, $this->issue_number);
		$ps->setInt(8, $this->modified_time);
		$n = $ps->update();
		if( $n != 1 ){
			// The only reason update could fail is the issue modified_time
			// changed; this allows to detect someone else updated in the meanwhile.
			$this->retrieveIssue();
			$this->render("<big><b>Warning</b></big><p>The state of this issue changed in the meanwhile. Please carefully check the new issue state and read the added comment(s) before confirming your submission again. In particular, carefully check the assignee.");
			return;
		}

		// Update project modified time:
		$sql = "update projects set modified_time=? where id=?";
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $now);
		$ps->setInt(1, $this->project_id);
		$ps->update();
		
		// Save the new comment:
		$sql = "insert into messages (project_id, issue_number, created_time, created_by, diff, content, folder_id) values (?,?,?,?,?,?,?)";
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $this->project_id);
		$ps->setInt(1, $this->issue_number);
		$ps->setInt(2, $now);
		$ps->setInt(3, Users::getCurrentUserID());
		$ps->setString(4, $diff);
		$ps->setString(5, $content);
		$this->folder_panel->finalize();
		$folder_id = $this->folder_panel->getValue()->getFolderID();
		if( $folder_id < 0 )
			$ps->setNull(6);
		else
			$ps->setInt(6, $folder_id);
		$ps->update();

		// Retrieve message ID:
		$res = $db->query("select last_insert_id()");
		$res->moveToRow(0);
		$message_id = $res->getIntByIndex(0);

		// Reset statistics about the project:
		$sql = "delete from statistics where project_id=?";
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $this->project_id);
		$ps->update();
		
		// Displays the updated issue:
		self::enter($this->project_id, $this->issue_number, NULL);
		
		// Send email notifications:
		EmailNotify::send($message_id);
	}
	
	/**
	 * Save added comment button event handler.
	 */
	function saveButton()
	{
		/*
		 * Capture SQL exceptions giving user a chance to recover its precius data.
		 * This may happen for text too long (MySQL and MariaDB TEXT type holds
		 * 65535 bytes, for example) or number out of the supported range (PHP
		 * int type can hold up to 64 bits, but DB INT is typically 32), or
		 * DB temporarily off-line, or whatever.
		 */
		try {
			$this->saveButton_exception();
		}
		catch(SQLException $e){
			Log::error("$e");
			Common::resetCachedDB();
			$this->render(Html::text($e->getMessage()));
		}
	}
	
	function defaultEvent()
	{
		$this->folder_panel->delete();
		UserSession::invokeCallBackward();
	}
	
	function browserBackEvent()
	{
		$this->folder_panel->delete();
		UserSession::invokeCallBackward();
	}
	
	function browserReloadEvent()
	{
		self::enter($this->project_id, $this->issue_number, $this->scroll_at);
	}
	
}
