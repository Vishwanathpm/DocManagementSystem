<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
if ($_SESSION["admin"] == 1){
	include 'header.html';
	$backlink = "login_success.php";
	} else {
            if ($_SESSION["super"] == 1) {
            include 'super-header.html';
            $backlink = "super_loginsuccess.php";
	} else {
                if ($_SESSION["mgr"] == 1) {
                 include 'mgr-header.html';
                $backlink = "mgr_loginsuccess.php";
        }else {}}}
	echo "<br>";
include 'dbconnect.php';

$value = explode('_', $_GET['id']);
$user = $value[0];
$ackident = $value[1];

//Use PHPMailer
require_once('class.phpmailer.php');
$mailer = new PHPMailer();
$mailer->Host = "mail.mindfireweb.com"; //outside SMTP server to avoid Intermedia
$mailer->SMTPDebug = 2;
$mailer->SMTPAuth = true;
$mailer->Port = 2525;
$mailer->Username = "mpm2@mindfireweb.com";
$mailer->Password = "1-password";
$mailer->SetFrom('no-reply@mpm.com','MPM Doc Control System');
                        


//Find email address and send message
//$sql="SELECT * FROM users,files,acks where acks.ackid='$ackid' and users.userid=acks.userid and acks.fileid = files.fileid and acks.ackbit IS NULL";
$sql="select a.ackid, f.filename, f.docname, f.summary, u.email FROM acks a 
inner join files f
on a.fileid = f.fileid
inner join users u
on a.userid = u.userid
where a.ackid='$ackident'";

$result=mysql_query($sql);

while ($row=mysql_fetch_array($result)){
	$ackid = $row[ackid];
        $summary = $row[summary];
	$headers = 'From: no-reply@mpm.com' . "\r\n" .
    'Reply-To: postmaster@mpm.com' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$to = $row[email];
	$subject = "Document Acknowledgment Request - $row[docname]";

	$body = "<html><body>This email is being sent to you by the MPM Document Management System.<br><br>  ";
        $body .= "A document has been submitted that requires your approval.<br>  The system is only accessible from inside the Mill or through our VPN.<br>";
        $body .= "You will need to login with your username and password.<br>If you do not know them, please contact Tammie Blanchette. <br><br> <b>Changed Document:</b> <a href=\"http://svweb.monadnock.com/documents/documentdata/$row[filename]\"><b>$row[docname]</b><a>";
        $body .= "<br> <br><b><u>Summary of Changes Made</u></b><br><br><i>$row[summary]</i><br><br><b><a href='http://svweb.monadnock.com/documents'>LOGIN HERE</a></html>";
        
        $mailer->Subject = $subject;
        $mailer->MsgHTML($body);
        $mailer->AddAddress($to,'');
        
	if ($mailer->Send()) {
		echo("<p>Message successfully sent!</p><br>");
		
	//Trigger a SENT bit on the Acknowledgement record	
		$sql2="UPDATE acks SET acksent=1, moddate=now() WHERE ackid='$ackid' ";
		$result2=mysql_query($sql2);
		} else {
		echo("<p>Message delivery failed...</p>");
		}
}
echo "<a href='".$backlink."'>Back to Acknowledgements</a>";


 include 'footer.php'; ?>