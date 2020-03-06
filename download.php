<?php

include('core/helper.php');
include('core/libraries/Downloader.php');
$_downloader = new Downloader();

/*
 * fileurl
 */
$fileurl = @$_GET['r'];
$type    = @$_GET['type'];
if ( $fileurl ) {

	if ( $type == 'zip' ) {

		$zipfile = $fileurl . '.zip';
        $zippath = storage_path('zip');

        $zip = $zippath . DIRECTORY_SEPARATOR . $zipfile;
        if ( file_exists($zip) ) {
			return $_downloader->directDownload($zip, $zipfile);
        }

		echo "FILE NOT FOUND.";
		return;
	} 
	else {
		$fileinfo  = pathinfo($fileurl);

		$filename  = @$fileinfo['filename'];
		$basename  = @$fileinfo['basename'];
		$extension = @$fileinfo['extension'];
		if ( !$extension )
			$basename .= '.png';

	    $fileurl = str_replace(' ', '%20', $fileurl);

		if ( !filter_var($fileurl, FILTER_VALIDATE_URL ) === false) {
			return $_downloader->directDownload($fileurl, $basename);
		}

		echo "{$fileurl} IS NOT A VALID URL.";
		return;

	}

}

echo "404: PAGE NOT FOUND.";
return;

?>