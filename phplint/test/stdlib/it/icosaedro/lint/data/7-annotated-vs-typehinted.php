<?php

class A {
	/**
	 * @param int $x
	 * @return int
	 */
	function annotatedMethod($x){ return 1; }
	
	function typeHintedMethod(int $x): int { return 1; }
}

class B1 extends A {
	/**
	 * @param int $x
	 * @return int
	 */
	function annotatedMethod($x){ return 1; }
	
	function typeHintedMethod(int $x): int { return 1; }
}

class B2 extends A {
	/*. int .*/ function annotatedMethod(int $x){ return 1; } // ERR
}

class B3 extends A {
	function annotatedMethod(/*. int .*/ $x): int { return 1; }
}

class B4 extends A {
	function typeHintedMethod(/*. int .*/ $x): int { return 1; } // OK
}

class B5 extends A {
	/*. int .*/ function typeHintedMethod(int $x){ return 1; } // ERR
}
