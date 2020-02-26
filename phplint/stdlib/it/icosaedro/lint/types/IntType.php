<?php

namespace it\icosaedro\lint\types;

require_once __DIR__ . "/../../../../all.php";

/**
 * Singleton instance of the integer number type.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/09 15:42:17 $
 */
final class IntType extends Type {
	
	/**
	 * @var IntType 
	 */
	private static $instance;
	
	private /*. void .*/ function __construct(){
	}
	
	
	/**
	 * @return boolean
	 */
	public function isPrintable() {
		return TRUE;
	}
	
	
	public static function getInstance(){
		if( self::$instance == NULL )
			self::$instance = new IntType();
		return self::$instance;
	}
	
	/**
	 *
	 * @param object $o
	 * @return boolean
	 */
	public function equals($o){
		return $o !== NULL and $this === $o;
	}
	
	/**
	 *
	 * @return string 
	 */
	public function __toString(){
		return "int";
	}
	
	
	/**
	 * Returns true if the left hand side (LHS) is int, mixed or unknown.
	 * Note that int cannot be assigned to string for efficiency reasons: at
	 * runtime, a variable formally detected to be string might be accessed
	 * character by character although being a number, so forcing PHP to
	 * perform a number-to-string conversion each time the "string" content is
	 * accessed. So, a int-to-string assignment requires a value typecast
	 * <code>$s = (int) $i;</code> Assignment to float requires the
	 * <code>(float)</code> value typecast as well.
	 * @param Type $lhs Type of the LHS.
	 * @return boolean True if this type is assignable to the LHS type.
	 */
	public function assignableTo($lhs){
		return ($lhs instanceof IntType)
		|| ($lhs instanceof MixedType)
		|| ($lhs instanceof UnknownType);
	}
	
	/**
	 * Int type can be cast() only to itself, mixed or to unknown.
	 * @param Type $lhs
	 * @return boolean
	 */
	public function canCastTo($lhs) {
		return ($lhs instanceof IntType)
		|| ($lhs instanceof MixedType)
		|| ($lhs instanceof UnknownType);
	}
	
}
