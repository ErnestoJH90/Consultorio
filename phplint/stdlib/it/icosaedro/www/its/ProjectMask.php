<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\controls\RadioButton;
use it\icosaedro\web\controls\Line;
use it\icosaedro\web\controls\Text;
use it\icosaedro\web\controls\SelectMultiple;
use it\icosaedro\web\bt_\Form;
use it\icosaedro\web\Http;
use it\icosaedro\web\Html;
use it\icosaedro\containers\IntClass;
use RuntimeException;

/**
 * Project creation and configuration mask.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/06 21:38:48 $
 */
class ProjectMask extends Form {
	
	/*. forward static void function enter(int $project_id); .*/
	
	/**
	 * Project ID. If negative, this is a new project to create.
	 * @var int
	 */
	private $project_id = 0;
	
	/**
	 * Name of the project.
	 * @var Line
	 */
	private $name;
	
	/**
	 * Description of the project.
	 * @var Text
	 */
	private $description;
	
	/**
	 * Administrators selection menu. Administrator have access to this project
	 * configuration mask.
	 * @var SelectMultiple
	 */
	private $admins;
	
	/**
	 * Members selection menu. Members may add issues and comments to issues.
	 * @var SelectMultiple
	 */
	private $members;
	
	/**
	 * @var RadioButton
	 */
	private $access_private;
	
	/**
	 * @var RadioButton
	 */
	private $access_protected;
	
	/**
	 * @var RadioButton
	 */
	private $access_public;
	
	/**
	 * @var FolderUploadPanel
	 */
	private $docs;
	
	function __construct()
	{
		parent::__construct();
		$this->name = new Line($this, "name");
		$this->description = new Text($this, "description");
		$this->admins = new SelectMultiple($this, "admins", 10);
		$this->members = new SelectMultiple($this, "members", 10);
		$this->access_private = new RadioButton($this, "access", 0, "<b>Private.</b> Only the granted members of the project may read and write into it; nobody else has access.");
		$this->access_protected = new RadioButton($this, "access", 1, "<b>Protected.</b> Anyone can read this project, but only the granted members are allowed to write into it.");
		$this->access_public = new RadioButton($this, "access", 2, "<b>Public.</b> Anyone can read this project. Registered users may subscribe and unsubscribe themselves to become members. Exception: guest users cannot subscribe.");
		$this->docs = new FolderUploadPanel($this, "docs");
	}
	
	/**
	 * Fill-in the admins and members menus. Uses the current project ID; if it
	 * is negative, the current user is added as default administrator.
	 * @param boolean $selected_from_db If true, also set the selected users as
	 * per the DB; this is what we normally want entering this mask the first
	 * time. If false, leave all entries unselected; this is what we normally
	 * want receiving post-backs.
	 */
	private function fillAdminsAndMembers($selected_from_db)
	{
		try {
			$db = Common::getDB();
			$sql = <<< EOT
				select
					u.pk,
					u.current_name,
					p.is_admin
				from
					icodb.users as u
				left join
					permissions as p
				on
					p.project_id = ?
					and p.user_id = u.pk
				order by u.current_name
EOT;
			$ps = $db->prepareStatement($sql);
			$ps->setInt(0, $this->project_id);
			$res = $ps->query();
			$n = $res->getRowCount();
			$selected_admins = /*. (IntClass[int]) .*/ [];
			$selected_members = /*. (IntClass[int]) .*/ [];
			for($i = 0; $i < $n; $i++){
				$res->moveToRow($i);
				$user_id = $res->getIntByName("pk");
				$name = $res->getStringByName("current_name");
				$is_admin = $res->getBooleanByName("is_admin");
				$is_member = ! $res->wasNull();
				$id = new IntClass($user_id);
				$this->admins->addEntry($name, $id);
				$this->members->addEntry($name, $id);
				if( $is_admin )
					$selected_admins[] = $id;
				if( $is_member )
					$selected_members[] = $id;
			}
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		if( $selected_from_db ){
			if( $this->project_id < 0 )
				$selected_admins[] = new IntClass(Users::getCurrentUserID());
			$this->admins->setSelectedValues($selected_admins);
			$this->members->setSelectedValues($selected_members);
		}
	}
	
	function save()
	{
		parent::save();
		$this->setData("project_id", $this->project_id);
	}
	
	function resume()
	{
		$this->project_id = (int) $this->getData("project_id");
		$this->fillAdminsAndMembers(FALSE);
		parent::resume();
	}
	
	/**
	 * Actual render() method that may throw exception.
	 * @param string $err
	 * @throws SQLException
	 */
	private function render_exception($err = NULL)
	{
		Http::headerContentTypeHtmlUTF8();
		echo "<html><body>";
		Common::echoNavBar($this->project_id, -1);
		if( $this->project_id < 0 )
			echo "<h2>New Project</h2>";
		else
			echo "<h2>Project Management</h2>";
		
		if( strlen($err) > 0 )
			Html::errorBox($err);
		
		$this->open();
		echo "Name: ";
		$this->name->addAttributes("size=30");
		$this->name->render();
		if( $this->project_id >= 0 )
			echo "&emsp;(ID ", $this->project_id, ")";
		echo "<p>Description:<br>";
		$this->description->addAttributes("rows=4 cols=80");
		$this->description->render();
		
		echo "<p>Access permissions:</p><blockquote><p>";
		$this->access_private->render();
		echo "</p><p>";
		$this->access_protected->render();
		echo "</p><p>";
		$this->access_public->render();
		echo "</p></blockquote>";
		
		echo "<table><tr><td valign=top>";
		echo "Projects's administrators may access this page:<br>";
		$this->admins->listSelectedFirst(TRUE);
		$this->admins->render();
		echo "</td><td>&emsp;</td><td>Project's members may only add issues and comments (administrators added anyway):<br>";
		$this->members->listSelectedFirst(TRUE);
		$this->members->render();
		echo "</td></tr></table>";
		echo "<p>";
		$this->docs->render();
		echo "<p>";
		$this->button("Save", "saveButton");
		if( $this->project_id >= 0 ){
			echo "&emsp;&emsp;";
			$this->button("Delete project...", "deleteProjectButton");
		}
		$this->close();
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
	
	function saveButton()
	{
		$err = "";
		
		if( strlen($this->name->getValue()) == 0 )
			$err .= "<p>Empty project name.";
		
		$selected_admins = cast(IntClass::class . "[int]", $this->admins->getSelectedValues());
		if( count($selected_admins) == 0 )
			$err .= "<p>There must be at least one project administrator.";
		
		$selected_members = cast(IntClass::class . "[int]", $this->members->getSelectedValues());
		
		if( strlen($err) > 0 ){
			$this->render($err);
			return;
		}
		
		try {
			$db = Common::getDB();
			
			// Save docs:
			$this->docs->finalize();
			$docs_folder_id = $this->docs->getValue()->getFolderID();
			
			if( $this->project_id < 0 ){
				
				// Insert project:
				$ps = $db->prepareStatement("insert into projects (name, description, created_time, modified_time, last_number, folder_id, is_world_readable, users_may_subscribe) values (?,?,?,?,?,?,?)");
				$ps->setString(0, $this->name->getValue());
				$ps->setString(1, $this->description->getValue());
				$ps->setInt(2, time());
				$ps->setInt(3, time());
				$ps->setInt(4, 0);
				if( $docs_folder_id < 0 )
					$ps->setNull(5);
				else
					$ps->setInt(5, $docs_folder_id);
				$ps->setBoolean(6, ! $this->access_private->isSelected());
				$ps->setBoolean(7, $this->access_public->isSelected());
				$ps->update();
				
				// Retrieving assigned project ID:
				$res = $db->query("select last_insert_id()");
				$res->moveToRow(0);
				$this->project_id = $res->getIntByIndex(0);
			
			} else {
				// Update project:
				$sql = <<< EOT
					update
						projects
					set
						name = ?,
						description = ?,
						folder_id = ?,
						is_world_readable = ?,
						users_may_subscribe = ?
					where
						id = ?
EOT;
				$ps = $db->prepareStatement($sql);
				$ps->setString(0, $this->name->getValue());
				$ps->setString(1, $this->description->getValue());
				if( $docs_folder_id < 0 )
					$ps->setNull(2);
				else
					$ps->setInt(2, $docs_folder_id);
				$ps->setBoolean(3, ! $this->access_private->isSelected());
				$ps->setBoolean(4, $this->access_public->isSelected());
				$ps->setInt(5, $this->project_id);
				$ps->update();

				// Delete old permissions:
				$db->update("delete from permissions where project_id = " . $this->project_id);
			}
			
			// Save new permissions:
			$perms = /*. (boolean[int]) .*/ []; // user_id => is_admin map
			foreach($selected_members as $m)
				$perms[$m->getValue()] = FALSE;
			foreach($selected_admins as $m)
				$perms[$m->getValue()] = TRUE;
			foreach($perms as $user_id => $is_admin){
				$ps = $db->prepareStatement("insert into permissions (project_id, user_id, is_admin) values (?,?,?)");
				$ps->setInt(0, $this->project_id);
				$ps->setInt(1, $user_id);
				$ps->setBoolean(2, $is_admin);
				$ps->update();
			}
			
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		Project::resetCachedProject();
		ProjectDashboardMask::enter($this->project_id);
	}
	
	function deleteProjectButton()
	{
		ProjectDeleteMask::enter($this->project_id);
	}
	
	function browserBackEvent()
	{
		if( $this->project_id < 0 )
			DashboardMask::enter();
		else
			ProjectDashboardMask::enter($this->project_id);
	}
	
	/**
	 * Entry point of this mask.
	 * @param int $project_id Project ID for update, or -1 for new project.
	 */
	static function enter($project_id)
	{
		$m = new self();
		$m->project_id = $project_id;
		if( $project_id >= 0 ){
			$p = Project::getCachedProject($project_id);
			$m->name->setValue($p->name);
			$m->description->setValue($p->description);
			try {
				$m->docs->setValue(Folder::fromDB($p->folder_id));
			}
			catch(SQLException $e){
				throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
			}
			$m->access_private->setSelected( ! $p->is_world_readable);
			$m->access_protected->setSelected($p->is_world_readable && ! $p->users_may_subscribe );
			$m->access_public->setSelected($p->is_world_readable && $p->users_may_subscribe );
		}
		$m->fillAdminsAndMembers(TRUE);
		$m->render();
	}
	
}
