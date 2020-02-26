<?php

/*. require_module 'core'; .*/

namespace it\icosaedro\phplint;

#require_once __DIR__ . "/../../../autoload.php";
require_once __DIR__ . "/TypeInterface.php";


/**
	Singleton object that represents the int type.
	The Types::parseType() method uses this class to represent the result
	of the compilation of a textual type descriptor.
	@author Umberto Salsi <salsi@icosaedro.it>
	@version $Date: 2016/01/26 12:26:57 $
*/
final class IntType implements TypeInterface {

	private static /*. self .*/ $singleton;

	private /*. void .*/ function __construct(){}

	/**
		Return the instance that represents the int type.
		@return self
	*/
	static function factory()
	{
		if( self::$singleton === NULL )
			self::$singleton = new IntType();
		return self::$singleton;
	}


	/**
		Checks if the expression or variable passed is of type int.
		@param mixed $v Any expression or variable.
		@return bool True if the expression is of the type int.
	*/
	function check($v)
	{
		return is_int($v);
	}


	/**
		Returns the descriptor of this type, that is "int".
		@return string The string "int".
	*/
	function __toString()
	{
		return "int";
	}

}
