<?php
echo ('<b><h6>currently logged in: '.$_SESSION["myusername"].':');
if ($_SESSION["admin"] == 1){
	echo "Admin,  ";
	}
if ($_SESSION["super"] == 1) {
	echo "Supervisor<br></h6></b>";
	}
	?>