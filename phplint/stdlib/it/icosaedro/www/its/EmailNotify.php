<?php

namespace it\icosaedro\www\its;
require_once __DIR__ . "/../../../../all.php";
use it\icosaedro\sql\SQLException;
use it\icosaedro\www\SiteSpecific;
use it\icosaedro\email\Mailer;
use it\icosaedro\io\IOException;
use it\icosaedro\web\Log;
use Exception;

/**
 * Send email notification about new issues and new messages added to the ITS.
 * An email is sent to each member of the project.
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2019/01/08 09:53:55 $
 */
class EmailNotify {
	
	/*. forward static void function send(int $message_id); .*/
	
	/**
	 * Send notification about the specified message to all the members of the
	 * project. Email recipients rejected by the SMTP server are reported on the
	 * log.
	 * @param int $message_id ID of the message to notify.
	 * @throws SQLException DB failure, no message sent.
	 * @throws IOException Failed talking to the SMTP server, no message sent.
	 */
	private static function send_exception($message_id)
	{
		$db = Common::getDB();
		
		// Retrieve message:
		$res = $db->query("select * from messages where id=$message_id");
		$res->moveToRow(0);
		$project_id = $res->getIntByName("project_id");
		$issue_number = $res->getIntByName("issue_number");
		$message_created_time = $res->getIntByName("created_time");
		$created_by = $res->getIntByName("created_by");
		$diff = $res->getStringByName("diff");
		$content = $res->getStringByName("content");
		$folder_id = $res->getIntByName("folder_id");
		if( $res->wasNull() )
			$folder_id = -1;
		
		// Retrieve issue:
		$res = $db->query("select * from issues where project_id=$project_id and number=$issue_number");
		$res->moveToRow(0);
		$issue_created_time = $res->getIntByName("created_time");
		$category_code = $res->getIntByName("category");
		$tags = $res->getStringByName("tags");
		$is_open = $res->getBooleanByName("is_open");
		$subject = $res->getStringByName("subject");
		$assigned_to = $res->getIntByName("assigned_to");
		if( $res->wasNull() )
			$assigned_to = -1;
		
		// Retrieve assignee:
		if( $assigned_to < 0 ){
			$assigned_to_name = "NOT ASSIGNED";
		} else {
			$res = $db->query("select current_name from icodb.users where pk=$assigned_to");
			$res->moveToRow(0);
			$assigned_to_name = $res->getStringByName("current_name");
		}
		
		// Retrieve user name:
		$res = $db->query("select current_name from icodb.users where pk=$created_by");
		$res->moveToRow(0);
		$created_by_name = $res->getStringByName("current_name");
		
		// Retrieve project:
		$p = Project::getCachedProject($project_id);
		
		// Retrieve members:
		$sql = "select email from icodb.users, permissions where email<>'' and permissions.project_id=$project_id and permissions.user_id=icodb.users.pk";
		$res = $db->query($sql);
		$recipients = /*. (string[int]) .*/ [];
		for($i = 0; $i < $res->getRowCount(); $i++){
			$res->moveToRow($i);
			$recipients[] = $res->getStringByName("email");
		}
		if( count($recipients) == 0 )
			return;
		
		$m = new Mailer();
		
		// Set From.
		// FIXME: apparently, Mailer supports one single From address.
		$admin_emails = explode(",", SiteSpecific::ADMIN_EMAIL);
		if( count($admin_emails) > 0 )
			$m->setFrom($admin_emails[0]);
		
		for($i = 0; $i < count($recipients); $i++)
			$m->addBCC($recipients[$i]);
		
		// Make a suitable status code: NEW, OPEN or CLOSED:
		if( $message_created_time == $issue_created_time )
			$status = "NEW";
		else if( $is_open )
			$status = "OPEN";
		else
			$status = "CLOSED";
		
		$m->setSubject("[" . $p->name . " #$issue_number $status] $subject");
		
		$body =
		    "Project:       " . $p->name
		. "\nIssue number:  $issue_number"
		. "\nStatus:        " . ($is_open? "OPEN" : "CLOSED")
		. "\nCategory:      " . FieldCategory::codeToName($category_code)
		. "\nTags:          $tags"
		. "\nAssigned to:   $assigned_to_name"
		. "\nDirect access: " . DirectAccess::directLink($project_id, $issue_number)
		. "\nSubmitted by:  $created_by_name\n"
		. $diff
		. "\n$content";
		if( $folder_id >= 0 )
			$body .= "\n\n[Attachments omitted]\n";
		
		$m->setTextMessage($body);
		
		$rejected = $m->sendBySMTP(SiteSpecific::MAILER_HOSTS, FALSE);
		
		if( count($rejected) > 0 ){
			$err = "ITS project " . $p->name .", the following members' addresses where rejected by the SMTP server:\n";
			for($i = 0; $i < count($rejected); $i++)
				$err .= "Rejected email: " . $rejected[$i][0] . ", reason: " . $rejected[$i][1] . "\n";
			Log::warning($err);
		}
	}
	
	/**
	 * Send notification about the specified message to all the members of the
	 * project.
	 * @param int $message_id ID of the message.
	 */
	static function send($message_id)
	{
		try {
			self::send_exception($message_id);
		}
		catch(Exception $e){
			Log::error("email notification about message ID $message_id failed: $e");
		}
	}
	
}
