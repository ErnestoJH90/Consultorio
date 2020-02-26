<?php

/*
 * Language and locale functions.
 */

const ABDAY_1 = 131072,
	ABDAY_2 = 131073,
	ABDAY_3 = 131074,
	ABDAY_4 = 131075,
	ABDAY_5 = 131076,
	ABDAY_6 = 131077,
	ABDAY_7 = 131078,
	ABMON_1 = 131086,
	ABMON_10 = 131095,
	ABMON_11 = 131096,
	ABMON_12 = 131097,
	ABMON_2 = 131087,
	ABMON_3 = 131088,
	ABMON_4 = 131089,
	ABMON_5 = 131090,
	ABMON_6 = 131091,
	ABMON_7 = 131092,
	ABMON_8 = 131093,
	ABMON_9 = 131094,
	CRNCYSTR = 262159,
	LC_ALL = 6,
	LC_COLLATE = 3,
	LC_CTYPE = 0,
	LC_MESSAGES = 5,
	LC_MONETARY = 4,
	LC_NUMERIC = 1,
	LC_TIME = 2;

/*. string.*/ function nl_langinfo(/*. int .*/ $item){}
/*. string.*/ function setlocale(/*. int .*/ $category, /*. mixed .*/ $locale /*., args .*/){}
/*. array[string]mixed .*/ function localeconv(){}
/*. array[]int .*/ function localtime($timestamp=0, $is_associative=FALSE)
/*. triggers E_NOTICE, E_WARNING .*/{}
/*. string.*/ function soundex(/*. string .*/ $str){}
/*. int   .*/ function levenshtein(/*. string .*/ $str1, /*. string .*/ $str2 /*., args .*/){}
/*. string.*/ function convert_cyr_string(/*. string .*/ $str, /*. string .*/ $from, /*. string .*/ $to){}
/*. string.*/ function metaphone(/*. string .*/ $str /*., args .*/){}
/*. string .*/ function hebrev(/*. string .*/ $str, $max_chars_per_line = 0){}
/*. string .*/ function hebrevc(/*. string .*/ $str, $max_chars_per_line = 0){}
