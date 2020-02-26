<?php

/*
 * Advanced mathematical functions.
 */

const M_1_PI = 0.318309886183790691,
	M_2_PI = 0.636619772367581382,
	M_2_SQRTPI = 1.12837916709551256,
	M_E = 2.71828182845904509,
	M_EULER = 0.577215664901532866,
	M_LN10 = 2.3025850929940459,
	M_LN2 = 0.693147180559945286,
	M_LNPI = 1.14472988584940016,
	M_LOG10E = 0.434294481903251817,
	M_LOG2E = 1.44269504088896339,
	M_PI = 3.14159265358979312,
	M_PI_2 = 1.57079632679489656,
	M_PI_4 = 0.785398163397448279,
	M_SQRT1_2 = 0.707106781186547573,
	M_SQRT2 = 1.41421356237309515,
	M_SQRT3 = 1.73205080756887719,
	M_SQRTPI = 1.7724538509055161;

/*. float .*/ function acos(/*. float .*/ $x){}
/*. float .*/ function acosh(/*. float .*/ $x){}
/*. float .*/ function asin(/*. float .*/ $x){}
/*. float .*/ function asinh(/*. float .*/ $x){}
/*. float .*/ function atan(/*. float .*/ $x){}
/*. float .*/ function atan2(/*. float .*/ $y, /*. float .*/ $x){}
/*. float .*/ function atanh(/*. float .*/ $x){}
/*. float .*/ function cos(/*. float .*/ $x){}
/*. float .*/ function cosh(/*. float .*/ $x){}
/*. float .*/ function deg2rad(/*. float .*/ $number_){}
/*. float .*/ function exp(/*. float .*/ $x){}
/*. float .*/ function expm1(/*. float .*/ $x){}
/*. float .*/ function hypot(/*. float .*/ $x, /*. float .*/ $y){}
/*. float .*/ function log(/*. float .*/ $x){}
/*. float .*/ function log10(/*. float .*/ $x){}
/*. float .*/ function log1p(/*. float .*/ $x){}
/*. float .*/ function pi(){}

/**
 * Power elevation. The PHP interpreter has a built-in implementation when only
 * int operators are involved and the result does not overflow int, so this
 * function could return either int or float. For example, var_dump(pow(2,3))
 * gives int(8). This seems to be the only function of this module that may
 * return different types; all the others always return float.
 * @param float $base Actually can also be int.
 * @param float $exponent Actually can be also int.
 * @return mixed The result can be either int or float depending on the type and
 * values of the arguments. So, apply a cast to either (int) or (float) depending
 * on the expected result.
 */
function pow($base, $exponent){}

/*. float .*/ function rad2deg(/*. float .*/ $number_){}
/*. float .*/ function sin(/*. float .*/ $x){}
/*. float .*/ function sinh(/*. float .*/ $x){}
/*. float .*/ function sqrt(/*. float .*/ $x){}
/*. float .*/ function tan(/*. float .*/ $x){}
/*. float .*/ function tanh(/*. float .*/ $x){}
