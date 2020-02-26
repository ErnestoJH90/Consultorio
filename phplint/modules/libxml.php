<?php
/** libxml Functions.

See: {@link http://www.php.net/manual/en/ref.libxml.php}
@package libxml
*/

/*. if_php_ver_7 .*/
const LIBXML_BIGLINES = 4194304;
/*. end_if_php_ver .*/

const LIBXML_COMPACT = 65536,
	LIBXML_DOTTED_VERSION = '2.9.1',
	LIBXML_DTDATTR = 8,
	LIBXML_DTDLOAD = 4,
	LIBXML_DTDVALID = 16,
	LIBXML_ERR_ERROR = 2,
	LIBXML_ERR_FATAL = 3,
	LIBXML_ERR_NONE = 0,
	LIBXML_ERR_WARNING = 1,
	LIBXML_HTML_NODEFDTD = 4,
	LIBXML_HTML_NOIMPLIED = 8192,
	LIBXML_LOADED_VERSION = '20901',
	LIBXML_NOBLANKS = 256,
	LIBXML_NOCDATA = 16384,
	LIBXML_NOEMPTYTAG = 4,
	LIBXML_NOENT = 2,
	LIBXML_NOERROR = 32,
	LIBXML_NONET = 2048,
	LIBXML_NOWARNING = 64,
	LIBXML_NOXMLDECL = 2,
	LIBXML_NSCLEAN = 8192,
	LIBXML_PARSEHUGE = 524288,
	LIBXML_PEDANTIC = 128,
	LIBXML_SCHEMA_CREATE = 1,
	LIBXML_VERSION = 20901,
	LIBXML_XINCLUDE = 1024;

class LibXMLError
{
	public /*. int .*/ $code = 0;  # dummy initial value
	public /*. int .*/ $column = 0;  # dummy initial value
	public /*. string .*/ $file;
	public /*. int .*/ $level = 0;  # dummy initial value
	public /*. int .*/ $line = 0;  # dummy initial value
	public /*. string .*/ $message;
}

/*. void .*/ function libxml_set_streams_context(/*. resource .*/ $streams_context){}
/*. boolean .*/ function libxml_use_internal_errors($use_errors = FALSE){}
/*. LibXMLError .*/ function libxml_get_last_error(){}
/*. LibXMLError[int] .*/ function libxml_get_errors(){}
/*. void .*/ function libxml_clear_errors(){}
/*. boolean .*/ function libxml_disable_entity_loader($disable = TRUE){}
