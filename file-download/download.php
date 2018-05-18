<?php
/**
 * This is a simple file download demo script. 
 * DO NOT use this code as is in production environment.
 */

// Absolute path where the downloadable files exist
$dowanload_dir = "/var/your-files-secret-location";

//Page where error messages are displaying 
$error_page = "http://website-error-notifocation-page.php";

$request_file = null;

//Expecting file name in query string as 'file'
if (isset($_GET['file']) && basename($_GET['file']) == $_GET['file']) {
	$request_file = $_GET['file'];
} else {
	header("Location:$error_page");
	exit;
}

if ($request_file) {

	$file_name = null; //Actual file name

	// Below swich statement can be replaced with your own logic for retrieving the actual file name.
	switch (strtolower($request_file)) {
		case "image":
			$file_name = "sample.jpg";
			break;
		case "pdf":
			$file_name = "sample.pdf";
			break;
	}

	if ($file_name) {
		$abs_file_path = $dowanload_dir . DIRECTORY_SEPARATOR .$file_name;
		if (file_exists($abs_file_path) && is_readable($abs_file_path)) {
			header('Content-type: application/octet-stream');
			header('Content-length: ' . filesize($abs_file_path));
			header('Content-disposition: attachment; filename='.$file_name);
			header('Content-transfer-encoding: binary');
			readfile($abs_file_path);
			exit(1);
		}
	}

	header("Location: $error_page");
	exit(0);
}