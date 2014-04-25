<?php
$target = "documentdata/";
$allfiles = glob($target . "*.*");

foreach($allfiles as $allfile)
	{
		echo "<a href=$allfile>".basename($allfile)."</a><br>";
	}
	?>