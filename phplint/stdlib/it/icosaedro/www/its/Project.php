<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use RuntimeException;

/**
 * Project data base table accessor.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/06 21:38:48 $
 */
class Project {
	
	/*. forward static Project function getCachedProject(int $id); .*/
	
	/**
	 * Record ID.
	 * @var int
	 */
	public $id = -1;
	
	/**
	 * Name.
	 * @var string
	 */
	public $name;
	
	/**
	 * Project description.
	 * @var string
	 */
	public $description;
	
	/**
	 * Project creation time-stamp.
	 * @var int
	 */
	public $created_time = 0;
	
	/**
	 * Project modified time-stamp.
	 * @var int
	 */
	public $modified_time = 0;
	
	/**
	 * Folder ID of the projects documentation files. If negative, no files.
	 * For more about folders and folders IDs, see the Folder* classes.
	 * @var int
	 */
	public $folder_id = 0;
	
	/**
	 * If this ITS data base can be read by non-member users.
	 * @var boolean
	 */
	public $is_world_readable = FALSE;
	
	/**
	 * If any registered user may subscribe as a member of this project.
	 * Implies it is world readable.
	 * @var boolean
	 */
	public $users_may_subscribe = FALSE;
	
	/**
	 * If the current user is one of the admins of the project.
	 * @var boolean
	 */
	public $im_admin = FALSE;
	
	/**
	 * If the current user is member of the project.
	 * @var boolean
	 */
	public $im_member = FALSE;
	
	/**
	 * @var Project
	 */
	private static $cached_project;
	
//	/**
//	 * @param string $name
//	 * @param string $description
//	 * @return self
//	 * @throws SQLException
//	 */
//	static function insert($name, $description)
//	{
//		$p = new self();
//		$p->name = $name;
//		$p->description = $description;
//		$p->created_time = time();
//		$p->modified_time = time();
//		$db = Common::getDB();
//		$ps = $db->prepareStatement("insert into project (name, description, created_time, modified_time, folder_id) values(?,?,?,?,?)");
//		$ps->setString(0, $name);
//		$ps->setString(1, $description);
//		$ps->setInt(2, $p->created_time);
//		$ps->setInt(3, $p->modified_time);
//		$ps->setNull(4);
//		$ps->update();
//		$rs = $db->query("select last_insert_id()");
//		$rs->moveToRow(0);
//		$p->id = $rs->getIntByIndex(0);
//		return $p;
//	}
	
	/**
	 * Retrieve project basic data.
	 * @param int $id Project ID.
	 * @return self
	 */
	private static function retrieve($id)
	{
		try {
			$db = Common::getDB();
			
			// Retrieve project data:
			$ps = $db->prepareStatement("select * from projects where id=?");
			$ps->setInt(0, $id);
			$rs = $ps->query();
			$rs->moveToRow(0);
			$p = new self();
			$p->id = $rs->getIntByName("id");
			$p->name = $rs->getStringByName("name");
			$p->description = $rs->getStringByName("description");
			$p->created_time = $rs->getIntByName("created_time");
			$p->modified_time = $rs->getIntByName("modified_time");
			$p->folder_id = $rs->getIntByName("folder_id");
			if( $rs->wasNull() )
				$p->folder_id = -1;
			$p->is_world_readable = $rs->getBooleanByName("is_world_readable");
			$p->users_may_subscribe = $p->is_world_readable && $rs->getBooleanByName("users_may_subscribe");
			
			// Retrieve project permissions for current user:
			$rs = $db->query("select * from permissions where project_id=$id and user_id=" . Users::getCurrentUserID());
			if( $rs->getRowCount() == 0 ){
				$p->im_admin = FALSE;
				$p->im_member = FALSE;
			} else {
				$rs->moveToRow(0);
				$p->im_admin = $rs->getBooleanByName("is_admin");
				$p->im_member = TRUE;
			}
			
			self::$cached_project = $p;
			return $p;
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
	
//	/**
//	 * @throws SQLException
//	 */
//	function update()
//	{
//		$db = Common::getDB();
//		$ps = $db->prepareStatement("update projects set name=?, description=? where id=?");
//		$ps->setString(0, $this->name);
//		$ps->setString(1, $this->description);
//		$ps->setInt(2, $this->id);
//	}
	
	/**
	 * Retrieves project basic data. The result is cached.
	 * @param int $id Project ID.
	 * @return Project
	 */
	static function getCachedProject($id)
	{
		if( self::$cached_project !== NULL && self::$cached_project->id == $id )
			return self::$cached_project;
		return self::$cached_project = self::retrieve($id);
	}
	
	/**
	 * Resets cached project basic data.
	 */
	static function resetCachedProject()
	{
		self::$cached_project = NULL;
	}
	
}
