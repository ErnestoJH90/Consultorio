<?php
/** Mcrypt Encryption Functions.

See: {@link http://www.php.net/manual/en/ref.mcrypt.php}
@package mcrypt
*/


const MCRYPT_ENCRYPT = 1,
	MCRYPT_DECRYPT = 1,
	MCRYPT_DEV_RANDOM = 1,
	MCRYPT_DEV_URANDOM = 1,
	MCRYPT_RAND = 1,
	MCRYPT_3DES = "tripledes",
	MCRYPT_ARCFOUR_IV = "arcfour-iv",
	MCRYPT_ARCFOUR = "arcfour",
	MCRYPT_BLOWFISH = "blowfish",
	MCRYPT_BLOWFISH_COMPAT = "blowfish-compat",
	MCRYPT_CAST_128 = "cast-128",
	MCRYPT_CAST_256 = "cast-256",
	MCRYPT_CRYPT = "crypt",
	MCRYPT_DES = "des",
	MCRYPT_ENIGNA = "crypt",
	MCRYPT_GOST = "gost",
	MCRYPT_LOKI97 = "loki97",
	MCRYPT_PANAMA = "panama",
	MCRYPT_RC2 = "rc2",
	MCRYPT_RIJNDAEL_128 = "rijndael-128",
	MCRYPT_RIJNDAEL_192 = "rijndael-192",
	MCRYPT_RIJNDAEL_256 = "rijndael-256",
	MCRYPT_SAFER64 = "safer-sk64",
	MCRYPT_SAFER128 = "safer-sk128",
	MCRYPT_SAFERPLUS = "saferplus",
	MCRYPT_SERPENT = "serpent",
	MCRYPT_THREEWAY = "threeway",
	MCRYPT_TRIPLEDES = "tripledes",
	MCRYPT_TWOFISH = "twofish",
	MCRYPT_WAKE = "wake",
	MCRYPT_XTEA = "xtea",
	MCRYPT_IDEA = "idea",
	MCRYPT_MARS = "mars",
	MCRYPT_RC6 = "rc6",
	MCRYPT_SKIPJACK = "skipjack",
	MCRYPT_MODE_CBC = "cbc",
	MCRYPT_MODE_CFB = "cfb",
	MCRYPT_MODE_ECB = "ecb",
	MCRYPT_MODE_NOFB = "nofb",
	MCRYPT_MODE_OFB = "ofb",
	MCRYPT_MODE_STREAM = "stream";



/*. resource .*/ function mcrypt_module_open(/*. string .*/ $cipher, /*. string .*/ $cipher_directory, /*. string .*/ $mode, /*. string .*/ $mode_directory){}
/*. int .*/ function mcrypt_generic_init(/*. resource .*/ $td, /*. string .*/ $key, /*. string .*/ $iv){}
/*. string .*/ function mcrypt_generic(/*. resource .*/ $td, /*. string .*/ $data){}
/*. string .*/ function mdecrypt_generic(/*. resource .*/ $td, /*. string .*/ $data){}
/*. array .*/ function mcrypt_enc_get_supported_key_sizes(/*. resource .*/ $td){}
/*. int .*/ function mcrypt_enc_self_test(/*. resource .*/ $td){}
/*. bool .*/ function mcrypt_module_close(/*. resource .*/ $td){}

/*. if_php_ver_5 .*/
	/**
	 * @deprecated
	 * It may crash when used with {@link mcrypt_module_close()}.
	 * Use {@link mcrypt_generic_deinit()} instead.
	 */
	/*. bool .*/ function mcrypt_generic_end(/*. resource .*/ $td){}

	/** @deprecated Use {@link mcrypt_generic()} instead. */
	/*. string .*/ function mcrypt_ecb(/*. int .*/ $cipher, /*. string .*/ $key, /*. string .*/ $data, /*. int .*/ $mode, /*. string .*/ $iv){}
	/*. string .*/ function mcrypt_cbc(/*. int .*/ $cipher, /*. string .*/ $key, /*. string .*/ $data, /*. int .*/ $mode, /*. string .*/ $iv){}
	/*. string .*/ function mcrypt_cfb(/*. int .*/ $cipher, /*. string .*/ $key, /*. string .*/ $data, /*. int .*/ $mode, /*. string .*/ $iv){}
	/*. string .*/ function mcrypt_ofb(/*. int .*/ $cipher, /*. string .*/ $key, /*. string .*/ $data, /*. int .*/ $mode, /*. string .*/ $iv){}

/*. end_if_php_ver .*/

/*. bool .*/ function mcrypt_generic_deinit(/*. resource .*/ $td){}
/*. bool .*/ function mcrypt_enc_is_block_algorithm_mode(/*. resource .*/ $td){}
/*. bool .*/ function mcrypt_enc_is_block_algorithm(/*. resource .*/ $td){}
/*. bool .*/ function mcrypt_enc_is_block_mode(/*. resource .*/ $td){}
/*. int .*/ function mcrypt_enc_get_block_size(/*. resource .*/ $td){}
/*. int .*/ function mcrypt_enc_get_key_size(/*. resource .*/ $td){}
/*. int .*/ function mcrypt_enc_get_iv_size(/*. resource .*/ $td){}
/*. string .*/ function mcrypt_enc_get_algorithms_name(/*. resource .*/ $td){}
/*. string .*/ function mcrypt_enc_get_modes_name(/*. resource .*/ $td){}
/*. bool .*/ function mcrypt_module_self_test(/*. string .*/ $algorithm /*., args .*/){}
/*. bool .*/ function mcrypt_module_is_block_algorithm_mode(/*. string .*/ $mode /*., args .*/){}
/*. bool .*/ function mcrypt_module_is_block_algorithm(/*. string .*/ $algorithm /*., args .*/){}
/*. bool .*/ function mcrypt_module_is_block_mode(/*. string .*/ $mode /*., args .*/){}
/*. int .*/ function mcrypt_module_get_algo_block_size(/*. string .*/ $algorithm /*., args .*/){}
/*. int .*/ function mcrypt_module_get_algo_key_size(/*. string .*/ $algorithm /*., args .*/){}
/*. array .*/ function mcrypt_module_get_supported_key_sizes(/*. string .*/ $algorithm /*., args .*/){}
/*. array .*/ function mcrypt_list_algorithms( /*. args .*/){}
/*. array .*/ function mcrypt_list_modes( /*. args .*/){}
/*. int .*/ function mcrypt_get_key_size(/*. string .*/ $cipher, /*. string .*/ $module){}
/*. int .*/ function mcrypt_get_block_size(/*. string .*/ $cipher, /*. string .*/ $module){}
/*. int .*/ function mcrypt_get_iv_size(/*. string .*/ $cipher, /*. string .*/ $module){}
/*. string .*/ function mcrypt_get_cipher_name(/*. string .*/ $cipher){}
/*. string .*/ function mcrypt_encrypt(/*. string .*/ $cipher, /*. string .*/ $key, /*. string .*/ $data, /*. string .*/ $mode, /*. string .*/ $iv){}
/*. string .*/ function mcrypt_decrypt(/*. string .*/ $cipher, /*. string .*/ $key, /*. string .*/ $data, /*. string .*/ $mode, /*. string .*/ $iv){}
/*. string .*/ function mcrypt_create_iv(/*. int .*/ $size, /*. int .*/ $source){}
