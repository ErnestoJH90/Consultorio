<?php
/** SOAP Functions.

See: {@link http://www.php.net/manual/en/ref.soap.php}
@package soap
*/

const SOAP_1_1 = 1,
	SOAP_1_2 = 1,
	SOAP_PERSISTENCE_SESSION = 1,
	SOAP_PERSISTENCE_REQUEST = 1,
	SOAP_FUNCTIONS_ALL = 1,
	SOAP_ENCODED = 1,
	SOAP_LITERAL = 1,
	SOAP_RPC = 1,
	SOAP_DOCUMENT = 1,
	SOAP_ACTOR_NEXT = 1,
	SOAP_ACTOR_NONE = 1,
	SOAP_ACTOR_UNLIMATERECEIVER = 1,
	SOAP_COMPRESSION_ACCEPT = 1,
	SOAP_COMPRESSION_GZIP = 1,
	SOAP_COMPRESSION_DEFLATE = 1,
	SOAP_AUTHENTICATION_BASIC = 1,
	SOAP_AUTHENTICATION_DIGEST = 1,
	UNKNOWN_TYPE = 1,
	XSD_STRING = 1,
	XSD_BOOLEAN = 1,
	XSD_DECIMAL = 1,
	XSD_FLOAT = 1,
	XSD_DOUBLE = 1,
	XSD_DURATION = 1,
	XSD_DATETIME = 1,
	XSD_TIME = 1,
	XSD_DATE = 1,
	XSD_GYEARMONTH = 1,
	XSD_GYEAR = 1,
	XSD_GMONTHDAY = 1,
	XSD_GDAY = 1,
	XSD_GMONTH = 1,
	XSD_HEXBINARY = 1,
	XSD_BASE64BINARY = 1,
	XSD_ANYURI = 1,
	XSD_QNAME = 1,
	XSD_NOTATION = 1,
	XSD_NORMALIZEDSTRING = 1,
	XSD_TOKEN = 1,
	XSD_LANGUAGE = 1,
	XSD_NMTOKEN = 1,
	XSD_NAME = 1,
	XSD_NCNAME = 1,
	XSD_ID = 1,
	XSD_IDREF = 1,
	XSD_IDREFS = 1,
	XSD_ENTITY = 1,
	XSD_ENTITIES = 1,
	XSD_INTEGER = 1,
	XSD_NONPOSITIVEINTEGER = 1,
	XSD_NEGATIVEINTEGER = 1,
	XSD_LONG = 1,
	XSD_INT = 1,
	XSD_SHORT = 1,
	XSD_BYTE = 1,
	XSD_NONNEGATIVEINTEGER = 1,
	XSD_UNSIGNEDLONG = 1,
	XSD_UNSIGNEDINT = 1,
	XSD_UNSIGNEDSHORT = 1,
	XSD_UNSIGNEDBYTE = 1,
	XSD_POSITIVEINTEGER = 1,
	XSD_NMTOKENS = 1,
	XSD_ANYTYPE = 1,
	XSD_ANYXML = 1,
	SOAP_ENC_OBJECT = 1,
	SOAP_ENC_ARRAY = 1,
	XSD_1999_TIMEINSTANT = 1,
	SOAP_SINGLE_ELEMENT_ARRAYS = 1,
	SOAP_WAIT_ONE_WAY_CALLS = 1,
	WSDL_CACHE_NONE = 1,
	WSDL_CACHE_DISK = 1,
	WSDL_CACHE_MEMORY = 1,
	WSDL_CACHE_BOTH = 1,
	XSD_NAMESPACE = '?',
	XSD_1999_NAMESPACE = '?';

class SoapParam
{
	/*. void .*/ function __construct(/*. mixed .*/ $data, /*. string .*/ $name){}
}

class SoapHeader
{
	/*. void .*/ function __construct(/*. string .*/ $namespace_, /*. string .*/ $name /*. , args .*/){}
}

class SoapFault
{
	/*. void .*/ function __construct(/*. string .*/ $faultcode, /*. string .*/ $faultstring /*. , args .*/){}
}

class SoapVar
{
	/*. void .*/ function __construct(/*. mixed .*/ $data, /*. int .*/ $encoding /*. , args .*/){}
}

class SoapServer
{
	/*. void .*/ function __construct(/*. string .*/ $wsdl /*. , args .*/){}
	/*. void .*/ function addFunction(/*. mixed .*/ $functions){}
	/*. object .*/ function setPersistence(/*. int .*/ $mode){}
	/*. void .*/ function setClass(/*. string .*/ $class_name /*. , args .*/){}
	/*. void .*/ function setObject(/*. object .*/ $obj){}
	/*. array .*/ function getFunctions(){}
	/*. void .*/ function handle(/*. args .*/){}
	/*. void .*/ function fault(/*. string .*/ $code, /*. string .*/ $str /*. , args .*/){}
}


class SoapClient
{
	/*. void .*/ function __construct(){}

	/** @deprecated Use {@link self::__soapCall()} instead. */
	/*. mixed .*/ function __call(/*. string .*/ $function_name, /*. array[int]mixed .*/ $arguments /*. , args .*/){}

	/*. mixed .*/ function __soapCall(/*. string .*/ $function_name, /*. array[int]mixed .*/ $arguments /*. , args .*/){}
	/*. string .*/ function __doRequest(){}
	/*. array .*/ function __getFunctions(){}
	/*. string .*/ function __getLastRequest(){}
	/*. string .*/ function __getLastRequestHeaders(){}
	/*. object .*/ function __getLastResponse(){}
	/*. string .*/ function __getLastResponseHeaders(){}
	/*. array .*/ function __getTypes(){}
	/*. void .*/ function __setCookie(/*. string .*/ $name /*. , args .*/){}
	/*. void .*/ function __setSoapHeaders(/*. array[int]SoapHeader .*/ $hdrs){}
	/*. string .*/ function __setLocation(/*. args .*/){}
}
