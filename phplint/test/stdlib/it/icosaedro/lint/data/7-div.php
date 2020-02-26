<?php
if( 6/2 ); // int(3)

if( 5/2 ); // float(2.5)

const C_int = 6/2;
if( C_int ); // int

const C_float = 5/2;
if( C_float ); // float

$i = 6;
if( $i / 2 ); // mixed
if( 2 / $i ); // mixed

$x = 3.14;
if( $x / 2 ); // float
if( 2 / $x ); // float
if( $x / $x ); // float

echo 5/0; // error
echo 5/0.0; // error

if( (int) ($i / $i) ); // int
if( (float) ($i / $i) ); // float
if( (int) ($i / $x) ); // int
if( $i / $x ); // float

// check evaluation:
if( 6/2 == 3 ) // true
	$defined1 = 0;
echo $defined1;
if( 6/(-2) == -3 ) // true
	$defined2 = 0;
echo $defined2;
if( 5/2 == 2.5 ) // true
	$defined3 = 0;
echo $defined3;
if( 5/(-2) == -2.5 ) // true
	$defined4 = 0;
echo $defined4;


function f(/*. float .*/ $f)
{ echo $f; }

f(2); // error
f(3.14); // ok
f((float) 2); // ok

$i = 1;
if( $i /= 1 );
if( $i /= 1.0 );
$f = 1.0;
if( $f /= 1 );
if( $f /= 1.0 );
