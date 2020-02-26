<?php
/** Mhash Functions.

See: {@link http://www.php.net/manual/en/ref.mhash.php}
@package mhash
*/

const MHASH_ADLER32 = 4,
	MHASH_CRC32 = 4,
	MHASH_CRC32B = 4,
	MHASH_GOST = 32,
	MHASH_HAVAL128 = 16,
	MHASH_HAVAL160 = 20,
	MHASH_HAVAL192 = 24,
	MHASH_HAVAL224 = 28,
	MHASH_HAVAL256 = 32,
	MHASH_MD4 = 16,
	MHASH_MD5 = 16,
	MHASH_RIPEMD160 = 20,
	MHASH_SHA1 = 20,
	MHASH_SHA256 = 32,
	MHASH_TIGER = 24,
	MHASH_TIGER128 = 16,
	MHASH_TIGER160 = 20;


/*. int   .*/ function mhash_count(){}
/*. int   .*/ function mhash_get_block_size(/*. int .*/ $hash){}
/*. string.*/ function mhash_get_hash_name(/*. int .*/ $hash){}
/*. string.*/ function mhash(/*. int .*/ $hash, /*. string .*/ $data /*., args .*/){}
/*. string.*/ function mhash_keygen_s2k(/*. int .*/ $hash, /*. string .*/ $input_password, /*. string .*/ $salt, /*. int .*/ $bytes){}
