<?php

class A {
	function m1(string $i){}
	function m2(?string $i){}
	function m3(): string { return NULL; }
	function m4(): ?string { return NULL; }
}

class B1 extends A {
	function m1(string $i){}
	function m2(?string $i){}
	function m3(): string { return NULL; }
	function m4(): ?string { return NULL; }
}

class B2 extends A {
	function m1(?string $i){}
	function m2(string $i){} // ERR
	function m3(): ?string { return NULL; } // ERR
	function m4(): string { return NULL; }
}
