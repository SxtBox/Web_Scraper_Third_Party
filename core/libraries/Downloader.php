<?php
 
class Downloader
{

    /**
     * Direct Download
     *
     * @param  string  $url     URL to the file you want to check
     * @return bool             Returns boolean
     */
    public function directDownload ($url, $filename) {

        file_put_contents($url, file_get_contents($url));   
        $fileSize = filesize($url);   

        header("Pragma: public"); // wtf?
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
        // omg what have you been reading?
        header("Cache-Control: private",false);  
        // obviously not rfc 2616
        header("Content-Type: application/stream");
        header("Content-Disposition: attachment; filename=\"wscraper-{$filename}\"" );
        header("Content-Transfer-Encoding: binary");
        ob_clean();
        flush();
        readfile( $url );

    }

    /**
     * Force to download Data
     *
     * @param  string  $url     URL to the file you want to check
     * @return bool             Returns boolean
     */
    public function save($url, $savepath) {

        $html = file_get_contents($url);
        file_put_contents($savepath, $html);

        return;
    }

  	/**
     * Force to download Data
     *
     * @param  string  $url     URL to the file you want to check
     * @return bool             Returns boolean
     */
    public function saveContent($html, $savepath) {

        ob_clean();
        file_put_contents($savepath, $html);
        return;
    }

}