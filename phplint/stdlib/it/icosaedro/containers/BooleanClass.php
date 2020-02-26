<?php

namespace it\icosaedro\containers;

require_once __DIR__ . "/../../../autoload.php";
require_once __DIR__ . "/../../../cast.php";
use CastException;

/**
 * Immutable object that holds a boolean value. Since there are only 2 instances
 * of this class, a factory method is provided rather than a constructor.
 *
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/10 08:57:57 $
 */
class BooleanClass implements Hashable, Sortable, Printable {
	
	/**
	 * @var self
	 */
	private static $falseInstance, $trueInstance;
	
	/**
	 * @var boolean
	 */
	private $value = FALSE;
	
	
	/**
	 * @param boolean $value
	 */
	private function __construct($value) {
		$this->value = $value;
	}
	
	
	/**
	 * Returns the singleton instance of this class corresponding to the given
	 * boolean value.
	 * @param boolean $value
	 * @return self
	 */
	public static function getInstance($value) {
		if( self::$falseInstance === NULL ){
			self::$falseInstance = new self(FALSE);
			self::$trueInstance = new self(TRUE);
		}
		return $value? self::$trueInstance : self::$falseInstance;
	}
	
	
	/**
	 * @return string Either "FALSE" or "TRUE".
	 */
	public function __toString() {
		return $this->value? "TRUE" : "FALSE";
	}
	
	/**
	 * @return boolean
	 */
	public function getValue() {
		return $this->value;
	}
	
	/**
	 * @return int
	 */
	public function getHash() {
		return $this->value? 1 : 0;
	}
	
	/**
	 * @param object $other
	 * @return boolean
	 */
	public function equals($other) {
		if( $other === NULL )
			return FALSE;
		if( $other === $this )
			return TRUE;
		if( get_class($other) !== get_class($this) )
			return FALSE;
		return $this->value === cast(__CLASS__, $other)->value;
	}
	
	/**
	 * Compares this boolean with the other. FALSE is less than TRUE.
	 * @param object $other The other object.
	 * @return int Negative, zero or positive if $this is less, equal or
	 * greater than $other respectively.
	 * @throws CastException If the other object belongs to a different
	 * class and cannot be compared with this.
	 */
	function compareTo($other) {
		if ($other === NULL)
			throw new CastException("NULL");
		if (get_class($other) !== __CLASS__)
			throw new CastException("expected " . __CLASS__ . " but got " . get_class($other));
		if( $this === $other ){
			return 0;
		} else if( $this->value ){
			return +1;
		} else {
			return -1;
		}
	}
	
}
