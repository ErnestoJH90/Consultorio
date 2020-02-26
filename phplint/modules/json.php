<?php
/** JSON Functions.

This extension implements the JavaScript Object Notation (JSON)
data-interchange format. The decoding is handled by a parser based on the
JSON_checker by Douglas Crockford.
<p>

See: {@link http://www.php.net/manual/en/ref.json.php}
@package json
*/

/*. require_module 'core'; .*/

const JSON_BIGINT_AS_STRING = 2,
	JSON_ERROR_CTRL_CHAR = 3,
	JSON_ERROR_DEPTH = 1,
	JSON_ERROR_INF_OR_NAN = 7,
	JSON_ERROR_INVALID_PROPERTY_NAME = 9,
	JSON_ERROR_NONE = 0,
	JSON_ERROR_RECURSION = 6,
	JSON_ERROR_STATE_MISMATCH = 2,
	JSON_ERROR_SYNTAX = 4,
	JSON_ERROR_UNSUPPORTED_TYPE = 8,
	JSON_ERROR_UTF16 = 10,
	JSON_ERROR_UTF8 = 5,
	JSON_FORCE_OBJECT = 16,
	JSON_HEX_AMP = 2,
	JSON_HEX_APOS = 4,
	JSON_HEX_QUOT = 8,
	JSON_HEX_TAG = 1,
	JSON_NUMERIC_CHECK = 32,
	JSON_OBJECT_AS_ARRAY = 1,
	JSON_PARTIAL_OUTPUT_ON_ERROR = 512,
	JSON_PRESERVE_ZERO_FRACTION = 1024,
	JSON_PRETTY_PRINT = 128,
	JSON_UNESCAPED_SLASHES = 64,
	JSON_UNESCAPED_UNICODE = 256,
	JSON_UNESCAPED_LINE_TERMINATORS = 2048,
	JSON_THROW_ON_ERROR = 1;

class JsonException extends Exception {}

interface JsonSerializable {
	public /*. mixed .*/ function jsonSerialize();
}

/*. mixed .*/ function json_decode(/*. string .*/ $json, $assoc = false, $depth = 512, $options = 0)/*. throws JsonException .*/{}
/*. string .*/ function json_encode(/*. mixed .*/ $value, $options = 0, $depth = 512)/*. throws JsonException .*/{}
/*. int .*/ function json_last_error(){}
/*. string .*/ function json_last_error_msg(){}
