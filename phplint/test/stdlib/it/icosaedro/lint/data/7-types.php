<?php

/*
 * 'void' as array element is forbidden (PHP 5 and 7).
 */

$a1 = /*. (void[]) .*/ [];
$a2 = /*. (void[][]) .*/ [];
$a3 = /*. (array[]void) .*/ [];  // old syntax
$a4 = /*. (array[][]void) .*/ []; // old syntax
// Mixed type-hint + meta-code array syntax:
function f0(array/*. []void .*/ $x, array/*. [][]void .*/ $y): array/*. []void.*/ {return NULL; }

class MyClass {}

/*
 * Non-nullable types in function signature.
 */

function f1(void $_void, bool $_bool, int $_int, float $_float,
		string $_string, array $_array, callable $_callable,
		object $_object, MyClass $_users_class)
{
	if( $_void );
	if( $_bool );
	if( $_int );
	if( $_float );
	if( $_string );
	if( $_array );
	if( $_callable );
	if( $_object );
	if( $_users_class );
}

function f2(): void     {}                if( f2() );
function f3(): bool     {return FALSE;}   if( f3() );
function f4(): int      {return 0;}       if( f4() );
function f5(): float    {return 1.0;}     if( f5() );
function f6(): string   {return "";}      if( f6() );
function f7(): array    {return [];}      if( f7() );
function f8(): callable {return NULL;}    if( f8() );
function f9(): object   {return NULL;}    if( f9() );
function f10(): MyClass {return NULL;}    if( f10() );

/*
 * Nullable types in function signature.
 */

function f11(?void $_void, ?bool $_bool, ?int $_int, ?float $_float,
		?string $_string, ?array $_array, ?callable $_callable,
		?object $_object, ?MyClass $_users_class)
{
}

function f12(): ?void    {}                if( f12() );
function f13(): ?bool    {return FALSE;}   if( f13() );
function f14(): ?int     {return 0;}       if( f14() );
function f15(): ?float   {return 1.0;}     if( f15() );
function f16(): ?string  {return "";}      if( f16() );
function f17(): ?array   {return [];}      if( f17() );
function f18(): ?callable{return NULL;}    if( f18() );
function f19(): ?object  {return NULL;}    if( f19() );
function f20(): ?MyClass {return NULL;}    if( f20() );

// Nullable modifier applied to meta-code is forbidden:
function f21(?/*. int .*/ $x): ?/*. int .*/ { return 0; }

/**
 * Nullable types in DocBlock.
 * @param ? void $_void
 * @param ? bool $_bool
 * @param ? int $_int
 * @param ?float $_float
 * @param ? string $_string
 * @param ? array $_array
 * @param ? object $_object
 * @param ? MyClass $_users_class
 * @return ? object
 */
function f22($_void, $_bool, $_int, $_float,
		$_string, $_array,
		$_object, $_users_class)
{
	return NULL;
}

class MyClass2 {
	
	// Non-nullable types:
	public void $_void;
	public bool $_bool = FALSE;
	public int $_int = 0;
	public float $_float = 0.0;
	public string $_string;
	public array $_array;
	public callable $_callable;
	public object $_object;
	public self $_self;
	public parent $_parent;
	
	// Nullable types:
	public ?void $_nullable_void;
	public ?bool $_nullable_bool = FALSE;
	public ?int $_nullable_int = 0;
	public ?float $_nullable_float = 0.0;
	public ?string $_nullable_string;
	public ?array $_nullable_array;
	public ?callable $_nullable_callable;
	public ?object $_nullable_object;
	public ?self $_nullable_self;
	public ?parent $_nullable_parent;
	
	// Nullable applied to meta-code is forbidden:
	public ?/*. resource .*/ $r;
	function m1(?/*. int .*/ $x): ?/*. int .*/ { return 0; }
	
}


/**
 * Matching DocBlock + type-hint.
 * @param int $i
 * @param string $s
 * @return float
 */
function f50(int $i, string $s): float
{
	return 0.0;
}

/**
 * Mismatching DocBlock + type-hint.
 * @param float $i
 * @param int $s
 * @return string
 */
function f51(int $i, string $s): float
{
	return 0.0;
}

/**
 * Matching meta-code + type-hint.
 * Return type test only; in fact, using both meta-code and type-hint on
 * arguments results in a fatal parse error.
 */
/*. float .*/ function f52(): float
{
	return 0.0;
}

/**
 * Mismatching meta-code + type-hint.
 * Return type test only; in fact, using both meta-code and type-hint on
 * arguments results in a fatal parse error.
 */
/*. string .*/ function f53(): float
{
	return 0.0;
}


/**
 * Checking matching and mismatching DocBlock + type-hints in properties.
 * Here again, meta-code cannot be mixed with type-hints because it is a
 * fatal parse error.
 */
class MyClass50 {
	/**
	 * @var int
	 */
	public int $p1 = 0;
	
	/**
	 * @var string
	 */
	public int $p2 = 0;
}
