<?php

namespace it\icosaedro\www\user;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\web\Html;
use it\icosaedro\web\Http;
use it\icosaedro\www\SiteSpecific;

/**
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/30 05:34:52 $
 */
class Common {
	
	static function echoNavBar()
	{
		echo "<table width='100%' cellpadding=4 bgcolor='#dddddd'><tr><td>";
		echo "&emsp;IWA:";
		echo "&emsp;<a href=\"", Html::text(SiteSpecific::LOGIN_URL), "\">Login...</a>";
		echo "&emsp;<a href=\"", Html::text(SiteSpecific::REGISTRATION_URL), "\">Registration...</a>";
		echo "&emsp;<a href=\"", Html::text(SiteSpecific::FORGOT_PASSWORD_URL), "\">Forgot password...</a>";
		echo "&emsp;</td></tr></table>";
	}
	
	/**
	 * @param string $title
	 */
	static function echoPageHeader($title)
	{
		Http::headerCacheControlNoStore();
		Http::headerContentTypeHtmlUTF8();
		echo "<html><header><title>$title</title></head><body>";
		self::echoNavBar();
		echo "<h1>$title</h1>";
	}
	
	
	static function echoPageFooter()
	{
		\it\icosaedro\www\Common::echoPageFooter();
	}

}
