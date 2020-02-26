<?php
/** Image Functions.

See: {@link http://www.php.net/manual/en/book.image.php}
@package gd
*/

# Required for E_WARNING:
/*. require_module 'core'; .*/


# FIXME: all these values are dummy:
const GD_BUNDLED = 1,
	GD_EXTRA_VERSION = '',
	GD_MAJOR_VERSION = 2,
	GD_MINOR_VERSION = 0,
	GD_RELEASE_VERSION = 35,
	GD_VERSION = '2.0.35',
	IMAGETYPE_UNKNOWN = 0,
	IMG_AFFINE_ROTATE = 2,
	IMG_AFFINE_SCALE = 1,
	IMG_AFFINE_SHEAR_HORIZONTAL = 3,
	IMG_AFFINE_SHEAR_VERTICAL = 4,
	IMG_AFFINE_TRANSLATE = 0,
	IMG_ARC_CHORD = 1,
	IMG_ARC_EDGED = 4,
	IMG_ARC_NOFILL = 2,
	IMG_ARC_PIE = 0,
	IMG_ARC_ROUNDED = 0,
	IMG_BELL = 1,
	IMG_BESSEL = 2,
	IMG_BICUBIC = 4,
	IMG_BICUBIC_FIXED = 5,
	IMG_BILINEAR_FIXED = 3,
	IMG_BLACKMAN = 6,
	IMG_BOX = 7,
	IMG_BSPLINE = 8,
	IMG_CATMULLROM = 9,
	IMG_COLOR_BRUSHED = -3,
	IMG_COLOR_STYLED = -2,
	IMG_COLOR_STYLEDBRUSHED = -4,
	IMG_COLOR_TILED = -5,
	IMG_COLOR_TRANSPARENT = -6,
	IMG_CROP_BLACK = 2,
	IMG_CROP_DEFAULT = 0,
	IMG_CROP_SIDES = 4,
	IMG_CROP_THRESHOLD = 5,
	IMG_CROP_TRANSPARENT = 1,
	IMG_CROP_WHITE = 3,
	IMG_EFFECT_ALPHABLEND = 1,
	IMG_EFFECT_NORMAL = 2,
	IMG_EFFECT_OVERLAY = 3,
	IMG_EFFECT_REPLACE = 0,
	IMG_FILTER_BRIGHTNESS = 2,
	IMG_FILTER_COLORIZE = 4,
	IMG_FILTER_CONTRAST = 3,
	IMG_FILTER_EDGEDETECT = 5,
	IMG_FILTER_EMBOSS = 6,
	IMG_FILTER_GAUSSIAN_BLUR = 7,
	IMG_FILTER_GRAYSCALE = 1,
	IMG_FILTER_MEAN_REMOVAL = 9,
	IMG_FILTER_NEGATE = 0,
	IMG_FILTER_PIXELATE = 11,
	IMG_FILTER_SELECTIVE_BLUR = 8,
	IMG_FILTER_SMOOTH = 10,
	IMG_FLIP_BOTH = 3,
	IMG_FLIP_HORIZONTAL = 1,
	IMG_FLIP_VERTICAL = 2,
	IMG_GAUSSIAN = 10,
	IMG_GD2_COMPRESSED = 2,
	IMG_GD2_RAW = 1,
	IMG_GENERALIZED_CUBIC = 11,
	IMG_GIF = 1,
	IMG_HAMMING = 13,
	IMG_HANNING = 14,
	IMG_HERMITE = 12,
	IMG_JPEG = 2,
	IMG_JPG = 2,
	IMG_MITCHELL = 15,
	IMG_NEAREST_NEIGHBOUR = 16,
	IMG_PNG = 4,
	IMG_POWER = 17,
	IMG_QUADRATIC = 18,
	IMG_SINC = 19,
	IMG_TRIANGLE = 20,
	IMG_WBMP = 8,
	IMG_WEIGHTED4 = 21,
	IMG_XPM = 16,
	PNG_ALL_FILTERS = 248,
	PNG_FILTER_AVG = 64,
	PNG_FILTER_NONE = 8,
	PNG_FILTER_PAETH = 128,
	PNG_FILTER_SUB = 16,
	PNG_FILTER_UP = 32,
	PNG_NO_FILTER = 0;

/*. mixed[string] .*/ function gd_info(){}
/*. int   .*/ function imageloadfont(/*. string .*/ $filename)/*. triggers E_WARNING .*/{}
/*. bool  .*/ function imagesetstyle(/*. resource .*/ $im, /*. array .*/ $styles){}
/*. resource .*/ function imagecreatetruecolor(/*. int .*/ $x_size, /*. int .*/ $y_size){}
/*. bool  .*/ function imageistruecolor(/*. resource .*/ $im){}
/*. void .*/ function imagetruecolortopalette(/*. resource .*/ $im, /*. bool .*/ $ditherFlag, /*. int .*/ $colorsWanted){}
/*. bool  .*/ function imagecolormatch(/*. resource .*/ $im1, /*. resource .*/ $im2){}
/*. bool  .*/ function imagesetthickness(/*. resource .*/ $im, /*. int .*/ $thickness){}
/*. bool  .*/ function imagefilledellipse(/*. resource .*/ $im, /*. int .*/ $cx, /*. int .*/ $cy, /*. int .*/ $w, /*. int .*/ $h, /*. int .*/ $color){}
/*. bool  .*/ function imagefilledarc(/*. resource .*/ $im, /*. int .*/ $cx, /*. int .*/ $cy, /*. int .*/ $w, /*. int .*/ $h, /*. int .*/ $s, /*. int .*/ $e, /*. int .*/ $col, /*. int .*/ $style){}
/*. bool  .*/ function imagealphablending(/*. resource .*/ $im, /*. bool .*/ $on){}
/*. bool  .*/ function imagesavealpha(/*. resource .*/ $im, /*. bool .*/ $on){}
/*. bool  .*/ function imagelayereffect(/*. resource .*/ $im, /*. int .*/ $effect){}
/*. int   .*/ function imagecolorallocatealpha(/*. resource .*/ $im, /*. int .*/ $red, /*. int .*/ $green, /*. int .*/ $blue, /*. int .*/ $alpha){}
/*. int   .*/ function imagecolorresolvealpha(/*. resource .*/ $im, /*. int .*/ $red, /*. int .*/ $green, /*. int .*/ $blue, /*. int .*/ $alpha){}
/*. int   .*/ function imagecolorclosestalpha(/*. resource .*/ $im, /*. int .*/ $red, /*. int .*/ $green, /*. int .*/ $blue, /*. int .*/ $alpha){}
/*. int   .*/ function imagecolorexactalpha(/*. resource .*/ $im, /*. int .*/ $red, /*. int .*/ $green, /*. int .*/ $blue, /*. int .*/ $alpha){}
/*. bool  .*/ function imagecopyresampled(/*. resource .*/ $dst_im, /*. resource .*/ $src_im, /*. int .*/ $dst_x, /*. int .*/ $dst_y, /*. int .*/ $src_x, /*. int .*/ $src_y, /*. int .*/ $dst_w, /*. int .*/ $dst_h, /*. int .*/ $src_w, /*. int .*/ $src_h){}
/*. resource .*/ function imagerotate(/*. resource .*/ $src_im, /*. float .*/ $angle, /*. int .*/ $bgdcolor){}
/*. bool  .*/ function imagesettile(/*. resource .*/ $image, /*. resource .*/ $tile){}
/*. bool  .*/ function imagesetbrush(/*. resource .*/ $image, /*. resource .*/ $brush){}
/*. resource .*/ function imagecreate(/*. int .*/ $x_size, /*. int .*/ $y_size){}
/*. int   .*/ function imagetypes(){}
/*. resource .*/ function imagecreatefromstring(/*. string .*/ $image)/*. triggers E_WARNING .*/{}
/*. resource .*/ function imagecreatefromgif(/*. string .*/ $filename)/*. triggers E_WARNING .*/{}
/*. resource .*/ function imagecreatefromjpeg(/*. string .*/ $filename)/*. triggers E_WARNING .*/{}
/*. resource .*/ function imagecreatefrompng(/*. string .*/ $filename)/*. triggers E_WARNING .*/{}
/*. resource .*/ function imagecreatefromxbm(/*. string .*/ $filename)/*. triggers E_WARNING .*/{}
/*. resource .*/ function imagecreatefromxpm(/*. string .*/ $filename)/*. triggers E_WARNING .*/{}
/*. resource .*/ function imagecreatefromwbmp(/*. string .*/ $filename)/*. triggers E_WARNING .*/{}
/*. resource .*/ function imagecreatefromgd(/*. string .*/ $filename)/*. triggers E_WARNING .*/{}
/*. resource .*/ function imagecreatefromgd2(/*. string .*/ $filename)/*. triggers E_WARNING .*/{}
/*. resource .*/ function imagecreatefromgd2part(/*. string .*/ $filename, /*. int .*/ $srcX, /*. int .*/ $srcY, /*. int .*/ $width, /*. int .*/ $height)/*. triggers E_WARNING .*/{}
/*. int   .*/ function imagexbm(/*. resource .*/ $im, /*. string .*/ $filename, $foreground = 0)/*. triggers E_WARNING .*/{}
/*. bool  .*/ function imagegif(/*. resource .*/ $im, /*. string .*/ $filename = NULL)/*. triggers E_WARNING .*/{}
/*. bool  .*/ function imagepng(/*. resource .*/ $im, /*. string .*/ $filename = NULL, $quality = 0, $filters = 0)/*. triggers E_WARNING .*/{}
/*. bool  .*/ function imagejpeg(/*. resource .*/ $im, /*. string .*/ $filename = NULL, $quality = 0)/*. triggers E_WARNING .*/{}
/*. bool  .*/ function imagewbmp(/*. resource .*/ $im, /*. string .*/ $filename, $foreground = 0)/*. triggers E_WARNING .*/{}
/*. bool  .*/ function imagegd(/*. resource .*/ $im, /*. string .*/ $filename = NULL)/*. triggers E_WARNING .*/{}
/*. bool  .*/ function imagegd2(/*. resource .*/ $im, /*. string .*/ $filename = NULL, $chunk_size = 0, $type = IMG_GD2_RAW)/*. triggers E_WARNING .*/{}
/*. bool  .*/ function imagedestroy(/*. resource .*/ $im){}
/*. int   .*/ function imagecolorallocate(/*. resource .*/ $im, /*. int .*/ $red, /*. int .*/ $green, /*. int .*/ $blue){}
/*. void .*/ function imagepalettecopy(/*. resource .*/ $dst, /*. resource .*/ $src){}
/*. int   .*/ function imagecolorat(/*. resource .*/ $im, /*. int .*/ $x, /*. int .*/ $y){}
/*. int   .*/ function imagecolorclosest(/*. resource .*/ $im, /*. int .*/ $red, /*. int .*/ $green, /*. int .*/ $blue){}
/*. int   .*/ function imagecolorclosesthwb(/*. resource .*/ $im, /*. int .*/ $red, /*. int .*/ $green, /*. int .*/ $blue){}
/*. bool  .*/ function imagecolordeallocate(/*. resource .*/ $im, /*. int .*/ $index){}
/*. int   .*/ function imagecolorresolve(/*. resource .*/ $im, /*. int .*/ $red, /*. int .*/ $green, /*. int .*/ $blue){}
/*. int   .*/ function imagecolorexact(/*. resource .*/ $im, /*. int .*/ $red, /*. int .*/ $green, /*. int .*/ $blue){}
/*. void .*/ function imagecolorset(/*. resource .*/ $im, /*. int .*/ $col, /*. int .*/ $red, /*. int .*/ $green, /*. int .*/ $blue){}
/*. int[int] .*/ function imagecolorsforindex(/*. resource .*/ $im, /*. int .*/ $col){}
/*. bool  .*/ function imagegammacorrect(/*. resource .*/ $im, /*. float .*/ $inputgamma, /*. float .*/ $outputgamma){}
/*. bool  .*/ function imagesetpixel(/*. resource .*/ $im, /*. int .*/ $x, /*. int .*/ $y, /*. int .*/ $col){}
/*. bool  .*/ function imageline(/*. resource .*/ $im, /*. int .*/ $x1, /*. int .*/ $y1, /*. int .*/ $x2, /*. int .*/ $y2, /*. int .*/ $col){}

/**
@deprecated Use combination of {@link imagesetstyle()} and {@link imageline()} instead. */
/*. bool  .*/ function imagedashedline(/*. resource .*/ $im, /*. int .*/ $x1, /*. int .*/ $y1, /*. int .*/ $x2, /*. int .*/ $y2, /*. int .*/ $col)
{}

/*. bool  .*/ function imagerectangle(/*. resource .*/ $im, /*. int .*/ $x1, /*. int .*/ $y1, /*. int .*/ $x2, /*. int .*/ $y2, /*. int .*/ $col){}
/*. bool  .*/ function imagefilledrectangle(/*. resource .*/ $im, /*. int .*/ $x1, /*. int .*/ $y1, /*. int .*/ $x2, /*. int .*/ $y2, /*. int .*/ $col){}
/*. bool  .*/ function imagearc(/*. resource .*/ $im, /*. int .*/ $cx, /*. int .*/ $cy, /*. int .*/ $w, /*. int .*/ $h, /*. int .*/ $s, /*. int .*/ $e, /*. int .*/ $col){}
/*. bool  .*/ function imageellipse(/*. resource .*/ $im, /*. int .*/ $cx, /*. int .*/ $cy, /*. int .*/ $w, /*. int .*/ $h, /*. int .*/ $color){}
/*. bool  .*/ function imagefilltoborder(/*. resource .*/ $im, /*. int .*/ $x, /*. int .*/ $y, /*. int .*/ $border, /*. int .*/ $col){}
/*. bool  .*/ function imagefill(/*. resource .*/ $im, /*. int .*/ $x, /*. int .*/ $y, /*. int .*/ $col){}
/*. int   .*/ function imagecolorstotal(/*. resource .*/ $im){}
/*. int   .*/ function imagecolortransparent(/*. resource .*/ $im, $color=-1){}
/*. int   .*/ function imageinterlace(/*. resource .*/ $im, $interlace = 0){}
/*. bool  .*/ function imagepolygon(/*. resource .*/ $im, /*. int[int] .*/ $point, /*. int .*/ $num_points, /*. int .*/ $col){}
/*. bool  .*/ function imagefilledpolygon(/*. resource .*/ $im, /*. int[int] .*/ $point, /*. int .*/ $num_points, /*. int .*/ $col){}
/*. int   .*/ function imagefontwidth(/*. int .*/ $font){}
/*. int   .*/ function imagefontheight(/*. int .*/ $font){}
/*. bool  .*/ function imagechar(/*. resource .*/ $im, /*. int .*/ $font, /*. int .*/ $x, /*. int .*/ $y, /*. string .*/ $c, /*. int .*/ $col){}
/*. bool  .*/ function imagecharup(/*. resource .*/ $im, /*. int .*/ $font, /*. int .*/ $x, /*. int .*/ $y, /*. string .*/ $c, /*. int .*/ $col){}
/*. bool  .*/ function imagestring(/*. resource .*/ $im, /*. int .*/ $font, /*. int .*/ $x, /*. int .*/ $y, /*. string .*/ $str, /*. int .*/ $col){}
/*. bool  .*/ function imagestringup(/*. resource .*/ $im, /*. int .*/ $font, /*. int .*/ $x, /*. int .*/ $y, /*. string .*/ $str, /*. int .*/ $col){}
/*. bool  .*/ function imagecopy(/*. resource .*/ $dst_im, /*. resource .*/ $src_im, /*. int .*/ $dst_x, /*. int .*/ $dst_y, /*. int .*/ $src_x, /*. int .*/ $src_y, /*. int .*/ $src_w, /*. int .*/ $src_h){}
/*. bool  .*/ function imagecopymerge(/*. resource .*/ $src_im, /*. resource .*/ $dst_im, /*. int .*/ $dst_x, /*. int .*/ $dst_y, /*. int .*/ $src_x, /*. int .*/ $src_y, /*. int .*/ $src_w, /*. int .*/ $src_h, /*. int .*/ $pct){}
/*. bool  .*/ function imagecopymergegray(/*. resource .*/ $src_im, /*. resource .*/ $dst_im, /*. int .*/ $dst_x, /*. int .*/ $dst_y, /*. int .*/ $src_x, /*. int .*/ $src_y, /*. int .*/ $src_w, /*. int .*/ $src_h, /*. int .*/ $pct){}
/*. bool  .*/ function imagecopyresized(/*. resource .*/ $dst_im, /*. resource .*/ $src_im, /*. int .*/ $dst_x, /*. int .*/ $dst_y, /*. int .*/ $src_x, /*. int .*/ $src_y, /*. int .*/ $dst_w, /*. int .*/ $dst_h, /*. int .*/ $src_w, /*. int .*/ $src_h){}
/*. int   .*/ function imagesx(/*. resource .*/ $im){}
/*. int   .*/ function imagesy(/*. resource .*/ $im){}
/*. array .*/ function imageftbbox(/*. float .*/ $size, /*. float .*/ $angle, /*. string .*/ $font_file, /*. string .*/ $text, /*.array.*/ $extrainfo)/*. triggers E_WARNING .*/{}
/*. array .*/ function imagefttext(/*. resource .*/ $im, /*. float .*/ $size, /*. float .*/ $angle, /*. int .*/ $x, /*. int .*/ $y, /*. int .*/ $col, /*. string .*/ $font_file, /*. string .*/ $text, /*.array.*/ $extrainfo)/*. triggers E_WARNING .*/{}
/*. array .*/ function imagettfbbox(/*. float .*/ $size, /*. float .*/ $angle, /*. string .*/ $font_file, /*. string .*/ $text)/*. triggers E_WARNING .*/{}
/*. array .*/ function imagettftext(/*. resource .*/ $im, /*. float .*/ $size, /*. float .*/ $angle, /*. int .*/ $x, /*. int .*/ $y, /*. int .*/ $col, /*. string .*/ $font_file, /*. string .*/ $text)/*. triggers E_WARNING .*/{}

/*. if_php_ver_5 .*/
	/*. array .*/ function imagepsbbox(/*. string .*/ $text, /*. resource .*/ $font, /*. int .*/ $size /*., args .*/){}
	/*. bool  .*/ function imagepsencodefont(/*. resource .*/ $font_index, /*. string .*/ $filename)/*. triggers E_WARNING .*/{}
	/*. bool  .*/ function imagepsextendfont(/*. resource .*/ $font_index, /*. float .*/ $extend){}
	/*. bool  .*/ function imagepsfreefont(/*. resource .*/ $font_index){}
	/*. resource .*/ function imagepsloadfont(/*. string .*/ $pathname){}
	/*. bool  .*/ function imagepsslantfont(/*. resource .*/ $font_index, /*. float .*/ $slant){}
	/*. array .*/ function imagepstext(/*. resource .*/ $image, /*. string .*/ $text, /*. resource .*/ $font, /*. int .*/ $size, /*. int .*/ $xcoord, /*. int .*/ $ycoord /*., args .*/){}
/*. end_if_php_ver .*/

/*. bool  .*/ function image2wbmp(/*. resource .*/ $im /*., args .*/){}
/*. bool  .*/ function jpeg2wbmp(/*. string .*/ $f_org, /*. string .*/ $f_dest, /*. int .*/ $d_height, /*. int .*/ $d_width, /*. int .*/ $threshold){}
/*. bool  .*/ function png2wbmp(/*. string .*/ $f_org, /*. string .*/ $f_dest, /*. int .*/ $d_height, /*. int .*/ $d_width, /*. int .*/ $threshold){}
/*. bool  .*/ function imagefilter(/*. resource .*/ $src_im, /*. int .*/ $filtertype /*., args .*/){}
/*. bool  .*/ function imageantialias(/*. resource .*/ $im, /*. bool .*/ $on){}
/*. array .*/ function iptcparse(/*. string .*/ $iptcblock){}
/*. mixed .*/ function iptcembed(/*. string .*/ $iptcdata, /*. string .*/ $jpeg_file_name /*., args .*/)/*. triggers E_WARNING .*/{}

const IMAGETYPE_GIF = 1,
	IMAGETYPE_JPEG = 2,
	IMAGETYPE_PNG = 3,
	IMAGETYPE_SWF = 4,
	IMAGETYPE_PSD = 5,
	IMAGETYPE_BMP = 6,
	IMAGETYPE_WBMP = 15,
	IMAGETYPE_XBM = 16,
	IMAGETYPE_TIFF_II = 7,
	IMAGETYPE_TIFF_MM = 8,
	IMAGETYPE_JPEG2000 = 9,
	IMAGETYPE_IFF = 14,
	IMAGETYPE_JB2 = 12,
	IMAGETYPE_JPC = 9,
	IMAGETYPE_JP2 = 10,
	IMAGETYPE_JPX = 11,
	IMAGETYPE_SWC = 13,
	IMAGETYPE_ICO = 17,
	IMAGETYPE_COUNT = 18;

/*. mixed[] .*/ function getimagesize(
	/*. string .*/ $fn, /*. return array .*/ &$imageinfo = NULL)
	/*. triggers E_WARNING .*/{}
/*. mixed[] .*/ function getimagesizefromstring(
	/*. string .*/ $data, /*. return array .*/ &$imageinfo = NULL)
	/*. triggers E_WARNING .*/{}
/*. string .*/ function image_type_to_mime_type(/*. int .*/ $imagetype){}
/*. string .*/ function image_type_to_extension(/*. int .*/ $imagetype, $include_dot = TRUE){}
