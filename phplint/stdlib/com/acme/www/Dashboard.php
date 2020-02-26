<?php
/**
 * PHPLint demo web site. This file is part of the sample fictional Acme web
 * site built using the PHPLint standard library web tools, and it is meant to
 * illustrate the basic usage of sticky forms, bt_, and bt forms; a tutorial is
 * also available at {@link http://www.icosaedro.it/phplint/web}.
 * @package SampleAcmeWebSite
 */

namespace com\acme\www;

require_once __DIR__ . "/../../../all.php";

use it\icosaedro\web\Http;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\web\bt_\Form;
use com\acme\www\Common;

/**
 * User's landing page. Shows direct usage of bt_, no form.
 */
class Dashboard extends Form {
	
	static function XXXXXenter()
	{
		UserSession::stackReset();
		$user_name = UserSession::getSessionParameter("name");
		Http::headerContentTypeHtmlUTF8();
		echo "<html><body><h1>Dashboard</h1>\n";
		
		echo "<p align=right>Login name: ", htmlentities($user_name), "<br>";
		UserSession::anchor("LOGOUT", UserSession::class . "::logout");
		echo "</p>";
		
		UserSession::setCallBackward(self::class . "::enter");
		UserSession::anchor("Server State", "com\\acme\\www\\ServerState::enter");
		echo " - Displays server state informations. In a word: phpinfo().<p>";
		
//		echo "<a href='/StickyFormSample.php'>Sticky form sample</a> - Using sticky Form.<p>";
		
		UserSession::setCallBackward(self::class . "::enter");
		UserSession::anchor("Bt Form Sample", "com\\acme\\www\\BtFormSample::enter");
		echo " - Sample mask built using the bt Form class.<p>";
		
		echo "<a href='", htmlentities(Common::DISPATCHER_URL), "' target=_blank>New window</a> - Bt_ supports multiple window sessions within the current user session.<p>";
		
		if( $user_name !== "guest" ){
			UserSession::setCallBackward(self::class . "::enter");
			UserSession::anchor("User Profile", "com\\acme\\www\\UserProfile::enter");
			echo " - Shows your account profile and allows to change password.<p>";
		}
		
		// Default return point invoked on "back" in the brower:
		UserSession::setDefaultCallForward();
		UserSession::anchor("Update", self::class . "::enter");
		echo " - Re-loads this page. Handy feature to have while developing new pages with bt_. By unsing bt Forms, a specific handy browserReloadEvent() method is available.";
		
		echo Common::DISCLAIMER;
		echo "</body></html>";
	}
	
	function render()
	{
		UserSession::stackReset();
		$user_name = UserSession::getSessionParameter("name");
		Http::headerContentTypeHtmlUTF8();
		echo "<html><body><h1>Dashboard</h1>\n";
		$this->open();
		
		echo "<p align=right>Login name: ", htmlentities($user_name), "<br>";
		UserSession::anchor("LOGOUT", UserSession::class . "::logout");
		echo "</p>";
		
		UserSession::anchor("Server State", "com\\acme\\www\\ServerState::enter");
		echo " - Displays server state informations. In a word: phpinfo().<p>";
		
		UserSession::anchor("Form Sample", "com\\acme\\www\\BtFormSample::enter");
		echo " - Sample mask built using the bt Form class.<p>";
		
		echo "<a href='", htmlentities(Common::DISPATCHER_URL), "' target=_blank>New window</a> - Bt_ supports multiple window sessions within the current user session.<p>";
		
		if( $user_name !== "guest" ){
			UserSession::anchor("User Profile", "com\\acme\\www\\UserProfile::enter");
			echo " - Shows your account profile and allows to change password.<p>";
		}
		
		echo Common::DISCLAIMER;
		
		$this->close();
		echo "</body></html>";
	}
	
	
	static function enter()
	{
		(new self())->render();
	}
	
}
