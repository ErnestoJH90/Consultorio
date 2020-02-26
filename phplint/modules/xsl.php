<?php
/** XSL functions.

	See: {@link http://www.php.net/manual/en/ref.xsl.php}
	@package xsl
*/

/*.  require_module 'dom'; .*/

const XSL_CLONE_AUTO = 1,
	XSL_CLONE_NEVER = 1,
	XSL_CLONE_ALWAYS = 1,
	LIBXSLT_VERSION = 1,
	LIBEXSLT_VERSION = 1,
	LIBXSLT_DOTTED_VERSION = '?',
	LIBEXSLT_DOTTED_VERSION = '?';

class XSLTProcessor {
	/*. void .*/    function __construct(){}
	/*. string .*/  function getParameter(/*. string .*/ $namespaceURI, /*. string .*/ $localName){}
	/*. bool .*/    function hasExsltSupport(){}
	/*. void .*/    function importStylesheet(/*. DOMDocument .*/ $doc){}
	/*. void .*/    function registerPHPFunctions(){}
	/*. bool .*/    function removeParameter(/*. string .*/ $namespace_, /*. string .*/ $name){}
	/*. bool .*/    function setParameter(/*. string .*/ $namespace_ /*., args .*/){}
	/*. DOMDocument .*/ function transformToDoc(/*. DOMNode .*/ $doc){}
	/*. int .*/     function transformToUri(/*. DOMDocument .*/ $doc, /*. string .*/ $uri){}
	/*. string .*/  function transformToXml(/*. DOMDocument .*/ $doc){}
}
