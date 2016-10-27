<?php
set_time_limit (0);
$ret = Zip('.');
?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Zip</title>
</head>
<body>
	<?php
		if ($ret === false) {
			?><p>Error.</p><?php
		} else {
			?><p>Done: <tt><?=$ret?></tt></p><?php
		}
	?>
</body>
</html><?php

function Zip($source, $target = null)
{
	if (!extension_loaded('zip') || !file_exists($source)) {
		return false;
	}
	
	if($target === null){
		$target = basename(realpath($source)) . '.' . uniqid() . '.zip';
	}

	$zip = new ZipArchive();

	if (!$zip->open($target, ZIPARCHIVE::CREATE)) {
		return false;
	}

	$target = realpath($target);

	$source = realpath($source);

	if (is_dir($source) === true)
	{
		$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

		foreach ($files as $file)
		{
			$path = realpath($file->getPathname());
			$localpath = str_replace($source . DIRECTORY_SEPARATOR, '', $path);

			$file = realpath($file);

			if($path === $target || $path === __FILE__){
				continue;
			}
			if (is_dir($file) === true)
			{
				$zip->addEmptyDir($localpath);
			}
			else if (is_file($file) === true)
			{
				$zip->addFile($path, $localpath);
			}
		}
	}
	else if (is_file($source) === true)
	{
		$zip->addFile(basename($source), $source);
	}

	$zip->close();
	return $target;
}
