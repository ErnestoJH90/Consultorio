<?php

namespace it\icosaedro\www\its;
require_once __DIR__ . "/../../../../all.php";
use it\icosaedro\containers\IntClass;
use it\icosaedro\web\controls\Select;
use RuntimeException;

/**
 * ITS data base "category" field utilities.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/25 01:54:44 $
 */
class FieldCategory {
	
	const
		CATEGORY_GENERAL = 0,
		CATEGORY_FEATURE = 1,
		CATEGORY_TESTING = 2,
		CATEGORY_BUG = 3,
		CATEGORY_DOCUMENTATION = 4,
		CATEGORY_DEPLOYMENT = 5,
		CATEGORY_SUPPORT = 6;
	
	const MAP = [
		self::CATEGORY_GENERAL => "General",
		self::CATEGORY_FEATURE => "Feature",
		self::CATEGORY_TESTING => "Testing",
		self::CATEGORY_BUG => "Bug",
		self::CATEGORY_DOCUMENTATION => "Documentation",
		self::CATEGORY_DEPLOYMENT => "Deployment",
		self::CATEGORY_SUPPORT => "Support"
	];
	
	/**
	 * Maps category code to name.
	 * @param int $code
	 */
	static function codeToName($code)
	{
		if( array_key_exists($code, self::MAP) )
			return self::MAP[$code];
		else
			throw new RuntimeException("no this category: $code");
	}
	
	/**
	 * Adds all the categories to the menu.
	 * @param Select $menu
	 */
	static function fillMenu($menu)
	{
		foreach(self::MAP as $code => $display)
			$menu->addValue($display, new IntClass($code));
		$menu->setValue(new IntClass(self::CATEGORY_GENERAL));
	}
	
}
