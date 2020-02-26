<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\bt_\Form;
use it\icosaedro\web\Http;
use it\icosaedro\web\Html;
use it\icosaedro\web\controls\CheckBox;
use it\icosaedro\web\controls\Line;
use it\icosaedro\web\controls\Select;
use it\icosaedro\web\controls\Spinner;
use it\icosaedro\web\controls\ParseException;
use it\icosaedro\web\Log;
use it\icosaedro\containers\IntClass;
use RuntimeException;

/**
 * Issue quick search mask. Allows to search issues for words giving a score.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/09 15:49:38 $
 */
class SearchQuickMask extends Form {
	
	private $project_id = 0;
	
	/**
	 * @var CheckBox
	 */
	private $search_mask_is_visible;
	
	/**
	 * @var Select
	 */
	private $status;
	
	/**
	 * @var Select
	 */
	private $category;
	
	/**
	 * @var Line
	 */
	private $words;
	
	/**
	 * @var Spinner
	 */
	private $results_per_page;
	
	private $offset = 0;
	
	private $ascending = FALSE;
	
	/**
	 * Number of the latest view issue. Latest view issue is highlighted in the
	 * list to help finding the next one to view. Negative if not available.
	 * @var int
	 */
	private $latest_view_issue_number = 0;
	
	function __construct()
	{
		parent::__construct();
		
		$this->search_mask_is_visible = new CheckBox($this, "searchMaskVisible", "Search mask");
		$this->search_mask_is_visible->setChecked(TRUE);
		
		$this->status = new Select($this, "status");
		$this->status->addValue("--", new IntClass(-1));
		$this->status->addValue("OPEN", new IntClass(1));
		$this->status->addValue("CLOSED", new IntClass(0));
		$this->status->setValue(new IntClass(-1));
		
		$this->category = new Select($this, "category");
		$this->category->addValue("--", new IntClass(-1));
		FieldCategory::fillMenu($this->category);
		$this->category->setValue(new IntClass(-1));
		
		$this->words = new Line($this, "words");
		
		$this->results_per_page = new Spinner($this, "results_per_page");
		$this->results_per_page->setMinMaxStep(1, 1000000, 1);
		$this->results_per_page->setInt(20);
		
		$this->offset = 0;
	}
	
	function save()
	{
		parent::save();
		$this->setData("project_id", $this->project_id);
		$this->setData("offset", $this->offset);
		$this->setData("latest_view_issue_number", $this->latest_view_issue_number);
	}
	
	function resume()
	{
		parent::resume();
		$this->project_id = (int) $this->getData("project_id");
		$this->offset = (int) $this->getData("offset");
		$this->latest_view_issue_number = (int) $this->getData("latest_view_issue_number");
	}
	
	/**
	 * @throws SQLException
	 */
	private function displayResults()
	{
		$db = Common::getDB();
		$err = "";
		
		// search among issues status, category, subject and tags:
		$where_issue = "issues.project_id = " . $this->project_id;
		
		// search among messages content:
		$where_message = "issues.project_id = " . $this->project_id
			." and messages.project_id = " . $this->project_id
			." and messages.issue_number = issues.number";
		
		// status:
		$status = cast(IntClass::class, $this->status->getValue())->getValue();
		if( $status == 1 ){
			$where_issue .= " and issues.is_open";
			$where_message .= " and issues.is_open";
		} else if( $status == 0 ){
			$where_issue .= " and not issues.is_open";
			$where_message .= " and not issues.is_open";
		}
		
		// category:
		$category = cast(IntClass::class, $this->category->getValue())->getValue();
		if( $category >= 0 ){
			$where_issue .= " and issues.category = $category";
			$where_message .= " and issues.category = $category";
		}
		
		// words:
		$s = $this->words->getValue();
		$a = explode(" ", $this->words->getValue());
		foreach($a as $w){
			if( strlen($w) == 0 )
				continue;
			$w = (string) str_replace(array('\\', '_', '%'), array('\\\\', '\\_', '\\%'), $w);
			$w = $db->escape($w);
			$where_issue .= " and (issues.subject like '%$w%'"
				." or issues.tags like '%$w%')";
			$where_message .= " and messages.content like '%$w%'";
		}
		
		try {
			$results_per_page = $this->results_per_page->parse();
		}
		catch(ParseException $e){
			$err .= "<p>Invalid number of results per page.";
			$results_per_page = 1;
		}
		
		$sql = <<< EOT
select
	number,
	is_open,
	category,
	tags,
	subject,
	sum(partial_score) as score
from (
	select
		issues.number,
		issues.is_open,
		issues.category,
		issues.tags,
		issues.subject,
		10 as partial_score
	from issues
	where $where_issue
    
	union

	select
		issues.number,
		issues.is_open,
		issues.category,
		issues.tags,
		issues.subject,
		2 as partial_score
	from issues, messages
	where $where_message
) as raw_select
group by number
order by score desc, number desc
EOT;
		
		if( strlen($err) > 0 ){
			Html::errorBox($err);
			return;
		}
		
		// Adjust offset according to current results-per-page, had the user
		// changed the spinner and then pressed the page prev or next button
		// rather than the "Search" first:
		$this->offset -= $this->offset % $results_per_page;
		
		// paging:
		$sql .= " limit $results_per_page offset " . $this->offset;
		//echo "<tt>", Html::text($sql), "</tt><p>";
		
		try {
			$res = $db->query($sql);
		}
		catch(SQLException $e){
			Log::error("$e");
			Html::errorBox("<tt>" . Html::text($e->getMessage()) . "</tt>");
			return;
		}
		
		if( $res->getRowCount() == 0 && $this->offset == 0 ){
			echo "<p><i>No issues found matching these search criteria.</i></p>";
			return;
		}
		echo "<p>";
		for($i = 0; $i < $res->getRowCount(); $i++){
			$res->moveToRow($i);
			$score = $res->getIntByName("score");
			$number = $res->getIntByName("number");
			$is_open = $res->getBooleanByName("is_open");
			$category_name = FieldCategory::codeToName($res->getIntByName("category"));
			$tags = $res->getStringByName("tags");
			$subject = $res->getStringByName("subject");
			if( $number == $this->latest_view_issue_number )
				$bgcolor = "#bbffbb";
			else if( ($i & 1) == 1 )
				$bgcolor = "#eeeeee";
			else
				$bgcolor = "#ffffff";
			
			echo "<div style='background-color: $bgcolor; padding: 0.5em;'><big>#$number ";
			$this->anchor(Html::text($subject), "viewIssueButton", $number);
			echo "</big>",
				" (score $score)",
				"<br>Status: ", ($is_open? "OPEN" : "CLOSED"),
				"&emsp;Category: $category_name",
				"&emsp;Tags: ", Html::text($tags),
				"</div>";
		}
		
		echo "<hr>Page";
		// Prev page:
		if( $this->offset > 0 ){
			$offset = $this->offset - $results_per_page;
			if( $offset < 0 )
				$offset = 0;
			echo "&emsp;";
			$this->button(" \u{25c4} ", "moveOffsetButton", $offset);
		}
		// Current page:
		echo "&emsp;", intdiv($this->offset, $results_per_page) + 1;
		// Next page:
		if( $res->getRowCount() >= $results_per_page ){
			echo "&emsp;";
			$this->button(" \u{25ba} ", "moveOffsetButton", $this->offset + $results_per_page);
		}
		
	}
	
	/**
	 * @param boolean $do_search If the result of the search has to presented.
	 * Entering the mask for the first time, the search should not be made.
	 */
	function render($do_search = TRUE)
	{
		Http::headerContentTypeHtmlUTF8();
		echo "<html><head>";
		include_once __DIR__ . "/FormStylesAndJS.php";
		echo "</head><body>";
		Common::echoNavBar($this->project_id, -1);
		echo "<h2>Quick Search</h2>";
		$this->open();
		
		// Checkbox to make visible/invisible "search mask" area:
		echo "<fieldset id=searchMaskArea style='background-color: #dddddd;'>",
			"<legend>";
		$this->search_mask_is_visible->addAttributes("id=searchMaskVisible onclick='setVisibilityToggle(\"searchMaskVisible\", \"searchMaskDiv\");'");
		$this->search_mask_is_visible->render();
		echo "</legend>";
		echo "<div id=searchMaskDiv>";
		// Make the "search mask" input area visible according to the checkbox:
		echo "<script>setVisibilityToggle(\"searchMaskVisible\", \"searchMaskDiv\");</script>";
		
		echo "Status: ";
		$this->status->addAttributes("onchange='setStyleOnChange(this);'");
		$this->status->render();
		
		echo "&emsp;Category: ";
		$this->category->addAttributes("onchange='setStyleOnChange(this);'");
		$this->category->render();
		
		echo "<p>Words: ";
		$this->words->addAttributes("size=60 oninput='setStyleOnChange(this);'");
		$this->words->render();
		
		echo "&emsp;Results per page: ";
		$this->results_per_page->render();
		
		echo "<p>Only the issues that contains all the words are returned. Subject and tags hits gets the higher score, each comment hit gets a lower score.</p>";
		
		echo "<p>";
		$this->button("Search", "searchButton");
		
		echo "</div>",
			"</fieldset>";
		
		try {
			if( $do_search )
				$this->displayResults();
		}
		catch(SQLException $e){
			throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
		}
		$this->close();
		\it\icosaedro\www\Common::echoPageFooter();
	}
	
	/**
	 * Entry point of this mask.
	 * @param int $project_id
	 */
	static function enter($project_id)
	{
		$m = new self();
		$m->project_id = $project_id;
		$m->render(FALSE);
	}
	
	function searchButton()
	{
		$this->offset = 0;
		$this->render();
	}
	
	/**
	 * Set the sorting field.
	 * @param string $order_by
	 * @param boolean $ascending
	 */
	function setOrderByButton($order_by, $ascending)
	{
		$this->ascending = $ascending;
		$this->offset = 0;
		$this->render();
	}
	
	function browserBackEvent()
	{
		ProjectDashboardMask::enter($this->project_id);
	}
	
	function browserReloadEvent()
	{
		$this->searchButton();
	}
	
	/**
	 * View issue page.
	 * @param int $issue_number
	 */
	function viewIssueButton($issue_number)
	{
		$this->latest_view_issue_number = $issue_number;
		$this->returnTo("render");
		IssueMask::enter($this->project_id, $issue_number, NULL);
	}
	
	/**
	 * Paging.
	 * @param int $new_offset
	 */
	function moveOffsetButton($new_offset)
	{
		$this->offset = $new_offset;
		$this->render();
	}
	
}
