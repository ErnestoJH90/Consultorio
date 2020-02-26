<?php

namespace it\icosaedro\www\its;
require_once __DIR__ . "/../../../../all.php";
use it\icosaedro\containers\IntClass;
use it\icosaedro\web\controls\Select;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\sql\SQLException;
use RuntimeException;

/**
 * Current user retrieval and users menu utilities.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/30 05:34:51 $
 */
class Users {
	
	private static $current_user_id = -1;
	
	/**
	 * Returns the current user ID.
	 * @return int
	 */
	static function getCurrentUserID()
	{
		if( self::$current_user_id >= 0 )
			return self::$current_user_id;
		try {
			$name = UserSession::getSessionParameter("name");
			$db = Common::getDB();
			$ps = $db->prepareStatement("select pk from icodb.users where name=?");
			$ps->setString(0, $name);
			$res = $ps->query();
			$res->moveToRow(0);
			return self::$current_user_id = $res->getIntByName("pk");
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
	
	/**
	 * Retrieves the current name of the given user's ID.
	 * @param int $user_id
	 * @return string Current name of the user, or NULL if not found (possibly
	 * deleted user).
	 */
	static function getUserCurrentName($user_id)
	{
		try {
			$db = Common::getDB();
			$ps = $db->prepareStatement("select current_name from icodb.users where pk=?");
			$ps->setInt(0, $user_id);
			$res = $ps->query();
			if( $res->getRowCount() == 0 )
				return NULL;
			$res->moveToRow(0);
			return $res->getStringByName("current_name");
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
	
	/**
	 * Add all project's members to the menu.
	 * @param int $project_id
	 * @param Select $menu
	 */
	static function fillMembersMenu($project_id, $menu)
	{
		try {
			$db = Common::getDB();
			$sql = <<< EOT
select u.pk, u.current_name
from icodb.users as u, its.permissions as p
where p.project_id=$project_id and p.user_id=u.pk
order by u.current_name
EOT;
			$res = $db->query($sql);
			for($i = 0; $i < $res->getRowCount(); $i++){
				$res->moveToRow($i);
				$current_name = $res->getStringByName("current_name");
				$pk = $res->getIntByName("pk");
				$menu->addValue($current_name, new IntClass($pk));
			}
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
}
