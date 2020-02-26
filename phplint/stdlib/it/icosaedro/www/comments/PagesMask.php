<?php
namespace it\icosaedro\www\comments;
require_once __DIR__ . "/../../../../all.php";
use RuntimeException;
use it\icosaedro\sql\SQLException;
use it\icosaedro\web\bt_\Form;
use it\icosaedro\web\Http;
use it\icosaedro\web\Html;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\www\SiteSpecific;
use it\icosaedro\www\Common;

/**
 * Displays all the pages that received at least one comment.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/10 07:16:10 $
 */
class PagesMask extends Form {

	/**
	 * @throws SQLException
	 */
	private function render_exception()
	{
		$sql = <<< EOT
			SELECT path, subject, time, current_name
			FROM comments
			WHERE (path, time) IN (SELECT path, max(time) FROM comments GROUP BY path)
			ORDER BY path ASC
EOT;
		$res = SiteSpecific::getDB()
		->prepareStatement($sql)
		->query();

		$n = $res->getRowCount();
		
		Http::headerContentTypeHtmlUTF8();
		echo "<html><body>";
		Common::echoNavBar();
		echo "<h1>Commented pages</h1>";

		if( $n == 0 ){
			echo 'Currently no comments are available in this WEB site.';
		} else {
			echo "Latest comments highlighted:<p>";
			echo '<table cellpadding=3 cellspacing=2>';
			echo '<tr bgcolor=#eeee55>';
			echo '<th>Page</th>';
			echo '<th colspan=3>Last message</th>';
			echo '</tr>';
			$now = time();
			for( $i = 0; $i < $n; $i++ ){
				$res->moveToRow($i);
				$path = $res->getStringByName('path');
				$subject = Common::short($res->getStringByName('subject'), 100);
				$time = (int) $res->getStringByName('time');
				$current_name = Common::short($res->getStringByName('current_name'), 20);
				if( $time > $now - 7*24*60*60 )
					$c = "bgcolor=#ffaaaa";
				else if( $time > $now - 30*24*60*60 )
					$c = "bgcolor=#ffcc00";
				else
					$c = "";
				echo '<tr>';
				echo '<td>';
				UserSession::anchor(Html::text($path), "it\\icosaedro\\www\\comments\\PageCommentsMask::enter", $path);
				echo '</td>';
				echo "<td $c>", \it\icosaedro\www\Common::formatTS($time), '</td>';
				echo '<td>', Html::text($current_name), '</td>';
				echo '<td><b>', Html::text($subject), '</b></td>';
				echo '</tr>';
			}
			echo '</table>';
		}

		Common::echoPageFooter();
	}
	
	
	function render()
	{
		try {
			$this->render_exception();
		} catch (SQLException $e) {
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
	}
	
	
	static function enter()
	{
		$f = new self();
		$f->render();
	}
	
	function browserReloadEvent()
	{
		self::enter();
	}
	
	function browserBackEvent()
	{
		\it\icosaedro\www\DashboardMask::enter();
	}

}
