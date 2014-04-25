<html>
    <head><link rel="stylesheet" type="text/css" href="style.css"></head>
    
<center><h1><b>Document Management System v1.0</b></h1></p>
<hr>

<hr>
<center>


		<form name="form1" method="post" action="checklogin.php">
			
				<table class="login">
					<tr>
						<td><h2>User Login </td>
					</tr>
					<tr>
						<td>Username</td>
						<td>:</td>
						<td><input name="myusername" type="text" id="myusername"></td>
					</tr>
					<tr>
						<td>Password</td>
						<td>:</td>
						<td><input name="mypassword" type="password" id="mypassword"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="submit" name="Submit" value="Login"></h2></td>
					</tr>
				</table>
                    <center><h6>If you do not have or do not know your username or password<br>
                            for this system, please contact <a href="mailto:tblanchette@mpm.com">Tammie Blanchette</a>.
                </td>
		</form>
	</tr>

<?php include 'footer.php'; ?>