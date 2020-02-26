<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\controls\Line;
use it\icosaedro\web\controls\LineCombo;
use it\icosaedro\web\controls\Text;
use it\icosaedro\web\controls\Select;
use it\icosaedro\web\bt_\Form;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\web\Http;
use it\icosaedro\web\Html;
use it\icosaedro\web\Log;
use it\icosaedro\containers\IntClass;

/**
 * Mask to add a new issue to a project.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/30 05:34:51 $
 */
class CreateIssueMask extends Form {
	
	/**
	 * @var int
	 */
	private $project_id = 0;
	
	/**
	 * @var Select
	 */
	private $category;
	
	/**
	 * @var LineCombo
	 */
	private $tags;
	
	/**
	 * @var Select
	 */
	private $assigned_to;
	
	/**
	 * @var Line
	 */
	private $subject;
	
	/**
	 * @var Text
	 */
	private $content;
	
	/**
	 * @var FolderUploadPanel
	 */
	private $folder_panel;
	
	function __construct()
	{
		parent::__construct();
		$this->category = new Select($this, "category");
		FieldCategory::fillMenu($this->category);
		$this->tags = new LineCombo($this, "tags");
		$this->assigned_to = new Select($this, "assigned_to");
		$this->assigned_to->addValue("--", new IntClass(-1));
		$this->subject = new Line($this, "subject");
		$this->content = new Text($this, "content");
		$this->folder_panel = new FolderUploadPanel($this, "folder");
	}
	
	function save()
	{
		parent::save();
		$this->setData("project_id", $this->project_id);
	}
	
	function resume()
	{
		parent::resume();
		$this->project_id = (int) $this->getData("project_id");
		$this->tags->setList(FieldTags::getCachedTagsForProject($this->project_id));
		// FIXME: if the user set for this Select does not belong to the project anymore, causes RuntimeException while rendering the control
		Users::fillMembersMenu($this->project_id, $this->assigned_to);
	}
	
	/**
	 * @param string $err
	 */
	function render($err = NULL)
	{
		Http::headerContentTypeHtmlUTF8();
		echo "<html><body>";
		Common::echoNavBar($this->project_id, -1);
		echo "<h2>New Issue</h2>";
		
		if( strlen($err) > 0 )
			Html::errorBox($err);
		
		$this->open();
		
		echo "<div style='background-color: #dddddd; padding: 1em;'>";
		
		echo "Number: <i>to assign</i>";
		
		echo "&emsp;Status: OPEN";
		
		echo "&emsp;Category: ";
		$this->category->render();
		
		echo "&emsp;Tags: ";
		$this->tags->render();
		
		echo "&emsp;Assigned to: ";
		$this->assigned_to->render();
		
		echo "<p>Subject: ";
		$this->subject->addAttributes("size=70");
		$this->subject->render();
		
		echo "<p>";
		$this->content->addAttributes("cols=80 rows=15");
		$this->content->render();
		$this->folder_panel->render();
		
		echo "<p>";
		$this->button("Save", "saveButton");
		echo "</div>";
		$this->close();
		\it\icosaedro\www\Common::echoPageFooter();
	}
	
	function browserBackEvent()
	{
		$this->folder_panel->delete();
		ProjectDashboardMask::enter($this->project_id);
	}
	
	/**
	 * Create new issue.
	 * @throws SQLException
	 */
	private function save_exception()
	{
		// Input validation:
		$err = "";
		if( strlen($this->subject->getValue()) == 0 )
			$err .= "<p>Empty subject.";
		if( strlen($this->content->getValue()) == 0 )
			$err .= "<p>Empty content.";
		if( strlen($err) > 0 ){
			$this->render($err);
			return;
		}
		
		// Save:
		$user_id = Users::getCurrentUserID();
		$now = time();
		$db = Common::getDB();
		$db->update("begin");

		// Get a brand new issue number specific of the project:
		$db->update("update projects set last_number = last_number + 1 where id=" . $this->project_id);
		$res = $db->query("select last_number from projects where id=" . $this->project_id);
		$res->moveToRow(0);
		$issue_number = $res->getIntByName("last_number");

		// Create new issue:
		$category = cast(IntClass::class, $this->category->getValue())->getValue();
		$assigned_to = cast(IntClass::class, $this->assigned_to->getValue())->getValue();
		$sql = <<< EOT
insert into issues
	(project_id, number, category, tags, created_time, modified_time, is_open, subject, assigned_to)
	values (?,?,?,?,?,?,?,?,?)
EOT;
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $this->project_id);
		$ps->setInt(1, $issue_number);
		$ps->setInt(2, $category);
		$ps->setString(3, $this->tags->getValue());
		$ps->setInt(4, $now);
		$ps->setInt(5, $now);
		$ps->setBoolean(6, TRUE);
		$ps->setString(7, $this->subject->getValue());
		if( $assigned_to < 0 )
			$ps->setNull(8);
		else
			$ps->setInt(8, $assigned_to);
		$ps->update();

		// Save message:
		$sql = <<< EOT
insert into messages
	(project_id, issue_number, created_time, created_by, diff, content, folder_id)
	values (?,?,?,?,?,?,?)
EOT;
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $this->project_id);
		$ps->setInt(1, $issue_number);
		$ps->setInt(2, $now);
		$ps->setInt(3, $user_id);
		$ps->setString(4, "");
		$ps->setString(5, $this->content->getValue());
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

		// Update project modified time:
		$ps = $db->prepareStatement("update projects set modified_time = ? where id = ?");
		$ps->setInt(0, $now);
		$ps->setInt(1, $this->project_id);
		$ps->update();

		// Reset project statistics:
		$db->update("delete from statistics where project_id = " . $this->project_id);
		
		$db->update("commit");
		
		// Display completed issue:
		UserSession::stackPush("it\\icosaedro\\www\\its\\ProjectDashboardMask::enter", [$this->project_id]);
		IssueMask::enter($this->project_id, $issue_number, NULL);
		
		// Send email notifications:
		EmailNotify::send($message_id);
	}
	
	function saveButton()
	{
		/*
		 * Capture SQL exceptions giving user chance to recover its precius data.
		 * This may happen for text too long (MySQL and MariaDB TEXT type holds
		 * 65535 bytes, for example) or number out of the supported range (PHP
		 * int type can hold up to 64 bits, but DB INT is typically 32), or
		 * DB temporarily off-line, or whatever.
		 */
		try {
			$this->save_exception();
		}
		catch(SQLException $e){
			Log::error("$e");
			Common::resetCachedDB();
			$this->render(Html::text($e->getMessage()));
		}
	}
	
	/**
	 * This mask entry point.
	 * @param int $project_id
	 */
	static function enter($project_id)
	{
		$m = new self();
		$m->project_id = $project_id;
		$m->tags->setList(FieldTags::getCachedTagsForProject($project_id));
		// FIXME: if the user set for this Select does not belong to the project anymore, causes RuntimeException while rendering the control
		Users::fillMembersMenu($project_id, $m->assigned_to);
		$m->render();
	}
	
}
