<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\controls\ContainerInterface;
use it\icosaedro\web\controls\FileUpload;
use it\icosaedro\web\controls\Panel;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\web\Html;
use it\icosaedro\web\Log;
use it\icosaedro\web\FileDownload;
use ErrorException;
use RuntimeException;

/**
 * Folder of files, upload and download panel. Files can be added, deleted and
 * downloaded from this panel. When at least one file is present, an entry is
 * added to the "folders" table and its ID is retrieved; files are saved in the
 * "files" table and linked to that folder. As the number of files drops to zero
 * again, the folder is deleted along all its files. The client form may retrieve
 * the folder as its ID, possibly a negative number indicating there are not
 * files available:
 * <pre>
 * $folder_id = $thispanel-&gt;getValue()-&gt;getFolderID();
 * </pre>
 * 
 * <p>The client form should save the final folder ID somewhere so it can be
 * retrieved later, and then it should confirm these files have been confirmed
 * by invoking the "finalize()" method. Non-empty folders that have not been
 * finalized are periodically deleted to recover space in the data base.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/30 05:34:51 $
 */
class FolderUploadPanel extends Panel {
	
	/**
	 * Files in the current folder.
	 * @var Folder
	 */
	private $folder;
	
	/**
	 * File upload control.
	 * @var FileUpload
	 */
	private $upload;
	
	/**
	 * Upload failed reason, HTML format.
	 * @var string
	 */
	private $err;
	
	/**
	 * Initializes a new empty folder upload panel.
	 * @param ContainerInterface $form
	 * @param string $name
	 */
	function __construct($form, $name)
	{
		parent::__construct($form, $name);
		try {
			$this->folder = Folder::fromDB(-1);
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		$this->upload = new FileUpload($this, "upload", TRUE);
	}
	
	/**
	 * Sets the folder. The current non-finalized folder is deleted.
	 * @param Folder $folder
	 */
	function setValue($folder)
	{
		$this->folder = $folder;
	}
	
	/**
	 * Retrieves the current folder.
	 * @return Folder
	 */
	function getValue()
	{
		return $this->folder;
	}
	
	function save()
	{
		parent::save();
		$this->setData("folder_id", $this->folder->getFolderID());
		$this->setData("err", $this->err);
	}
	
	function resume()
	{
		parent::resume();
		try {
			$this->folder = Folder::fromDB((int) $this->getData("folder_id"));
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		$this->err = cast("string", $this->getData("err"));
	}
	
	/**
	 * Marks this folder as finalized, that is the client tells us the ID of this
	 * folder has been saved somewhere. The resulting folder ID can be retrieved
	 * from the folder public property. Folders that are not finalized are
	 * periodically deleted by the "Folder" class.
	 */
	function finalize()
	{
		try {
			$this->folder->finalize();
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
	
	/**
	 * Deletes this folder and all its files, restoring a dummy empty folder with
	 * negative ID.
	 */
	function delete()
	{
		try {
			$this->folder->delete();
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
	
	/**
	 * Displays this panel. The panel includes: all the files currently in this
	 * folder; each file can be downloaded to check its content or deleted;
	 * an upload button. Files must be uploaded one at a time. Possible upload
	 * errors are displayed in the panel itself.
	 */
	function render()
	{
		echo "<div>";
		
		if( count($this->folder->files) > 0 ){
			echo "Files:<br>\n";
			foreach($this->folder->files as $a){
				echo "&emsp;<tt>";
				UserSession::anchor(Html::text($a->name), self::class . "::downloadFileButton", $a->file_id);
				echo "</tt>, ", Html::text($a->type), ", ", $a->length, " bytes ";
				$this->button("Delete", "deleteFileButton", $a->cardinal);
				echo "<br>\n";
			}
		}
		
		// Display reason why last upload failed:
		if( strlen($this->err) > 0 ){
			Html::errorBox($this->err);
			$this->err = NULL;
		}
		
		$max_file_size = FileUpload::maxUploadFileSize();
		if( $max_file_size == 0 ){
			echo "<i>File upload disabled -- check php.ini.</i>";
			return;
		}
		
		// Customized file upload control. The user will see a single "Add
		// file..." button; by pressing that button, the file selection
		// mask displays.
		echo "<span style='display: none;'>";
		$baseid = $this->getName();
		$this->upload->addAttributes("id=$baseid.choose_file_button");
		$this->upload->render();
		$this->addAttributes("id=$baseid.submit_file_button");
		$this->button("Append", "appendUploadedFileButton");
		echo "</span>";
		echo "<button onclick=\""
			. "    var choose_file_button = document.getElementById('$baseid.choose_file_button');"
			. "    choose_file_button.onchange = function(){ document.getElementById('$baseid.submit_file_button').click(); };"
			. "    choose_file_button.click();"
				. "return false;"
			. "\">Add file...</button>";
		echo " (max $max_file_size bytes)";
		
		echo "</div>";
	}
	
	/**
	 * File upload button event handler for internal use only.
	 */
	function appendUploadedFileButton()
	{
		if( ! $this->upload->isAvailable() )
			return;
		
		// Add file to folder:
		try {
			$this->folder->appendFile($this->upload->getFilename(),
				$this->upload->getType(), $this->upload->getTemporaryFilename());
		}
		catch(SQLException $e){
			Log::error("$e");
			$this->err = "Sorry, file upload failed: " . Html::text($e->getMessage());
			Common::resetCachedDB();
		}
		catch(ErrorException $e){
			Log::error("$e");
			$this->err = "Sorry, file upload failed: " . Html::text($e->getMessage());
		}
		
		// Reset file upload control:
		$this->upload->delete();
	}
	
	/**
	 * File download button event handler for internal use only.
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
	
	/**
	 * File delete button event handler for internal use only.
	 * @param int $cardinal
	 */
	function deleteFileButton($cardinal)
	{
		try {
			$this->folder->deleteFile($cardinal);
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		$this->render();
	}
	
}
