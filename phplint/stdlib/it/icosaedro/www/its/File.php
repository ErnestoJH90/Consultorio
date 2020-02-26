<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\FileDownload;
use ErrorException;

/**
 * Holds a "file" stored in memory and saved in the DB. Two builder methods are
 * provided to create an instance from a file (fromFile) or from the DB (fromDB).
 * Several objects of this File class can then be organized in a object of the
 * Folder class.
 * 
 * <p>This class is intended to be used along with the Folder class to implement
 * file upload and download from web pages; see also the FolderUploadPanel class
 * and the FolderDownload class.
 * 
 * <p>BEWARE. All properties are intended to be "read-only"; do not overwrite
 * their content to prevent misalignment with the DB content.
 * 
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/09 15:48:31 $
 */
class File {
	
	/**
	 * This file DB record ID.
	 * @var int
	 */
	public $file_id = 0;
	
	/**
	 * Container folder DB record ID.
	 * @var int
	 */
	public $folder_id = 0;
	
	/**
	 * Files in a folder can be sorted by this field.
	 * @var int
	 */
	public $cardinal = 0;
	
	/**
	 * Displayed file name.
	 * @var string
	 */
	public $name;
	
	/**
	 * MIME type.
	 * @var string
	 */
	public $type;
	
	/**
	 * File length (bytes).
	 * @var int
	 */
	public $length = 0;
	
	/**
	 * PLEASE USE THE BUILDER METHODS INSTEAD.
	 */
	private function __construct()
	{
	}
	
	/**
	 * Builder from existing file. The specified file is read and saved in the
	 * DB and can then be deleted.
	 * @param int $folder_id
	 * @param int $cardinal
	 * @param string $name
	 * @param string $type
	 * @param string $path
	 * @return self
	 * @throws SQLException
	 * @throws ErrorException
	 */
	static function fromFile($folder_id, $cardinal, $name, $type, $path)
	{
		// Check file length vs. max allowed SQL statement length; accounts for
		// the extra +33% due to the Base64 encoding of our SQL driver and an
		// extra arbitrary safety margin of 999 bytes:
		$length = filesize($path);
		$max = Common::getMaxAllowedPacket()/3.0*4 - 999;
		if( $length > $max )
			throw new SQLException("file length $length bytes too big, max allowed is $max bytes -- check MySQL max_allowed_packet parameter.");
		
		$a = new self();
		$a->folder_id = $folder_id;
		$a->cardinal = $cardinal;
		$a->name = $name;
		$a->type = $type;
		$a->length = $length;
		$db = Common::getDB();
		$sql = "insert into files (folder_id, cardinal, name, type, length, content) values (?,?,?,?,?,?)";
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $folder_id);
		$ps->setInt(1, $cardinal);
		$ps->setString(2, $name);
		$ps->setString(3, $type);
		$ps->setInt(4, $a->length);
		$ps->setBytes(5, file_get_contents($path));
		$ps->update();
		$ps = NULL;
		$res = $db->query("select last_insert_id()");
		$res->moveToRow(0);
		$a->file_id = $res->getIntByIndex(0);
		return $a;
	}
	
	/**
	 * Builder for file from the DB.
	 * @param int $file_id
	 * @return self
	 * @throws SQLException
	 */
	static function fromDB($file_id)
	{
		$db = Common::getDB();
		$sql = "select folder_id, cardinal, name, type, length from files where id=?";
		$ps = $db->prepareStatement($sql);
		$ps->setInt(0, $file_id);
		$res = $ps->query();
		$res->moveToRow(0);
		$a = new self();
		$a->file_id = $file_id;
		$a->folder_id = $res->getIntByName("folder_id");
		$a->cardinal = $res->getIntByName("cardinal");
		$a->name = $res->getStringByName("name");
		$a->type = $res->getStringByName("type");
		$a->length = $res->getIntByName("length");
		return $a;
	}
	
	/**
	 * @throws SQLException
	 */
	function delete()
	{
		Common::getDB()->update("delete from files where id=" . $this->file_id);
	}
	
	/**
	 * Download this file.
	 * @param boolean $inline
	 * @throws SQLException
	 */
	function download($inline)
	{
		$res = Common::getDB()->query("select content from files where id=" . $this->file_id);
		$res->moveToRow(0);
		$content = $res->getBytesByIndex(0);
		$res = NULL;
		FileDownload::sendHeaders($this->name, $this->type, ! $inline);
		header("Content-Length: " . strlen($content));
		echo $content;
	}
	
}
