<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\web\Html;
use it\icosaedro\web\FileDownload;
use it\icosaedro\sql\SQLException;
use RuntimeException;

/**
 * Displays files files from a folder and allows to download each file.
 * Files are sorted according to their cardinal number.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/22 23:42:26 $
 */
class FolderDownload {

	/**
	 * Displays folder contents.
	 * @param int $folder_id Folder ID in the "folders" DB table. If negative,
	 * does nothing.
	 */
	static function render($folder_id)
	{
		if( $folder_id < 0 )
			return;
		try {
			$folder = Folder::fromDB($folder_id);
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		if( count($folder->files) == 0 )
			return; // Folder class should have warned about empty or missing folder
		echo "<div>Files:<br>";
		foreach($folder->files as $a){
			echo "&emsp;<tt>";
			UserSession::anchor(Html::text($a->name), self::class . "::downloadFileButton", $a->file_id);
			echo "</tt>, ", Html::text($a->type),
				", ", $a->length, " bytes<br>";
		}
		echo "</div>";
	}
	
	/**
	 * Download file button event handler for internal use only.
	 * @param int $file_id
	 */
	static function downloadFileButton($file_id)
	{
		try {
			$db = Common::getDB();
			$res = $db->query("select * from files where id=$file_id");
			$res->moveToRow(0);
			$name = $res->getStringByName("name");
			$type = $res->getStringByName("type");
			$content = $res->getBytesByName("content");
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		FileDownload::sendHeaders($name, $type, TRUE);
		header("Content-Length: " . strlen($content));
		echo $content;
	}

}
