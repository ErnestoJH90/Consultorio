<?php

namespace it\icosaedro\lint;
require_once __DIR__ . "/../../../all.php";
use it\icosaedro\lint\Where;
use it\icosaedro\containers\Comparable;
use it\icosaedro\containers\Printable;

/**
 * Holds an `use' statement entry `use TARGET as ALIAS;'.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/09/10 14:40:12 $
 */
class UseEntry implements Comparable, Printable {

	/**
	 * Target namespace without leading \, as in `use TARGET as ALIAS'.
	 * @var string
	 */
	public $target;

	/**
	 * Alias argument of the "use" statement. If missing from the "use"
	 * statement, it is the last identifier of the target.
	 * @var string
	 */
	public $alias;

	/**
	 * How many times this entry has been used.
	 * @var int
	 */
	public $used = 0;

	/**
	 * Location of this `use' statement.
	 * @var Where 
	 */
	public $decl_in;
	
	
	/**
	 * Creates a new "use TARGET as ALIAS" entry.
	 * @param string $target Target name.
	 * @param string $alias Optional target name. If NULL, the last identifier
	 * of the target is assumed instead.
	 * @param Where $decl_in Location of the "use" statement.
	 * @return void
	 */
	public function __construct($target, $alias, $decl_in){
		$this->target = $target;
		if( $alias === NULL ){
			$trail_id_idx = strrpos($target, "\\");
			if( $trail_id_idx === FALSE )
				$alias = $target;
			else
				$alias = substr($target, $trail_id_idx + 1);
		}
		$this->alias = $alias;
		$this->used = 0;
		$this->decl_in = $decl_in;
	}
	
	
	/**
	 * Two 'use' statements are equal if the refer to the same alias class.
	 * @param object $other
	 * @return boolean
	 */
	function equals($other)
	{
		if( $other === NULL )
			return FALSE;
		if( $this === $other )
			return TRUE;
		if( get_class($other) !== get_class($this) )
			return FALSE;
		$other2 = cast(__CLASS__, $other);
		return strcasecmp($this->alias, $other2->alias) == 0;
	}
	
	
	/**
	 *
	 * @return string
	 */
	public function __toString(){
		return "use ". $this->target ." as ". $this->alias .";";
	}

}
