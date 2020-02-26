<?php

/*
 * Cryptografic functions.
 */


const CRYPT_BLOWFISH = 1,
	CRYPT_EXT_DES = 1,
	CRYPT_MD5 = 1,
	CRYPT_SALT_LENGTH = 123,
	CRYPT_SHA256 = 1,
	CRYPT_SHA512 = 1,
	CRYPT_STD_DES = 1;


/*. string.*/ function crypt(/*. string .*/ $str, $salt = ""){}
