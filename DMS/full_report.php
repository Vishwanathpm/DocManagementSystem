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
        }else {include 'user-header.html';
        $backlink = "my-acks.php";
        }}}
	echo "<br>"; ?>
<table border=1>
  <tr>
    <td align=center>CREATE FULL DOCUMENT REPORT</td>
  </tr>
  <tr>
    <td>
      <table border=0>
      <?
	        include "dbconnect.php";//database connection
			$query = "SELECT fileid, docname FROM files ORDER BY docname";
			$result = mysql_query($query) or die(mysql_error());
			$dropdown = "<select name='file'>";
			while($row = mysql_fetch_assoc($result)) {
			$dropdown .= "\r\n<option value='{$row['fileid']}'>{$row['docname']}</option>";
			}
			$dropdown .= "\r\n</select>";
			
      ?>
      <form method="post" action="full_report_display.php">
        <tr>        
          <td>Document to Report:</td>
          <td>
            <? echo $dropdown ?>
          </td>
        </tr>
 
        <tr>
          <td align="right">
            <input type="submit" 
          name="submit value" value="Show Report">
          </td>
        </tr>
      </form>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<? include 'footer.php'; ?>