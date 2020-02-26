<?php
/** XML Parser Functions.

See: {@link http://www.php.net/manual/en/ref.xml.php}
@package xml
*/


const XML_ERROR_ASYNC_ENTITY = 13,
	XML_ERROR_ATTRIBUTE_EXTERNAL_ENTITY_REF = 16,
	XML_ERROR_BAD_CHAR_REF = 14,
	XML_ERROR_BINARY_ENTITY_REF = 15,
	XML_ERROR_DUPLICATE_ATTRIBUTE = 8,
	XML_ERROR_EXTERNAL_ENTITY_HANDLING = 21,
	XML_ERROR_INCORRECT_ENCODING = 19,
	XML_ERROR_INVALID_TOKEN = 4,
	XML_ERROR_JUNK_AFTER_DOC_ELEMENT = 9,
	XML_ERROR_MISPLACED_XML_PI = 17,
	XML_ERROR_NONE = 0,
	XML_ERROR_NO_ELEMENTS = 3,
	XML_ERROR_NO_MEMORY = 1,
	XML_ERROR_PARAM_ENTITY_REF = 10,
	XML_ERROR_PARTIAL_CHAR = 6,
	XML_ERROR_RECURSIVE_ENTITY_REF = 12,
	XML_ERROR_SYNTAX = 2,
	XML_ERROR_TAG_MISMATCH = 7,
	XML_ERROR_UNCLOSED_CDATA_SECTION = 20,
	XML_ERROR_UNCLOSED_TOKEN = 5,
	XML_ERROR_UNDEFINED_ENTITY = 11,
	XML_ERROR_UNKNOWN_ENCODING = 18,
	XML_OPTION_CASE_FOLDING = 1,
	XML_OPTION_SKIP_TAGSTART = 3,
	XML_OPTION_SKIP_WHITE = 4,
	XML_OPTION_TARGET_ENCODING = 2,
	XML_SAX_IMPL = "libxml";


/*. resource .*/ function xml_parser_create( /*. args .*/){}
/*. resource .*/ function xml_parser_create_ns( /*. args .*/){}
/*. bool .*/ function xml_set_object(/*. resource .*/ $parser, /*. object .*/ &$obj){}
/*. bool .*/ function xml_set_element_handler(/*. resource .*/ $parser, /*. mixed .*/ $shdl, /*. mixed .*/ $ehdl){}
/*. bool .*/ function xml_set_character_data_handler(/*. resource .*/ $parser, /*. mixed .*/ $hdl){}
/*. bool .*/ function xml_set_processing_instruction_handler(/*. resource .*/ $parser, /*. mixed .*/ $hdl){}
/*. bool .*/ function xml_set_default_handler(/*. resource .*/ $parser, /*. mixed .*/ $hdl){}
/*. bool .*/ function xml_set_unparsed_entity_decl_handler(/*. resource .*/ $parser, /*. mixed .*/ $hdl){}
/*. bool .*/ function xml_set_notation_decl_handler(/*. resource .*/ $parser, /*. mixed .*/ $hdl){}
/*. bool .*/ function xml_set_external_entity_ref_handler(/*. resource .*/ $parser, /*. mixed .*/ $hdl){}
/*. bool .*/ function xml_set_start_namespace_decl_handler(/*. resource .*/ $parser, /*. mixed .*/ $hdl){}
/*. bool .*/ function xml_set_end_namespace_decl_handler(/*. resource .*/ $parser, /*. mixed .*/ $hdl){}
/*. int .*/ function xml_parse(/*. resource .*/ $parser, /*. string .*/ $data, $is_final = FALSE){}
/*. int .*/ function xml_parse_into_struct(/*. resource .*/ $parser, /*. string .*/ $data, /*. return array .*/ &$values, /*. return array .*/ &$index){}
/*. int .*/ function xml_get_error_code(/*. resource .*/ $parser){}
/*. string .*/ function xml_error_string(/*. int .*/ $code){}
/*. int .*/ function xml_get_current_line_number(/*. resource .*/ $parser){}
/*. int .*/ function xml_get_current_column_number(/*. resource .*/ $parser){}
/*. int .*/ function xml_get_current_byte_index(/*. resource .*/ $parser){}
/*. bool .*/ function xml_parser_free(/*. resource .*/ $parser){}
/*. bool .*/ function xml_parser_set_option(/*. resource .*/ $parser, /*. int .*/ $option, /*. mixed .*/ $value){}
/*. mixed .*/ function xml_parser_get_option(/*. resource .*/ $parser, /*. int .*/ $option){}

/* These functions moved to core since PHP 7.2.0: */
/*. if_php_ver_5 .*/
/*. string.*/ function utf8_encode(/*. string .*/ $data){}
/*. string.*/ function utf8_decode(/*. string .*/ $data){}
/*. end_if_php_ver .*/
