<?php

namespace it\icosaedro\web\controls;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\web\Html;
use it\icosaedro\web\Input;

/**
 * Single-line HTML text entry control with associated list of selectable values.
 * Implements the HTML5 input data list control. Basically, the uses may enter
 * any string, but he may also pick a value from the list or type-in any
 * sub-string to get a partial list of matching values to choose from. The list
 * is not saved in the page state, only the current entered value is.
 * 
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @copyright Copyright 2018 by icosaedro.it di Umberto Salsi
 * @version $Date: 2018/12/22 23:25:54 $
 */
class LineCombo extends Line {
	
	/**
	 * @var string[int]
	 */
	private $values = [];
	
	/**
	 * Set the values associated to this control.
	 * @param string[int] $values
	 */
	function setList($values)
	{
		$this->values = $values;
	}
	
	/**
	 * Send this control to the standard output.
	 * @return void
	 */
	function render()
	{
		$list_id = $this->_name . "_values";
		echo "<input list='$list_id",
				"' name='", $this->_name,
				"' value='", Html::text($this->getValue()),
				"' ", $this->_add_attributes, ">";
		echo "<datalist id='$list_id'>";
		foreach($this->values as $v)
			echo "<option value='", Html::text($v), "'>";
		echo "</datalist>";
	}
	
}
