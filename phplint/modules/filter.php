<?php
/** Filter Functions.

	See: {@link http://www.php.net/manual/en/ref.filter.php}

	@deprecated Very poorly written interface with too many 'mixed' values,
	difficult to validate automatically, leaving to the programmer all the
	responsability to handle properly arguments and returned values. The
	returned values are also 'mixed' with a complex semantic based on the
	special values NULL, FALSE/TRUE, etc. It is questionable if this library
	really adds security. [Umberto Salsi]
	@package filter
*/

# These values are all dummy:
const INPUT_POST = 1,
	INPUT_GET = 2,
	INPUT_COOKIE = 3,
	INPUT_ENV = 4,
	INPUT_SERVER = 5,
	INPUT_SESSION = 6,
	INPUT_REQUEST = 7,

	FILTER_CALLBACK = 1024,
	FILTER_DEFAULT = 516,
	FILTER_FLAG_ALLOW_FRACTION = 4096,
	FILTER_FLAG_ALLOW_HEX = 2,
	FILTER_FLAG_ALLOW_OCTAL = 1,
	FILTER_FLAG_ALLOW_SCIENTIFIC = 16384,
	FILTER_FLAG_ALLOW_THOUSAND = 8192,
	FILTER_FLAG_EMPTY_STRING_NULL = 256,
	FILTER_FLAG_ENCODE_AMP = 64,
	FILTER_FLAG_ENCODE_HIGH = 32,
	FILTER_FLAG_ENCODE_LOW = 16,
	FILTER_FLAG_HOSTNAME = 1048576,
	FILTER_FLAG_HOST_REQUIRED = 131072,
	FILTER_FLAG_IPV4 = 1048576,
	FILTER_FLAG_IPV6 = 2097152,
	FILTER_FLAG_NONE = 0,
	FILTER_FLAG_NO_ENCODE_QUOTES = 128,
	FILTER_FLAG_NO_PRIV_RANGE = 8388608,
	FILTER_FLAG_NO_RES_RANGE = 4194304,
	FILTER_FLAG_PATH_REQUIRED = 262144,
	FILTER_FLAG_QUERY_REQUIRED = 524288,
	FILTER_FLAG_SCHEME_REQUIRED = 65536,
	FILTER_FLAG_STRIP_BACKTICK = 512,
	FILTER_FLAG_STRIP_HIGH = 8,
	FILTER_FLAG_STRIP_LOW = 4,
	FILTER_FORCE_ARRAY = 67108864,
	FILTER_NULL_ON_FAILURE = 134217728,
	FILTER_REQUIRE_ARRAY = 16777216,
	FILTER_REQUIRE_SCALAR = 33554432,
	FILTER_SANITIZE_EMAIL = 517,
	FILTER_SANITIZE_ENCODED = 514,
	FILTER_SANITIZE_FULL_SPECIAL_CHARS = 522,
	FILTER_SANITIZE_MAGIC_QUOTES = 521,
	FILTER_SANITIZE_NUMBER_FLOAT = 520,
	FILTER_SANITIZE_NUMBER_INT = 519,
	FILTER_SANITIZE_SPECIAL_CHARS = 515,
	FILTER_SANITIZE_STRING = 513,
	FILTER_SANITIZE_STRIPPED = 513,
	FILTER_SANITIZE_URL = 518,
	FILTER_UNSAFE_RAW = 516,
	FILTER_VALIDATE_BOOLEAN = 258,
	FILTER_VALIDATE_DOMAIN = 277,
	FILTER_VALIDATE_EMAIL = 274,
	FILTER_VALIDATE_FLOAT = 259,
	FILTER_VALIDATE_INT = 257,
	FILTER_VALIDATE_IP = 275,
	FILTER_VALIDATE_MAC = 276,
	FILTER_VALIDATE_REGEXP = 272,
	FILTER_VALIDATE_URL = 273;

/*. bool .*/ function filter_has_var(/*. int .*/ $type, /*. string .*/ $variable_name){}
/*. int .*/ function filter_id(/*. string .*/ $filtername){}
/*. mixed .*/ function filter_input_array(/*. int .*/ $type /*. , args .*/){}
/*. mixed .*/ function filter_input(/*. int .*/ $type, /*. string .*/ $variable_name /*. , args .*/){}
/*. array[int]string .*/ function filter_list(){}
/*. mixed .*/ function filter_var_array(/*. array[string]mixed .*/ $data /*. , args .*/){}
/*. mixed .*/ function filter_var(/*. mixed .*/ $variable /*. , args .*/){}
