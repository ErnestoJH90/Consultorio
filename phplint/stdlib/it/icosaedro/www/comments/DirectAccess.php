<?php

namespace it\icosaedro\www\comments;

require_once __DIR__ . "/../../../../all.php";

use it\icosaedro\sql\SQLException;
use it\icosaedro\web\Html;
use it\icosaedro\www\Common;
use it\icosaedro\www\SiteSpecific;
use it\icosaedro\web\AcceptLanguage;
use it\icosaedro\utils\SecurityKeys;
use it\icosaedro\utils\SecurityException;

/**
 * Allows direct access to the page comments from the the web pages.
 * 
 * <p>Web pages may invoke the
 * <pre>DirectAccess::showSummary();</pre>
 * 
 * <p>A direct link to the "add comment" form can also be put with
 * <pre>DirectAccess::echoAnchorToComments("", "Comments");</pre>
 * 
 * <p>The request handler index.php detects the comments page has been
 * requested by looking for the "comments" parameter in the URL:
 * <pre>https://www.icosaedro.it/iwa/index.php?comments=ENCODEDPAGE</pre>
 * ENCODEDPAGE contains the path of the resource to comment; this value
 * is protected from tampering to prevent comments from being submitted for
 * pages that are not intended to receive comments or arbitrary paths.
 * 
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/30 05:18:47 $
 */
class DirectAccess {

	/**
	 * Max no. of latest comments to this page to show.
	 */
	const LIMIT = 99;

	/**
	 * Max length of the body abstract.
	 */
	const ABS_MAX_SIZE = 1000;
	
	/**
	 * User's preferred language for a bit of localization.
	 * @var string
	 */
	private static $cached_language;
	
	private static function getThisPageResource()
	{
		return $_SERVER['SCRIPT_NAME'];
	}
	
	/**
	 * Returns the current page resource path, encoded and secured from tampering.
	 * @return string Value to set in the generated URLs and pointing to the
	 * comments for the current requested page.
	 */
	private static function encodePageResource()
	{
		$header = self::class . "-";
		return SecurityKeys::encode($header . self::getThisPageResource(), FALSE);
	}
	
	/**
	 * Decodes the requested page resource, checking for possible tampering.
	 * @param string $v Encoded and secured page resource.
	 * @return string Decoded and checked page resource.
	 * @throws SecurityException Decoding or verify failed.
	 */
	private static function decodePageResource($v)
	{
		$s = SecurityKeys::decode($v, FALSE);
		$header = self::class . "-";
		if( substr($s, 0, strlen($header)) !== $header )
			throw new SecurityException("not encoded data from this script: $s");
		return substr($s, strlen($header));
	}
	
	/**
	 * Returns user's preferred language among those supported.
	 * @return string
	 */
	private static function getLanguage()
	{
		if( self::$cached_language === NULL )
			self::$cached_language = AcceptLanguage::bestSupportedLanguageFromRequest("en, it")->language;
		return self::$cached_language;
	}
	
	/**
	 * Sends to output an HTML anchor to the comments for the specified page.
	 * The actual path of the page is secured with an anti-tampering signature.
	 * @param string $encoded_path Encoded and signed path to the resource.
	 * @param string $fragment Fragment part of the URL to generate. Either the
	 * empty string or "#123" where 123 is  the PK of the specific message.
	 * @param string $caption Displayed text of the anchor.
	 */
	private static function echoAnchorToCommentsForPath($encoded_path, $fragment, $caption)
	{
		echo "<a target=blank href='", SiteSpecific::DISPATCHER_URL, "?comments=",
			urlencode( base64_encode( $encoded_path ) ), "$fragment'>$caption</a>";
	}
	
	/**
	 * Sends to output an HTML anchor to the comments for the current requested
	 * page. The anchor is obfuscated against boring scanners by using JS code.
	 * The actual path of the page is secured with an anti-tampering signature.
	 * @param string $fragment Fragment part of the URL to generate. Either the
	 * empty string or "#123" where 123 is  the PK of the specific message.
	 * @param string $caption Displayed text of the anchor.
	 */
	static function echoAnchorToComments($fragment, $caption)
	{
		self::echoAnchorToCommentsForPath(self::encodePageResource(), $fragment, $caption);
	}

	/**
	 * Sends on output a summary of the latest messages added to the current page.
	 * @throws SQLException
	 */
	static function showSummary()
	{
		$path = self::getThisPageResource();

		$ps = SiteSpecific::getDB()->prepareStatement("SELECT pk FROM comments WHERE path=? ORDER BY time DESC LIMIT ?");
		$ps->setString(0, $path);
		$ps->setInt(1, self::LIMIT);
		$res = $ps->query();

		$n = $res->getRowCount();

		echo "<a name=comments></a><blockquote><i>";
		
		if( $n == 0 ){
			if( self::getLanguage() === "it" ){
				echo "Non ci sono ancora commenti a questa pagina. Usare il link </i>Commenti<i> qui sopra per aggiungere il tuo contributo.";
			} else {
				echo "Still no comments to this page. Use the </i>Comments<i> link above to add your contribute.";
			}
			
		} else {
			if( self::getLanguage() === "it" ){
				echo "Segue estratto degli ultimi commenti lasciati dai visitatori di questa pagina WEB.  Usare il link </i>Commenti<i> qui sopra per leggere tutti i messaggi o per aggiungere il tuo contributo.";
			} else {
				echo "An abstract of the lastest comments from the visitors of this page follows. Please, use the </i>Comments<i> link above to read all the messages or to add your contribute.";
			}
		}
		echo "</i> </blockquote>\n";
		
		$encoded_path = self::encodePageResource();

		for($i = 0; $i < $n; $i++ ){
			$res->moveToRow($i);
			$pk = $res->getIntByName("pk");
			$m = Message::fromPk($pk);
			$utc_date = substr(date("c", $m->time), 0, 10);
			echo "<p><code><b>$utc_date</b></code> by ",
				Html::text($m->current_name), "<br><b>",
				Html::text($m->subject), "</b><br>";
			$b = $m->body;
			# Remove quoted part:
			$b = preg_replace("/(^|\n)(>[^\n]*\n)+/", " [...] ", $b);
			$b = preg_replace("/[ \n\t]+/", " ", $b);
			$b = Common::short($b, self::ABS_MAX_SIZE);
			echo Html::text($b), "[";
			self::echoAnchorToCommentsForPath($encoded_path, "#$pk", "more...");
			echo ']<p>';
		}

		if( $n >= self::LIMIT ){
			if( self::getLanguage() === "it" )
				$caption = "altri commenti";
			else
				$caption = "more comments";
			self::echoAnchorToCommentsForPath($encoded_path, "", $caption);
		}
	}
	
	/**
	 * The request handler may invoke this method whenever it detects a "comments"
	 * URL parameter. This method decodes the parameter and displays the comments
	 * page requested.
	 */
	static function enter()
	{
		$path = self::decodePageResource( base64_decode( (string) $_GET["comments"] ) );
		PageCommentsMask::enter($path);
	}
}
