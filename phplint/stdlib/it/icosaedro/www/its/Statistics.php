<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;

/**
 * Collects and cache statistics about a project.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/25 02:01:30 $
 */
class Statistics {
	
	/**
	 * @var int
	 */
	public $project_id = 0;
	
	/**
	 * When these statistics were last calculated.
	 * @var int
	 */
	private $last_updated_time = 0;
	
	/**
	 *
	 * @var int
	 */
	public $total_issues = 0;
	
	/**
	 *
	 * @var int
	 */
	public $open_issues = 0;
	
	/**
	 *
	 * @var int
	 */
	public $open_assigned_issues = 0;
	
	/**
	 * @throws SQLException
	 */
	private function update()
	{
		$db = Common::getDB();
		
		// Compute no. issues:
		$ps = $db->prepareStatement("SELECT count(*) FROM issues WHERE project_id=?");
		$ps->setInt(0, $this->project_id);
		$rs = $ps->query();
		$rs->moveToRow(0);
		$this->total_issues = $rs->getIntByIndex(0);
		
		// Compute no. open issues:
		$ps = $db->prepareStatement("SELECT count(*) FROM issues WHERE project_id=? AND is_open");
		$ps->setInt(0, $this->project_id);
		$rs = $ps->query();
		$rs->moveToRow(0);
		$this->open_issues = $rs->getIntByIndex(0);
		
		// Compute no. open assigned issues:
		$ps = $db->prepareStatement("SELECT count(*) FROM issues WHERE project_id=? AND is_open AND assigned_to IS NOT NULL");
		$ps->setInt(0, $this->project_id);
		$rs = $ps->query();
		$rs->moveToRow(0);
		$this->open_assigned_issues = $rs->getIntByIndex(0);
		
		// Delete old statistics:
		$ps = $db->prepareStatement("DELETE FROM statistics WHERE project_id=?");
		$ps->setInt(0, $this->project_id);
		$ps->update();
		
		// Save updated statistics:
		$this->last_updated_time = time();
		$ps = $db->prepareStatement("INSERT INTO statistics (project_id, last_updated_time, total_issues, open_issues, open_assigned_issues) VALUES(?,?,?,?,?)");
		$ps->setInt(0, $this->project_id);
		$ps->setInt(1, $this->last_updated_time);
		$ps->setInt(2, $this->total_issues);
		$ps->setInt(3, $this->open_issues);
		$ps->setInt(4, $this->open_assigned_issues);
		$ps->update();
	}
	
	/**
	 * Creates a new statistics about a project.
	 * @param int $project_id
	 * @throws SQLException
	 */
	function __construct($project_id)
	{
		$this->project_id = $project_id;
		$db = Common::getDB();
		$ps = $db->prepareStatement("SELECT * FROM statistics WHERE project_id=? ORDER BY last_updated_time DESC LIMIT 1");
		$ps->setInt(0, $project_id);
		$rs = $ps->query();
		if( $rs->getRowCount() == 0 ){
			$this->update();
		} else {
			$rs->moveToRow(0);
			$this->last_updated_time = $rs->getIntByName("last_updated_time");
			$this->total_issues = $rs->getIntByName("total_issues");
			$this->open_issues = $rs->getIntByName("open_issues");
			$this->open_assigned_issues = $rs->getIntByName("open_assigned_issues");
			if( time() - $this->last_updated_time > 600 )
				$this->update();
		}
	}
	
	
}
