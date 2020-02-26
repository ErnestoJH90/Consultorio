<?php

namespace it\icosaedro\www\its;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\bt_\Form;
use it\icosaedro\web\Http;
use it\icosaedro\web\Html;
use it\icosaedro\web\controls\CheckBox;
use it\icosaedro\web\controls\Line;
use it\icosaedro\web\controls\LineCombo;
use it\icosaedro\web\controls\Select;
use it\icosaedro\web\controls\Spinner;
use it\icosaedro\web\controls\ParseException;
use it\icosaedro\web\Log;
use it\icosaedro\containers\IntClass;
use RuntimeException;
use InvalidArgumentException;

/**
 * Issue search mask.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/09 15:49:20 $
 */
class SearchMask extends Form {
	
	private $project_id = 0;
	
	/**
	 * @var CheckBox
	 */
	private $search_mask_is_visible;
	
	/**
	 * @var Line
	 */
	private $issue_numbers;
	
	/**
	 * @var Select
	 */
	private $status;
	
	/**
	 * @var Select
	 */
	private $category;
	
	/**
	 * @var LineCombo
	 */
	private $tags;
	
	/**
	 * @var Select
	 */
	private $created_by;
	
	/**
	 * @var Select
	 */
	private $assigned_to;
	
	/**
	 * @var Select
	 */
	private $created_time_ago;
	
	/**
	 *
	 * @var Select
	 */
	private $modified_time_ago;
	
	/**
	 * @var Line
	 */
	private $words;
	
	/**
	 * @var Spinner
	 */
	private $results_per_page;
	
	private $offset = 0;
	
	private $order_by = "issues.number";
	
	private $ascending = FALSE;
	
	/**
	 * Number of the latest view issue. Latest view issue is highlighted in the
	 * list to help finding the next one to view. Negative if not available.
	 * @var int
	 */
	private $latest_view_issue_number = 0;
	
	/**
	 * @param Select $c
	 */
	private function buildTimeAgoSelectControl($c)
	{
		$c->addValue("--", new IntClass(-1));
		$c->addValue("1 day ago", new IntClass(1));
		$c->addValue("2 days ago", new IntClass(2));
		$c->addValue("1 week ago", new IntClass(7));
		$c->addValue("2 weeks ago", new IntClass(14));
		$c->addValue("1 month ago", new IntClass(31));
		$c->addValue("2 months ago", new IntClass(62));
		$c->addValue("6 months ago", new IntClass(6*31));
		$c->addValue("1 year ago", new IntClass(365));
		$c->addValue("2 years ago", new IntClass(2*365));
		$c->addValue("5 years ago", new IntClass(5*365));
		$c->addValue("10 years ago", new IntClass(10*365));
		$c->setValue(new IntClass(-1));
	}
	
	function __construct()
	{
		parent::__construct();
		
		$this->search_mask_is_visible = new CheckBox($this, "searchMaskVisible", "Search mask");
		$this->search_mask_is_visible->setChecked(TRUE);
		
		$this->issue_numbers = new Line($this, "issue_numbers");
		
		$this->status = new Select($this, "status");
		$this->status->addValue("--", new IntClass(-1));
		$this->status->addValue("OPEN", new IntClass(1));
		$this->status->addValue("CLOSED", new IntClass(0));
		$this->status->setValue(new IntClass(-1));
		
		$this->category = new Select($this, "category");
		$this->category->addValue("--", new IntClass(-1));
		FieldCategory::fillMenu($this->category);
		$this->category->setValue(new IntClass(-1));
		
		$this->tags = new LineCombo($this, "tags");
		
		// Will add users once the project ID is known:
		$this->created_by = new Select($this, "created_by");
		$this->created_by->addValue("--", new IntClass(-1));
		$this->created_by->setValue(new IntClass(-1));
		
		// Will add users once the project ID is known:
		$this->assigned_to = new Select($this, "assigned_to");
		$this->assigned_to->addValue("NOBODY", new IntClass(-2));
		$this->assigned_to->addValue("--", new IntClass(-1));
		$this->assigned_to->setValue(new IntClass(-1));
		
		$this->created_time_ago = new Select($this, "created_time_ago");
		$this->buildTimeAgoSelectControl($this->created_time_ago);
		
		$this->modified_time_ago = new Select($this, "modified_time_ago");
		$this->buildTimeAgoSelectControl($this->modified_time_ago);
		
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
		$this->setData("order_by", $this->order_by);
		$this->setData("ascending", $this->ascending);
		$this->setData("latest_view_issue_number", $this->latest_view_issue_number);
	}
	
	function resume()
	{
		parent::resume();
		$this->project_id = (int) $this->getData("project_id");
		$this->tags->setList(FieldTags::getCachedTagsForProject($this->project_id));
		Users::fillMembersMenu($this->project_id, $this->created_by);
		Users::fillMembersMenu($this->project_id, $this->assigned_to);
		$this->offset = (int) $this->getData("offset");
		$this->order_by = (string) $this->getData("order_by");
		$this->ascending = (boolean) $this->getData("ascending");
		$this->latest_view_issue_number = (int) $this->getData("latest_view_issue_number");
	}
	
	/**
	 * Displays table header for a specific column.
	 * @param string $display Displayed name of the column.
	 * @param string $order_by DB field name of this column.
	 */
	private function echoColumnHead($display, $order_by)
	{
		echo "<th>";
		if( $order_by === $this->order_by )
			$this->anchor($display . ($this->ascending? " \u{25bc}":" \u{25b2}"),
				"setOrderByButton", $order_by, ! $this->ascending);
		else
			$this->anchor($display, "setOrderByButton", $order_by, TRUE);
		echo "</th>";
	}
	
	/**
	 * @throws SQLException
	 */
	private function displayResults()
	{
		$err = "";
		
		$db = Common::getDB();
		
		$sql = <<< EOT
				select distinct
					issues.number,
					issues.created_time,
					issues.modified_time,
					issues.is_open,
					issues.category,
					issues.tags,
					issues.subject,
					issues.assigned_to,
					icodb.users.current_name
				from  issues
				join  messages
				left join  icodb.users
				on icodb.users.pk = issues.assigned_to
EOT;
		$where = " where issues.project_id=" . $this->project_id
			." and messages.project_id=" . $this->project_id
			." and messages.issue_number=issues.number";
		
		// Parse issues numbers:
		$where_numbers = "";
		$a = explode(" ", $this->issue_numbers->getValue());
		foreach($a as $w){
			if( strlen($w) == 0 )
				continue;
			try {
				$n = IntClass::parse($w);
			}
			catch(InvalidArgumentException $e){
				$err .= "Invalid syntax for issue number \"" . Html::text($w) . "\".<p>";
				continue;
			}
			if( $n < 0 ){
				$err .= "Negative issue number \"" . Html::text($w) . "\".<p>";
				continue;
			}
			if( strlen($where_numbers) > 0 )
				$where_numbers .= " or ";
			$where_numbers .= "issues.number=$n";
		}
		if( strlen($where_numbers) > 0 )
			$where .= " and ($where_numbers)";
		
		$status = cast(IntClass::class, $this->status->getValue())->getValue();
		if( $status == 1 )
			$where .= " and issues.is_open";
		else if( $status == 0 )
			$where .= " and not issues.is_open";
		
		$category = cast(IntClass::class, $this->category->getValue())->getValue();
		if( $category >= 0 )
			$where .= " and issues.category=$category";
		
		$tags = $this->tags->getValue();
		if( strlen($tags) > 0 ){
			$w = (string) str_replace(array('\\', '_', '%'), array('\\\\', '\\_', '\\%'), $tags);
			$where .= " and issues.tags like '%" . $db->escape($w) . "%'";
		}
		
		// The creator of the issue is the creator of the first message bound to
		// the issue, that is the message with the same TS of the issue.
		// FIXME: search for words is then performed only on the first message,
		// not over the entire issue history.
		$created_by = cast(IntClass::class, $this->created_by->getValue())->getValue();
		if( $created_by >= 0 )
			$where .= " and messages.created_by = $created_by and messages.created_time = issues.created_time";
		
		$assigned_to = cast(IntClass::class, $this->assigned_to->getValue())->getValue();
		if( $assigned_to == -2 )
			$where .= " and issues.assigned_to is null";
		else if( $assigned_to >= 0 )
			$where .= " and issues.assigned_to = $assigned_to";
		
		$days_ago = cast(IntClass::class, $this->created_time_ago->getValue())->getValue();
		if( $days_ago > 0 )
			$where .= " and issues.created_time >= " . (time() - 86400*$days_ago);
		
		$days_ago = cast(IntClass::class, $this->modified_time_ago->getValue())->getValue();
		if( $days_ago > 0 )
			$where .= " and issues.modified_time >= " . (time() - 86400*$days_ago);
		
		// Parse words:
		$s = $this->words->getValue();
		$a = explode(" ", $this->words->getValue());
		foreach($a as $w){
			if( strlen($w) == 0 )
				continue;
			// search word in both issues.subject and messages.content:
			$w = (string) str_replace(array('\\', '_', '%'), array('\\\\', '\\_', '\\%'), $w);
			$w = $db->escape($w);
			$where .= " and (issues.subject like '%$w%'"
				." or messages.content like '%$w%')";
		}
		
		try {
			$results_per_page = $this->results_per_page->parse();
		}
		catch(ParseException $e){
			$err .= "Invalid number of results per page.";
			$results_per_page = 1;
		}
		
		if( strlen($err) > 0 ){
			Html::errorBox($err);
			return;
		}
		
		// Adjust offset according to current results-per-page, had the user
		// changed the spinner and then pressed the page prev or next button
		// rather than the "Search" first:
		$this->offset -= $this->offset % $results_per_page;
		
		// Compose final query:
		$sql .= $where
		. " order by " . $this->order_by . ($this->ascending? " asc":" desc")
		. " limit $results_per_page offset " . $this->offset;
		//echo "<tt>", Html::text($sql), "</tt><p>";
		try {
			$res = $db->query($sql);
		}
		catch(SQLException $e){
			Log::error("$e");
			Html::errorBox("<pre>" . Html::text($e->getMessage()) . "</pre>");
			return;
		}
		
		if( $res->getRowCount() == 0 && $this->offset == 0 ){
			echo "<p><i>No issues found matching these search criteria.</i></p>";
			return;
		}
		echo "<p><table cellspacing=0 cellpadding=3 border=0><tr bgcolor='#cccccc'>";
		$this->echoColumnHead("Created",  "issues.created_time");
		$this->echoColumnHead("Modified", "issues.modified_time");
		$this->echoColumnHead("Status",   "issues.is_open");
		$this->echoColumnHead("Category", "issues.category");
		$this->echoColumnHead("Tags",     "issues.tags");
		$this->echoColumnHead("Number",   "issues.number");
		$this->echoColumnHead("Subject",  "issues.subject");
		$this->echoColumnHead("Assignee", "icodb.users.current_name");
		echo "</tr>";
		for($i = 0; $i < $res->getRowCount(); $i++){
			$res->moveToRow($i);
			$number = $res->getIntByName("number");
			$created_time = $res->getIntByName("created_time");
			$modified_time = $res->getIntByName("modified_time");
			$is_open = $res->getBooleanByName("is_open");
			$category_name = FieldCategory::codeToName($res->getIntByName("category"));
			$tags = $res->getStringByName("tags");
			$subject = $res->getStringByName("subject");
			$assigned_to = $res->getIntByName("assigned_to");
			if( $res->wasNull() )
				$assigned_to = -1;
			$current_name = $res->getStringByName("current_name");
			if( $number == $this->latest_view_issue_number )
				$bgcolor = "bgcolor='#bbffbb'";
			else if( ($i & 1) == 1 )
				$bgcolor = "bgcolor='#eeeeee'";
			else
				$bgcolor = "";
			echo "<tr $bgcolor>";
			echo "<td>", \it\icosaedro\www\Common::formatTS($created_time);
			echo "</td><td>", \it\icosaedro\www\Common::formatTS($modified_time);
			echo "</td><td>", ($is_open? "OPEN" : "CLOSED");
			echo "</td><td>$category_name";
			echo "</td><td>", Html::text($tags);
			echo "</td><td align=right>", $number;
			echo "</td><td>";
			$this->anchor(Html::text($subject), "viewIssueButton", $number);
			echo "</td><td>", ($current_name === NULL? "<i>nobody</i>" : Html::text($current_name));
			echo "</td></tr>";
		}
		echo "</table>";
		
		echo "Page";
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
		echo "<h2>Advanced Search</h2>";
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
		
		echo "Issue number(s): ";
		$this->issue_numbers->addAttributes("size=40 oninput='setStyleOnChange(this);'");
		$this->issue_numbers->render();
		
		echo "&emsp;Status: ";
		$this->status->addAttributes("onchange='setStyleOnChange(this);'");
		$this->status->render();
		
		echo "&emsp;Category: ";
		$this->category->addAttributes("onchange='setStyleOnChange(this);'");
		$this->category->render();
		
		echo "&emsp;Tags: ";
		$this->tags->addAttributes("onchange='setStyleOnChange(this);'");
		$this->tags->render();
		
		echo "<p>Created by: ";
		$this->created_by->addAttributes("onchange='setStyleOnChange(this);'");
		$this->created_by->render();
		
		echo "&emsp;Assigned to: ";
		$this->assigned_to->addAttributes("onchange='setStyleOnChange(this);'");
		$this->assigned_to->render();
		
		echo "<p>Created up to: ";
		$this->created_time_ago->addAttributes("onchange='setStyleOnChange(this);'");
		$this->created_time_ago->render();
		
		echo "&emsp;Modified up to: ";
		$this->modified_time_ago->addAttributes("onchange='setStyleOnChange(this);'");
		$this->modified_time_ago->render();
		
		echo "<p>Words: ";
		$this->words->addAttributes("size=60 oninput='setStyleOnChange(this);'");
		$this->words->render();
		
		echo "&emsp;Results per page: ";
		$this->results_per_page->render();
		
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
		$m->tags->setList(FieldTags::getCachedTagsForProject($project_id));
		Users::fillMembersMenu($project_id, $m->created_by);
		Users::fillMembersMenu($project_id, $m->assigned_to);
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
		$this->order_by = $order_by;
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
