<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Unzip</title>
</head>
<body>
	<ul><?php
	foreach(scandir(".") as $k=>$v){
		if(strtolower(array_pop(explode('.',$v))) === "zip"){
			unzip($v);
		}
	}
	?></ul>
</body>
</html>
<?php

function unzip($filename){
	static $error = array();
	if(empty($error))
	{
		$error[ZIPARCHIVE::ER_EXISTS] = "<tt>ZIPARCHIVE::ER_EXISTS</tt> File already exists.";
		$error[ZIPARCHIVE::ER_INCONS] = "<tt>ZIPARCHIVE::ER_INCONS</tt> Zip archive inconsistent.";
		$error[ZIPARCHIVE::ER_INVAL ] = "<tt>ZIPARCHIVE::ER_INVAL</tt>  Invalid argument.";
		$error[ZIPARCHIVE::ER_MEMORY] = "<tt>ZIPARCHIVE::ER_MEMORY</tt> Malloc failure.";
		$error[ZIPARCHIVE::ER_NOENT ] = "<tt>ZIPARCHIVE::ER_NOENT</tt>  No such file.";
		$error[ZIPARCHIVE::ER_NOZIP ] = "<tt>ZIPARCHIVE::ER_NOZIP</tt>  Not a zip archive.";
		$error[ZIPARCHIVE::ER_OPEN  ] = "<tt>ZIPARCHIVE::ER_OPEN</tt>   Can't open file.";
		$error[ZIPARCHIVE::ER_READ  ] = "<tt>ZIPARCHIVE::ER_READ</tt>   Read error.";
		$error[ZIPARCHIVE::ER_SEEK  ] = "<tt>ZIPARCHIVE::ER_SEEK</tt>   Seek error.";
	}
	$zip = new ZipArchive;
	$res = $zip->open($filename);
	if ($res === true) {
		$zip->extractTo($filename.'_unzip/');
		$zip->close();
		echo "<li><strong>$filename</strong>: <span style='color:green'>Done.</span></li>";
	}
	else{
		echo "<li><strong>$filename</strong>: <span style='color:red'>Error</span> ".$error[$res]."</li>";
	}
}