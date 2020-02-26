<?php

namespace it\icosaedro\web\controls;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\web\Input;
use it\icosaedro\containers\Comparable;
use UnexpectedValueException;

/**
 * HTML single entry selection list box. For each option, a display string and a
 * value can be specified. The display string is what the user will see; the
 * value is any {@link it\icosaedro\containers\Comparable} object.
 * Values are never sent to the remote client and are not saved, so these must
 * be rebuilt for each page requests; only the selected value is saved.
 * 
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @copyright Copyright 2018 by icosaedro.it di Umberto Salsi
 * @version $Date: 2018/12/30 05:31:59 $
 */
class Select extends Control {
	
	/**
	 * Entries as seen by the user, listed in the order of the index.
	 * @var string[int]
	 */
	private $displays;
	
	/**
	 * Values the program associates to each entry of the list.
	 * @var Comparable[int]
	 */
	private $values;
	
	/**
	 * Value currently selected, possibly NULL if not set.
	 * @var Comparable
	 */
	private $value;
	
	/**
	 * Returns the index of the first occurrence of the value in the list.
	 * @param Comparable $value
	 * @throws UnexpectedValueException Value not found in the list.
	 */
	private function search($value)
	{
		foreach($this->values as $i => $v)
			if( $v->equals($value) )
				return $i;
		throw new UnexpectedValueException("value not found");
	}
	
	
	/**
	 * Returns the selected value.
	 * @return Comparable Selected value, possibly null if no selection has been
	 * made and no initial value was selected, or if the list is empty.
	 */
	function getValue()
	{
		return $this->value;
	}
	
	/**
	 * Set the currently selected value. The default is the first of the list.
	 * @param Comparable $value Selected value. If NULL, the first entry of the
	 * menu will be rendered as "selected" and retrieved in the postback.
	 * @return void
	 * @throws UnexpectedValueException Value not in the list.
	 */
	function setValue($value)
	{
		if( $value !== NULL )
			/* ignore = */ $this->search($value);
		$this->value = $value;
	}
	
	
	/**
	 * Appends an entry to the menu.
	 * @param string $display Displayed description of the entry.
	 * @param Comparable $value Value of the entry. This value is not sent to
	 * the remote client.
	 */
	function addValue($display, $value)
	{
		$this->displays[] = $display;
		$this->values[] = $value;
	}
	
	function save()
	{
		$this->_form->setData($this->_name, $this->value);
	}
	
	function resume()
	{
		$this->value = cast(Comparable::class, $this->_form->getData($this->_name));
	}
	
	/**
	 * Sends this control to the standard output.
	 * @return void
	 */
	function render()
	{
		$selected_index = 0; // first selected by default
		if( $this->value !== NULL )
			$selected_index = $this->search($this->value);
		
		echo "<select name='", $this->_name, "' ", $this->_add_attributes, ">";
		foreach($this->displays as $i => $s){
			echo "<option value=$i",
				($i == $selected_index? " selected" : ""),
				">", htmlspecialchars($s), "</option>";
		}
		echo "</select>";
	}
	
	function retrieve()
	{
		$s = Input::getLine($this->_name, NULL);
		if( $s === NULL )
			$this->setValue(NULL);
		else
			$this->setValue($this->values[ (int) $s ]);
	}
	
}
