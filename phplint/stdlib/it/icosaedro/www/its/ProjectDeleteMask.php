<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\bt_\Form;
use it\icosaedro\web\Http;
use it\icosaedro\web\Html;
use it\icosaedro\web\Log;
use RuntimeException;

/**
 * Project delete mask.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/30 05:19:46 $
 */
class ProjectDeleteMask extends Form {
	
	/*. forward static void function enter(int $project_id); .*/
	
	/**
	 * @var int
	 */
	private $project_id = 0;
	
	function __construct()
	{
		parent::__construct();
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
	}
	
	/**
	 * Actual render() method that may throw exception.
	 * @param string $err
	 */
	function render($err = NULL)
	{
		Http::headerContentTypeHtmlUTF8();
		echo "<html><body>";
		Common::echoNavBar($this->project_id, -1);
		echo "<h2>Delete project</h2>";
		if( strlen($err) > 0 )
			Html::errorBox($err);
		$p = Project::getCachedProject($this->project_id);
		$this->open();
		echo "<p>You are goind to delete the project</p><blockquote><big><big><b>",
			Html::text($p->name), "</b></big></big></blockquote>",
			"<p>This will <u>permanently</u> delete from the data base:</p><ul>",
			"<li><p>All the issues of the project.</p></li>",
			"<li><p>All the comments added to the issues of the project.</p></li>",
			"<li><p>All the files attached to the messages.</p></li>",
			"<li><p>The files of the project.</p></li>",
			"<li><p>The project itself.</p></li>",
			"</ul>",
			"<p>Are you sure to delete the <b>", Html::text($p->name), "</b> project from the ITS?</p>";
		$this->button("Delete project " . Html::text($p->name), "deleteButton");
		$this->close();
		\it\icosaedro\www\Common::echoPageFooter();
	}
	
	function deleteButton()
	{
		try {
			$db = Common::getDB();
			$project_id = $this->project_id;
			$p = Project::getCachedProject($project_id);
			$db->update("delete from permissions where project_id = $project_id");
			$db->update("delete from statistics where project_id = $project_id");
			$db->update("delete from files where folder_id in (select folder_id from messages where project_id = $project_id and folder_id is not null)");
			$db->update("delete from folders where id in (select folder_id from messages where project_id = $project_id and folder_id is not null)");
			$db->update("delete from messages where project_id = $project_id");
			$db->update("delete from issues where project_id = $project_id");
			if( $p->folder_id >= 0 ){
				$db->update("delete from files where folder_id = " . $p->folder_id);
				$db->update("delete from folders where id = " . $p->folder_id);
			}
			$db->update("delete from projects where id = $project_id");
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		DashboardMask::enter();
	}
	
	function browserBackEvent()
	{
		ProjectMask::enter($this->project_id);
	}
	
	/**
	 * Entry point of this mask.
	 * @param int $project_id Project ID for update, or -1 for new project.
	 */
	static function enter($project_id)
	{
		$m = new self();
		$m->project_id = $project_id;
		$m->render();
	}
	
}
