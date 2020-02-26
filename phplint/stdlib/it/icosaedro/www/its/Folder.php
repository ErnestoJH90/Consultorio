<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\Log;
use ErrorException;
use RuntimeException;

/**
 * Files container. Files can be added and removed. The current state of
 * this object is kept synchronized with the DB: if empty (no files) the folder
 * ID is negative and nothing is stored in the DB; if it contains at least one
 * file, the ID is positive and the state of this object is saved on DB.
 * The current list of files is available from the corresponding property.
 * The getFolderID() retrieves the current assigned ID, possibly negative; note
 * that this value may change as files are added and removed.
 * 
 * <p>This class is intended to be used along with the File class to implement
 * file upload and download from web pages; see also the FolderUploadPanel class
 * and the FolderDownload class.
 * 
 * <p>BEWARE. New created folders MUST be finalize()d once the user confirms
 * the form and SHOULD be explicitly delete()d if the user leaves the form.
 * Non-finalized folders left behind and their content are periodically deleted
 * from the DB.
 * 
 * <p>BEWARE. All properties are intended to be "read-only"; do not overwrite
 * their content to prevent misalignment with the DB content.
 * 
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/25 01:55:52 $
 */
class Folder {
	
	/**
	 * Serial number of the record. If negative, still not saved. This implementation
	 * behaves in "lazy" mode performing a DB insert only if really required.
	 * @var int
	 */
	private $folder_id = 0;
	
	/**
	 * Timestamp of the last save in the DB.
	 * @var int
	 */
	private $created_time = 0;
	
	/**
	 * If this folder has been actually attached to some other DB entry.
	 * @var boolean
	 */
	private $finalized = FALSE;
	
	/**
	 * Files stored in this folder. This propriety and its content are
	 * intended being "read only".
	 * @var File[int]
	 */
	public $files;
	
	/**
	 * Creates and empty, not finalized, not saved yet, folder.
	 */
	private function __construct()
	{
		$this->folder_id = -1;
		$this->created_time = time();
		$this->finalized = FALSE;
		$this->files = [];
	}
	
	/**
	 * Returns the DB assigned ID of this folder.
	 * @return int Assigned ID of this folder to be used later to retrieve its
	 * status from the DB. The value can be negative if the folder is empty,
	 * then no data have been stored.
	 */
	function getFolderID()
	{
		return $this->folder_id;
	}
	
	/**
	 * Delete this folder along with all its files, restoring the initial
	 * empty, not saved, not finalized folder state.
	 * @throws SQLException
	 */
	function delete()
	{
		foreach($this->files as $a)
			$a->delete();
		if( $this->folder_id >= 0 )
			Common::getDB()->update("delete from folders where id=" . $this->folder_id);
		// Reset:
		$this->folder_id = -1;
		$this->created_time = time();
		$this->finalized = FALSE;
		$this->files = [];
	}
	
	/**
	 * Save this folder in the DB. If not saved yet (the folder ID is negative)
	 * performs an "insert" and retrieve the assigned ID. If already saved,
	 * update the fields.
	 * @throws SQLException
	 */
	private function save()
	{
		$db = Common::getDB();
		$this->created_time = time();
		if( $this->folder_id < 0 ){
			$sql = "insert into folders (created_time, finalized) values(?,?)";
			$ps = $db->prepareStatement($sql);
			$ps->setInt(0, $this->created_time);
			$ps->setBoolean(1, $this->finalized);
			$ps->update();
			$res = $db->query("select last_insert_id()");
			$res->moveToRow(0);
			$this->folder_id = $res->getIntByIndex(0);
		} else {
			$sql = "update folders set created_time=?, finalized=? where id=?";
			$ps = $db->prepareStatement($sql);
			$ps->setInt(0, $this->created_time);
			$ps->setBoolean(1, $this->finalized);
			$ps->setInt(2, $this->folder_id);
			$ps->update();
		}
	}
	
	/**
	 * Create a new empty folder or retrieve folder content from DB.
	 * Files are sorted by increasing cardinal number.
	 * @param int $folder_id Folder ID to retrieve. If negative, a dummy empty
	 * folder is returned.
	 * @return self
	 * @throws SQLException
	 */
	static function fromDB($folder_id)
	{
		$f = new self();
		if( $folder_id < 0 )
			return $f;
		// Retrieve fields from "folders" table:
		$db = Common::getDB();
		$res = $db->query("select * from folders where id=$folder_id");
		if( $res->getRowCount() == 0 ){
			$e = new RuntimeException("folder ID=$folder_id does not exist in the DB -- deleted?");
			Log::error("$e");
			return $f; // return default empty folder
		}
		$res->moveToRow(0);
		$f->folder_id = $folder_id;
		$f->created_time = $res->getIntByName("created_time");
		$f->finalized = $res->getBooleanByName("finalized");
		
		// Retrieve files from the "files" table:
		$res = $db->query("select id from files where folder_id=$folder_id order by cardinal asc");
		for($i = 0; $i < $res->getRowCount(); $i++){
			$res->moveToRow($i);
			$f->files[] = File::fromDB($res->getIntByName("id"));
		}
		if( count($f->files) == 0 ){
			// Empty folder left behind. Should never happen, but...
			// Delete and returns the default empty folder:
			$e = new RuntimeException("folder ID=$folder_id is empty -- deleting");
			Log::error("$e");
			$f->delete();
		}
		return $f;
	}
	
	/**
	 * Delete older non-finalized folders and associated files.
	 * @throws SQLException
	 */
	private function cleanup()
	{
		$db = Common::getDB();
		$older_than = time() - 86400;
		$res = $db->query("select id from folders where not finalized and created_time < $older_than");
		for($i = 0; $i < $res->getRowCount(); $i++){
			$res->moveToRow($i);
			$folder_id = $res->getIntByName("id");
			$db->update("delete from files where folder_id=$folder_id");
			$db->update("delete from folders where id=$folder_id");
		}
	}
	
	/**
	 * Append a file to this folder. If this is the first file of the folder,
	 * the folder record is actually saved in the DB in its not-finalized status.
	 * @param string $name Name of the file.
	 * @param string $type MIME type.
	 * @param string $path Path on disk.
	 * @return File File object from which the assigned cardinal number can be
	 * retrieved.
	 * @throws SQLException
	 * @throws ErrorException
	 */
	function appendFile($name, $type, $path)
	{
		// User is prepared to wait a bit for upload anyway, so it does not
		// hurt doing some house keeping from time to time:
		if( time() % 10 == 0 )
			$this->cleanup();
		
		// Retrieve folder ID if not saved yet:
		if( $this->folder_id < 0 )
			$this->save();
		return $this->files[] = File::fromFile($this->folder_id, count($this->files), $name, $type, $path);
	}
	
	/**
	 * Delete the file given its cardinal number. If the resulting folder
	 * is empty, the folder state is reset and deleted.
	 * @param int $cardinal
	 * @throws SQLException
	 */
	function deleteFile($cardinal)
	{
		$strip = /*. (File[int]) .*/ [];
		foreach($this->files as $a){
			if( $a->cardinal == $cardinal )
				$a->delete();
			else
				$strip[] = $a;
		}
		$this->files = $strip;
		if( count($this->files) == 0 )
			$this->delete();
	}
	
	/**
	 * Finalizes this folder for permanent storage in the DB. Client code should
	 * always invoke this method to confirm the current folder ID has been stored
	 * permanently somewhere in the DB. Client code should NOT invoke this method
	 * if the folder ID has not been permanently stored, for example because the
	 * form editing has been rejected by user.
	 * @throws SQLException
	 */
	function finalize()
	{
		if( count($this->files) == 0 ){
			$this->delete();
		} else {
			$this->finalized = TRUE;
			$this->save();
		}
	}
	
}
