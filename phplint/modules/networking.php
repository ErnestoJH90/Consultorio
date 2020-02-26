<?php

const DNS_A = 1,
	DNS_A6 = 16777216,
	DNS_AAAA = 134217728,
	DNS_ALL = 251713587,
	DNS_ANY = 268435456,
	DNS_CNAME = 16,
	DNS_HINFO = 4096,
	DNS_MX = 16384,
	DNS_NAPTR = 67108864,
	DNS_NS = 2,
	DNS_PTR = 2048,
	DNS_SOA = 32,
	DNS_SRV = 33554432,
	DNS_TXT = 32768;

/*. int   .*/ function ip2long(/*. string .*/ $ip_address){}
/*. string.*/ function long2ip(/*. int .*/ $proper_address){}
/*. string.*/ function gethostbyaddr(/*.string.*/ $ip){}
/*. string.*/ function gethostbyname(/*.string.*/ $hn){}
/*. string.*/ function gethostname(){}
/*. array[int]string .*/ function gethostbynamel(/*. string .*/ $hostname){}
/*. bool  .*/ function dns_check_record(/*. string .*/ $host /*., args .*/){}
/*. bool  .*/ function checkdnsrr(/*. string .*/ $host /*., args .*/){}
/*. bool  .*/ function dns_get_mx(/*. string .*/ $hostname, /*. return array[int]string .*/ &$mxhosts /*., args .*/){}
/*. bool  .*/ function getmxrr(/*. string .*/ $hostname, /*. return array[int]string .*/ &$a /*., args .*/){}
/*. array[int][string]mixed .*/ function dns_get_record(/*. string .*/ $hostname /*., args .*/){}
/*. resource .*/ function fsockopen(/*.string.*/ $target, $port=0, /*. return .*/ &$errno=0, /*. return .*/ &$errstr="", $timeout=0.0)
	/*. triggers E_WARNING .*/{}
/*. resource .*/ function pfsockopen(/*. string .*/ $hostname /*., args .*/)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function getservbyname(/*. string .*/ $service, /*. string .*/ $protocol){}
/*. string.*/ function getservbyport(/*. int .*/ $port, /*. string .*/ $protocol){}
/*. int   .*/ function getprotobyname(/*. string .*/ $name){}
/*. string.*/ function getprotobynumber(/*. int .*/ $number_){}
