<?php
/** YP/NIS Functions.

See: {@link http://www.php.net/manual/en/ref.nis.php}
@package yp
*/


# FIXME: dummy values
const YPERR_BADARGS = 1,
	YPERR_BADDB = 1,
	YPERR_BUSY = 1,
	YPERR_DOMAIN = 1,
	YPERR_KEY = 1,
	YPERR_MAP = 1,
	YPERR_NODOM = 1,
	YPERR_NOMORE = 1,
	YPERR_PMAP = 1,
	YPERR_RESRC = 1,
	YPERR_RPC = 1,
	YPERR_YPBIND = 1,
	YPERR_YPERR = 1,
	YPERR_YPSERV = 1,
	YPERR_VERS = 1;

/*. string.*/ function yp_get_default_domain(){}
/*. int   .*/ function yp_order(/*. string .*/ $domain, /*. string .*/ $map){}
/*. string.*/ function yp_master(/*. string .*/ $domain, /*. string .*/ $map){}
/*. string.*/ function yp_match(/*. string .*/ $domain, /*. string .*/ $map, /*. string .*/ $key){}
/*. array .*/ function yp_first(/*. string .*/ $domain, /*. string .*/ $map){}
/*. array .*/ function yp_next(/*. string .*/ $domain, /*. string .*/ $map, /*. string .*/ $key){}
/*. bool  .*/ function yp_all(/*. string .*/ $domain, /*. string .*/ $map, /*. string .*/ $string_){}
/*. array .*/ function yp_cat(/*. string .*/ $domain, /*. string .*/ $map){}
/*. int   .*/ function yp_errno(){}
/*. string.*/ function yp_err_string(/*. int .*/ $errorcode){}
