<?php
/**
Forms Data Format Functions.

This module now available from PECL.
See: {@link http://www.php.net/manual/en/ref.fdf.php}
@package fdf
*/

# These values are all dummy:
const FDFValue = 1,
	FDFStatus = 2,
	FDFFile = 3,
	FDFID = 4,
	FDFFf = 5,
	FDFSetFf = 6,
	FDFClearFf = 7,
	FDFFlags = 8,
	FDFSetF = 9,
	FDFClrF = 10,
	FDFAP = 11,
	FDFAS = 12,
	FDFAction = 13,
	FDFAA = 14,
	FDFAPRef = 15,
	FDFIF = 16,
	FDFEnter = 17,
	FDFExit = 18,
	FDFDown = 19,
	FDFUp = 20,
	FDFFormat = 21,
	FDFValidate = 22,
	FDFKeystroke = 23,
	FDFCalculate = 24,
	FDFNormalAP = 25,
	FDFRolloverAP = 26,
	FDFDownAP = 27;

/*. resource .*/ function fdf_open(/*. string .*/ $filename){}
/*. resource .*/ function fdf_open_string(/*. string .*/ $fdf_data){}
/*. resource .*/ function fdf_create(){}
/*. void .*/ function fdf_close(/*. resource .*/ $fdfdoc){}
/*. string.*/ function fdf_get_value(/*. resource .*/ $fdfdoc, /*. string .*/ $fieldname /*., args .*/){}
/*. bool  .*/ function fdf_set_value(/*. resource .*/ $fdfdoc, /*. string .*/ $fieldname, /*. mixed .*/ $value /*., args .*/){}
/*. string.*/ function fdf_next_field_name(/*. resource .*/ $fdfdoc /*., args .*/){}
/*. bool  .*/ function fdf_set_ap(/*. resource .*/ $fdfdoc, /*. string .*/ $fieldname, /*. int .*/ $face, /*. string .*/ $filename, /*. int .*/ $pagenr){}
/*. bool  .*/ function fdf_get_ap(/*. resource .*/ $fdfdoc, /*. string .*/ $fieldname, /*. int .*/ $face, /*. string .*/ $filename){}
/*. string.*/ function fdf_get_encoding(/*. resource .*/ $fdf){}
/*. bool  .*/ function fdf_set_status(/*. resource .*/ $fdfdoc, /*. string .*/ $status){}
/*. string.*/ function fdf_get_status(/*. resource .*/ $fdfdoc){}
/*. bool  .*/ function fdf_set_file(/*. resource .*/ $fdfdoc, /*. string .*/ $filename /*., args .*/){}
/*. string.*/ function fdf_get_file(/*. resource .*/ $fdfdoc){}
/*. bool  .*/ function fdf_save(/*. resource .*/ $fdfdoc /*., args .*/){}
/*. string.*/ function fdf_save_string(/*. resource .*/ $fdfdoc){}
/*. bool  .*/ function fdf_add_template(/*. resource .*/ $fdfdoc, /*. int .*/ $newpage, /*. string .*/ $filename, /*. string .*/ $template, /*. int .*/ $rename){}
/*. bool  .*/ function fdf_set_flags(/*. resource .*/ $fdfdoc, /*. string .*/ $fieldname, /*. int .*/ $whichflags, /*. int .*/ $newflags){}
/*. int   .*/ function fdf_get_flags(/*. resource .*/ $fdfdoc, /*. string .*/ $fieldname, /*. int .*/ $whichflags){}
/*. bool  .*/ function fdf_set_opt(/*. resource .*/ $fdfdoc, /*. string .*/ $fieldname, /*. int .*/ $element, /*. string .*/ $value, /*. string .*/ $name){}
/*. mixed .*/ function fdf_get_opt(/*. resource .*/ $fdfdof, /*. string .*/ $fieldname /*., args .*/){}
/*. bool  .*/ function fdf_set_submit_form_action(/*. resource .*/ $fdfdoc, /*. string .*/ $fieldname, /*. int .*/ $whichtrigger, /*. string .*/ $url, /*. int .*/ $flags){}
/*. bool  .*/ function fdf_set_javascript_action(/*. resource .*/ $fdfdoc, /*. string .*/ $fieldname, /*. int .*/ $whichtrigger, /*. string .*/ $script){}
/*. bool  .*/ function fdf_set_encoding(/*. resource .*/ $fdf_document, /*. string .*/ $encoding){}
/*. int   .*/ function fdf_errno(){}
/*. string.*/ function fdf_error( /*. args .*/){}
/*. string.*/ function fdf_get_version( /*. args .*/){}
/*. bool  .*/ function fdf_set_version(/*. resource .*/ $fdfdoc, /*. string .*/ $version){}
/*. bool  .*/ function fdf_add_doc_javascript(/*. resource .*/ $fdfdoc, /*. string .*/ $scriptname, /*. string .*/ $script){}
/*. bool  .*/ function fdf_set_on_import_javascript(/*. resource .*/ $fdfdoc, /*. string .*/ $script /*., args .*/){}
/*. bool  .*/ function fdf_set_target_frame(/*. resource .*/ $fdfdoc, /*. string .*/ $target){}
/*. bool  .*/ function fdf_remove_item(/*. resource .*/ $fdfdoc, /*. string .*/ $fieldname, /*. int .*/ $item){}
/*. array .*/ function fdf_get_attachment(/*. resource .*/ $fdfdoc, /*. string .*/ $fieldname, /*. string .*/ $savepath){}
/*. bool  .*/ function fdf_enum_values(/*. resource .*/ $fdfdoc, /*. string .*/ $function_ /*., args .*/){}
/*. void .*/ function fdf_header(){}
