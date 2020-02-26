<?php

namespace com\tecnick\barcode;

require_once __DIR__ . "/../../../../../stdlib/all.php";
require_once __DIR__ . "/../../../../../stdlib/bcmath-for-int-replacement.php";

use it\icosaedro\utils\Strings;


/**
 * @param string $got
 * @param string $exp
 * @throws \RuntimeException
 */
function test($got, $exp)
{
	if( $got !== $exp )
		throw new \RuntimeException("test failed:\n"
			."got=".Strings::toLiteral($got)."\n"
			."exp=".Strings::toLiteral($exp)."\n"
			."got string base64 compressed=".  base64_encode(gzcompress($got))
			."\n");
}


const ZBARIMG = "/home/downloads/software/zbar-0.10/zbarimg/zbarimg";

/**
 * Reads the generate image of the barcode using the external program
 * ZBARIMG () and compare the result.
 * @param string $algo ZBARIMG name given to the algo.
 * @param Barcode $b Barcode generated.
 * @throws \RuntimeException
 * @throws \ErrorException
 */
function test2($algo, $b)
{
	static $skip = FALSE;
	if( $skip )
		return;
	if( !file_exists(ZBARIMG) ){
		echo "WARNING: missing program file " . ZBARIMG . ". Skipping ZBARIMG test.\n";
		$skip = TRUE;
		return;
	}
	
	$a = explode("\\", get_class($b));
	$classname = $a[count($a)-1];
	
	$img = __DIR__ . "/example-$classname.png";
	file_put_contents($img, $b->getPNG());
	$zbar = popen(ZBARIMG . " -q $img 2>&1", "r");
	$out = trim( fread($zbar, 100) );
	pclose($zbar);
	test($out, $algo . ":" . $b->getReadout());
	unlink($img);
}


/*. Barcode .*/ $b = NULL;

$b = new CODABAR("A31117013206375B");
test("$b", "[code=A31117013206375B,w=162,h=1,bars=[S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,1,1,0]]");
//file_put_contents(__DIR__ . "/example-CODABAR-A31117013206375B.png", $b->getPNG(1, 27));

$b = new CODE11("123-453");
test("$b", gzuncompress(base64_decode("eJyLTs5PSbU1NDLWNTE11im3NTfXybA11ElKLCq2jQ7WMQRCg9hoJxgjWMcIJmIEE8GjxpAsNSSZTIx7iBEhxs0kuYckEfLCmXY+xWV7LAAluIQR")));
//file_put_contents(__DIR__."/example-CODE11-123-453.png", $b->getPNG(1, 30));

$b = new CODE11("123-456-789");
test("$b", gzuncompress(base64_decode("eJyLTs5PSbU1NDLWNTE10zW3sNQptzU0NNXJsDXUSUosKraNDtYxBEKD2GgnGCNYxwgmYgQTwaPGkCw1JJlMjHuIESHGzSS5hyQRPHYZUduFJIUPHtupFYPUCmeq+51gGosFAO97w/k=")));
//file_put_contents(__DIR__."/example-CODE11.png", $b->getPNG(1, 40));

$b = new CODE128("01239abz", "");
test("$b", "[code=01239abz,w=112,h=1,bars=[S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,2,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,3,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,4,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,4,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,4,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,4,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,2,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,0,1,0][S,0,1,0][B,0,1,0][S,0,1,0][B,0,1,0]]");
test2("CODE-128", $b);

$b = new CODE128("01239ABZ", "A");
test("$b", "[code=01239ABZ,w=123,h=1,bars=[S,2,1,0][B,1,1,0][S,1,1,0][B,4,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,3,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,2,1,0][B,3,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,2,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,4,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,0,1,0][S,0,1,0][B,0,1,0][S,0,1,0][B,0,1,0]]");
test2("CODE-128", $b);

$b = new CODE128("012389", "C");
test("$b", "[code=012389,w=68,h=1,bars=[S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,2,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,3,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,4,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,3,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,0,1,0][S,0,1,0][B,0,1,0][S,0,1,0][B,0,1,0]]");
test2("CODE-128", $b);

$b = new CODE128("01239ABCabz");
test("$b", "[code=01239ABCabz,w=145,h=1,bars=[S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,2,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,3,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,4,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,2,1,0][B,3,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,3,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,3,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,4,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,4,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,4,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,4,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,0,1,0][S,0,1,0][B,0,1,0][S,0,1,0][B,0,1,0]]");
test2("CODE-128", $b);

$b = new CODE39("01239ABZ", false, false);
test("$b", "[code=01239ABZ,w=160,h=1,bars=[S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0]]");
test2("CODE-39", $b);

$b = new CODE39("01239ABZ", false, true);
test("$b", "[code=01239ABZ,w=176,h=1,bars=[S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0]]");
test2("CODE-39", $b);

$b = new CODE39("01239abz", true, false);
test("$b", "[code=01239abz,w=208,h=1,bars=[S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0]]");
test2("CODE-39", $b);

$b = new CODE39("01239abz", true, true);
test("$b", "[code=01239abz,w=224,h=1,bars=[S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0]]");
test2("CODE-39", $b);

$b = new CODE93("Hello guys!");
test("$b", gzuncompress(base64_decode("eJyLTs5PSbX1SM3JyVdIL60sVtQptzUyNNfJsDXUSUosKraNDtYxBEKD2GgnGAObiAkRaoxgIkYYavCI4NFFnsmYLiTJLmJE4OYYD0G7SApnY7LMoVZoGOFWQ2FokKSGWv7C1EV1u/CYQ14s4zGZGLuIiS88agxJcSFJKZNgyRYLAAT/O1s=")));
//file_put_contents(__DIR__."/CODE93.png", $b->getPNG());

// Without check
$b = new EAN("8052517");
test("$b", gzuncompress(base64_decode("eJyLTs5PSbW1MDA1MjU0N9IptzUz18mwNdRJSiwqto0O1jEEQoPYaCcYA5uIEYaIMUzEGLcaPOYYY6gxwi1CjMl4RIww3IzpHmLswuNmTF2YJuNyYSwAtTdizQ==")));
test2("EAN-8", $b);
//file_put_contents(__DIR__."/example-EAN-8.png", $b->getPNG(1, 40));

// With check
$b = new EAN("80525172");
test("$b", gzuncompress(base64_decode("eJyLTs5PSbW1MDA1MjU0N9IptzUz18mwNdRJSiwqto0O1jEEQoPYaCcYA5uIEYaIMUzEGLcaPOYYY6gxwi1CjMl4RIww3IzpHmLswuNmTF2YJuNyYSwAtTdizQ==")));
test2("EAN-8", $b);

// Without check (ISBN)
$b = new EAN("978013147149");
test("$b", "[code=9780131471498,w=95,h=1,bars=[S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,2,1,0][B,3,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,4,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,2,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,2,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0]]");
test2("EAN-13", $b);
//file_put_contents(__DIR__."/example-EAN13.png", $b->getPNG(1, 50));

// With check:
$b = new EAN("9780131471498");
test("$b", "[code=9780131471498,w=95,h=1,bars=[S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,2,1,0][B,3,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,4,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,2,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,2,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,3,1,0][S,1,1,0][B,1,1,0][S,1,1,0]]");
test2("EAN-13", $b);
//file_put_contents(__DIR__."/example-EAN13.png", $b->getPNG(1, 50));

$b = new EANEXT("09");
test("$b", "[code=09,w=20,h=1,bars=[S,1,1,0][B,1,1,0][S,2,1,0][B,3,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,3,1,0]]");
//file_put_contents(__DIR__."/example-EANEXT-2.png", $b->getPNG());

$b = new EANEXT("01239");
test("$b", "[code=01239,w=47,h=1,bars=[S,1,1,0][B,1,1,0][S,2,1,0][B,3,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,4,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,3,1,0]]");
//file_put_contents(__DIR__."/example-EANEXT-5.png", $b->getPNG());

$b = new IMB("11222333333444444444-55555");
test("$b", "[code=11222333333444444444-55555,w=129,h=3,bars=[S,1,3,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,1]]");
//file_put_contents(__DIR__ . "/example-IMB.png", $b->getPNG());

$b = new IMB("55666777777888888888");
test("$b", "[code=55666777777888888888,w=129,h=3,bars=[S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1]]");
//file_put_contents(__DIR__ . "/example-IMB-no-zip.png", $b->getPNG());

$b = new INTERLEAVED25("1234", false);
test("$b", "[code=1234,w=37,h=1,bars=[S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0]]");
//test2("I2/5", $b); // zbarimg pretends the checksum - cannot check this

$b = new INTERLEAVED25("1234", true);
//test("$b", "[code=012342,w=51,h=1,bars=[S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,2,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0]]");
test2("I2/5", $b);

$b = new MSI("01239", false);
test("$b", "[code=01239,w=67,h=1,bars=[S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0]]");
//file_put_contents(__DIR__."/example-MSI.png", $b->getPNG());

$b = new MSI("01239", true);
test("$b", "[code=012394,w=79,h=1,bars=[S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0]]");
//file_put_contents(__DIR__."/example-MSI.png", $b->getPNG(1,40));

$b = new PHARMACODE("01239");
test("$b", "[code=01239,w=36,h=1,bars=[S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,3,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0][B,2,1,0][S,1,1,0]]");
//file_put_contents(__DIR__."/example-PHARMACODE.png", $b->getPNG(1,40));

$b = new PHARMACODE2T("01239");
test("$b", "[code=01239,w=13,h=2,bars=[S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0]]");
//file_put_contents(__DIR__."/example-PHARMACODE2T.png", $b->getPNG(2,40));

$b = new POSTNET("12345-6789", false);
test("$b", "[code=12345-6789,w=103,h=2,bars=[S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0]]");
//file_put_contents(__DIR__."/example-POSTNET.png", $b->getPNG());

$b = new POSTNET("12345-6789", true);
test("$b", "[code=12345-6789,w=103,h=2,bars=[S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,0]]");
//file_put_contents(__DIR__."/example-POSTNET-PLANET.png", $b->getPNG());

$b = new RMS4CC("01239ABZ", false);
test("$b", "[code=01239ABZ,w=75,h=3,bars=[S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,3,0]]");

$b = new RMS4CC("01239ABC", true);
test("$b", "[code=01239ABC,w=64,h=3,bars=[S,1,1,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,2,1][B,1,2,0][S,1,3,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,1,1][B,1,2,0][S,1,2,0][B,1,2,0][S,1,3,0][B,1,2,0][S,1,2,1][B,1,2,0]]");

$b = new STANDARD25("01239", false);
test("$b", "[code=001239,w=99,h=1,bars=[S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0]]");

$b = new STANDARD25("01239", true);
test("$b", "[code=012393,w=99,h=1,bars=[S,2,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,3,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0][B,1,1,0][S,1,1,0][B,1,1,0][S,2,1,0]]");

$b = new UPC("042100005264");
//file_put_contents(__DIR__."/example-UPC-A.png", $b->getPNG(1, 60));
test("$b", gzuncompress(base64_decode("eJyLTs5PSbU1MDEyNAACUyMzE51yW0tTnQxbQ52kxKJi2+hgHUMgNIiNdoIxkESMYSJGuNUQo8sIQ40RbjV4dBHjHvLcjEfEGLd7SFKD6XdjDDWYbsYTGpgmm1DDhbEAYQCFHA==")));
//test2("UPC-A", $b);

$b = new UPC("04210000526");
//file_put_contents(__DIR__."/example-UPC-A-042100005264.png", $b->getPNG(1, 60));
test("$b", gzuncompress(base64_decode("eJyLTs5PSbU1MDEyNAACUyMzE51yW0tTnQxbQ52kxKJi2+hgHUMgNIiNdoIxkESMYSJGuNUQo8sIQ40RbjV4dBHjHvLcjEfEGLd7SFKD6XdjDDWYbsYTGpgmm1DDhbEAYQCFHA==")));

$b = new UPC("04210000526", true);
//file_put_contents(__DIR__."/example-UPC-E-042100005264.png", $b->getPNG(1, 60));
test("$b", gzuncompress(base64_decode("eJyLTs5PSbU1MDEyNAACUyMzE51yW1NDnQxbQ52kxKJi2+hgHUMgNIiNdoIxkESMYCLGRKjBFDHC0GVMli5MEUw3m+A2B9MuPObgEokFAJOVToU=")));
//test2("UPC-E", $b);