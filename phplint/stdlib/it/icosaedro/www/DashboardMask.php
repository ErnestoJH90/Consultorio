<?php
namespace it\icosaedro\www;
require_once __DIR__ . "/../../../all.php";
use it\icosaedro\web\Http;
use it\icosaedro\web\bt_\UserSession;
use it\icosaedro\web\bt_\Form;

/**
 * IWA dashboard.
 * After login and default landing page implemented as a bt_ form.
 * The entry point is the enter() method.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/30 05:34:51 $
 */
class DashboardMask extends Form {
	
	function render()
	{
		UserSession::stackReset();
		Common::echoPageHeader();
		echo "<h2>IWA - Icosaedro Web Application</h2>";
		$this->open();
		?>
From this pages you may access the following sub-sections:
<ul>
	
	<li><p><b>Comments</b> - Commented pages of the web site. From here you may see the existing comments to each page and add your contribute. Registered users may have their real name displayed and may delete their own comments.</p></li>
	
	<li><p><b>ITS</b> - The <i>Issue Tracking Systems</i> allows to search and add contributions to the development of the projects. Some projects can be read by any user. Only the members of each project may add new comments.</p></li>
	
	<li><p><b>Preferences</b> - Allows to change the password, email, displayed name and the signature. Registered users only.</p></li>
	
	<li><p><b>Users</b> - Allows to set the permissions of the users. Site administrators only.</p></li>
	
	<li><p><b>Jobs</b> - Allows to start, stop and monitor server background jobs. Site administrators only.</p></li>
</ul>

<?php
		$this->close();
		Common::echoPageFooter();
	}
	
	static function enter()
	{
		$m = new self();
		$m->render();
	}
	
}
