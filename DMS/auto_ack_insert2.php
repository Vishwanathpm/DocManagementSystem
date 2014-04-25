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

//Get FileID, newest VersionID, and list of UserID's from previous form

$value = explode('_', $_POST['fileandversion']);

$file = $value[0];
$version = $value[1];
$requsers = $_POST['requsers'];

echo 'File:  '.$file.'  Version: '.$version.' Users: '.$requsers.'<br>';
include 'dbconnect.php';

			
//Execute insert of multiple records into acks table
foreach ($requsers as $selected){
    $sql ="INSERT INTO acks(fileid, userid, versionid, createdate) VALUES ($file, $selected, $version, (now()))";
$result=mysql_query($sql);
// Did it insert correctly?
	if($result){
		echo "Request Created.<br>";
		} else {
		echo "ERROR: $sql";
		}

}

//Send all the users an email at the same time.

//$sql3="SELECT * FROM users, files, acks WHERE acks.fileid = '$file' and acks.versionid = '$version' and users.userid=acks.userid and acks.fileid = files.fileid and acks.ackbit IS NULL acksent=0";
$sql3="select a.ackid, f.filename, f.docname, f.summary, u.email FROM acks a 
inner join files f
on a.fileid = f.fileid
inner join users u
on a.userid = u.userid
where a.fileid='$file' and a.versionid = '$version' and a.ackbit IS NULL and a.acksent IS NULL";
$result3 = mysql_query($sql3);

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


while ($row3=mysql_fetch_array($result3)){
	$ackid = $row3['ackid'];
	$headers = 'From: no-reply@mpm.com' . "\r\n" .
    'Reply-To: postmaster@mpm.com' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$to = $row3[email];
        echo $row3[email];
	$subject = "Document Acknowledgement Request - $row3[docname]";
$body = "<html><body>This email is being sent to you by the MPM Document Management System.<br><br>  ";
        $body .= "A document has been submitted that requires your approval.<br>  The system is only accessible from inside the Mill or through our VPN.<br>";
        $body .= "You will need to login with your username and password.<br>If you do not know them, please contact Tammie Blanchette. <br><br> <b>Changed Document:</b> <a href=\"http://svweb.monadnock.com/documents/documentdata/$row3[filename]\"><b>$row3[docname]</b><a>";
        $body .= "<br> <br><b><u>Summary of Changes Made</u></b><br><br><i>$row3[summary]</i><br><br><b><a href='http://svweb.monadnock.com/documents'>LOGIN HERE</a></html>";

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
echo "<a href='".$backlink."'>Back to Main Page</a>";


 include 'footer.php'; ?>
