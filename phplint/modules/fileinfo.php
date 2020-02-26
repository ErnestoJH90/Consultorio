<?php
/**
File Information.

See: {@link http://www.php.net/manual/en/book.fileinfo.php}
@package fileinfo
*/

/*. require_module 'core'; .*/

const FILEINFO_CONTINUE = 32,
	FILEINFO_DEVICES = 8,
	FILEINFO_MIME = 1040,
	FILEINFO_MIME_ENCODING = 1024,
	FILEINFO_MIME_TYPE = 16,
	FILEINFO_NONE = 0,
	FILEINFO_PRESERVE_ATIME = 128,
	FILEINFO_RAW = 256,
	FILEINFO_SYMLINK = 2;

class finfo {
	/*. void .*/ function __construct($options = FILEINFO_NONE, /*. string .*/ $magic_file = NULL)
	/*. triggers E_WARNING .*/{}
	/*. string .*/ function buffer(/*. string .*/ $string_ = NULL, $options = FILEINFO_NONE, /*. resource .*/ $context = NULL)
	/*. triggers E_WARNING .*/{}
	/*. string .*/ function file(/*. string .*/ $file_name = NULL, $options = FILEINFO_NONE, /*. resource .*/ $context = NULL)/*. triggers E_WARNING .*/{}
	/*. bool .*/ function set_flags(/*. int .*/ $options)/*. triggers E_WARNING .*/{}
}

/*. string .*/ function finfo_buffer(/*. resource .*/ $finfo, /*. string .*/ $string_ = NULL, $options = FILEINFO_NONE, /*. resource .*/ $context = NULL)/*. triggers E_WARNING .*/{}
/*. bool .*/ function finfo_close (/*. resource .*/ $finfo)/*. triggers E_WARNING .*/{}
/*. string .*/ function finfo_file (/*. resource .*/ $finfo , /*. string .*/ $file_name = NULL, $options = FILEINFO_NONE, /*. resource .*/ $context = NULL)/*. triggers E_WARNING .*/{}
/*. resource .*/ function finfo_open($options = FILEINFO_NONE, /*. string .*/ $magic_file = NULL)/*. triggers E_WARNING .*/{}
/*. bool .*/ function finfo_set_flags(/*. resource .*/ $finfo, /*. int .*/ $options)/*. triggers E_WARNING .*/{}

/**
 * @deprecated The PECL extension Fileinfo provides the same functionality
 * (and more) in a much cleaner way.
 */
/*. string.*/ function mime_content_type(/*. string .*/ $filename)
/*. triggers E_WARNING .*/{}
