<?php

namespace it\icosaedro\www\its;
require_once __DIR__ . "/../../../../all.php";
use it\icosaedro\sql\SQLException;
use RuntimeException;

/**
 * ITS data base "tags" field utilities. Tags are simply strings users may freely
 * edit. At interface level, existing distinct tags from a project are collected
 * and suggested to the user to help selecting recurrent entries. This class does
 * its best to collect and cache these values avoiding unnecessary redundant
 * accesses to the DB.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/25 01:55:03 $
 */
class FieldTags {
	
	/**
	 * @var int
	 */
	private static $project_id = 0;
	
	/**
	 * @var string[int]
	 */
	private static $tags;
	
	/**
	 * Return the list of univocal issue tags for the specified project.
	 * The empty string is never added to the list. The result is cached.
	 * @param int $project_id
	 * @return string[int]
	 */
	static function getCachedTagsForProject($project_id)
	{
		if( $project_id == self::$project_id )
			return self::$tags;
		try {
			$db = Common::getDB();
			$res = $db->query("select distinct tags from issues where project_id=$project_id order by tags");
			$tags = /*. (string[int]) .*/ [];
			$n = $res->getRowCount();
			for($i = 0; $i < $n; $i++){
				$res->moveToRow($i);
				$v = $res->getStringByName("tags");
				if( strlen($v) > 0 )
					$tags[] = $v;
			}
			self::$project_id = $project_id;
			self::$tags = $tags;
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		return $tags;
	}
	
}
