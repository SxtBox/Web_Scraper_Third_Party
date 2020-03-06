
<?php 

include('core/helper.php');
include('core/libraries/Http.php');
include('core/libraries/Scraper.php');
include('core/libraries/Downloader.php');
include('core/libraries/Zip.php');

$url      = @$_POST['url'];
$action   = @$_POST['action'];

$response = [
                'type'        => $action,
                'data'        => [],
                'title'       => '',
                'description' => '',
                'keywords'    => '',
                'author'      => ''
            ];

if ( $url && $action ) {

    $_http       = new Http();
    $html        = $_http->get($url);

    if ( $html ) {
        
        $_scraper = new Scraper();

        $html_title = $_scraper->get($html, 'title');
        if ( $html_title ) {
            $html_title = reset($html_title);
            $response['title'] = @$html_title['contents'];
        }

        $html_meta  = $_scraper->get($html, 'meta');
        if ( $html_meta ) {
            foreach ($html_meta as $meta) {
                if ( @$meta['attributes']['name'] == 'description' || @$meta['attributes']['name'] == 'keywords' || @$meta['attributes']['name'] == 'author' ) {
                    $response[$meta['attributes']['name']] = @$meta['attributes']['content'];
                }
            }
        }

        /*
         * GET IMAGES
         */
        if ( $action == 'image' ) {

            $reshtml = $_scraper->get($html, 'img');

            $data = [];
            foreach ($reshtml as $key => $image) {
                $path = attrLinkValues($url, $image, 'attributes', 'src');
                if ( $path )
                    $data[] = $path;
            }

            $imageextensions = [ 'jpg', 'png', 'gif', 'svg' ];
            $links = getAllLinks($html);
            if ( $links ) {
                foreach ($links as $link) {
                    $linkext = linkExtension($link);
                    if ( in_array($linkext, $imageextensions) ) {
                        $data[] = $link;
                    }
                }
            }

            $data             = array_unique($data);
            $response['data'] = array_values($data);
        }
        /*
         * Tag with Attribute details
         */
        elseif ( $action == 'tag' ) {
            $type = $_POST['type'];
            if ( $type )
                $response['data'] = $_scraper->get($html, $type);
        }
        elseif ( $action == 'website' ) {

        /*
         * Get Links
         */
            $data       = [];

            // CSS
            $html_links = $_scraper->get($html, 'link');
            if ( $html_links ) {
                foreach ($html_links as $link) {
                    $linkhref = attrLinkValues($url, $link, 'attributes', 'href');
                    $data[]   = $linkhref;
                }
            }
            
            // IMAGES
            $html_imgs = $_scraper->get($html, 'img');

            if ( $html_imgs ) {
                foreach ($html_imgs as $img) {
                    $imgsrc = attrLinkValues($url, $img, 'attributes', 'src');
                    if ( $imgsrc )
                        $data[] = $imgsrc;
                }
            }

            // JS
            $html_scripts = $_scraper->get($html, 'script');
            if ( $html_scripts ) {
                foreach ($html_scripts as $script) {
                    $scriptsrc = attrLinkValues($url, $script, 'attributes', 'src');
                    if ( $scriptsrc )
                        $data[] = $scriptsrc;
                }
            }

            $alllinks = getAllLinks($html);
            $data  = array_merge($data, $alllinks);
            $data  = array_unique($data);
            $links = [];
            if ( $data ) {
                foreach ($data as $link) {
                    $linkext = linkExtension($link, 'z__Z');
                    $links[$linkext][] = $link;
                }
            }

            $response['data'] = $links;

        }

        elseif ( $action == 'site' ) {

            /*
             * Get Links
             */
                $data       = [];

                // CSS
                $html_links = $_scraper->get($html, 'link');
                if ( $html_links ) {
                    foreach ($html_links as $link) {
                        $linkhref   = attrLinkValues($url, $link, 'attributes', 'href');
                        $hrefcssext = pathinfo($linkhref, PATHINFO_EXTENSION);
                        if ( $hrefcssext == 'css' ) {
                            $data[] = [
                                          'htmlurl' => attrLinkValues($url, $link, 'attributes', 'href', true),
                                          'url'     => $linkhref,
                                      ];
                        }
                    }
                }
                
                // IMAGES
                $html_imgs = $_scraper->get($html, 'img');
                if ( $html_imgs ) {
                    foreach ($html_imgs as $img) {
                        $imgsrc = attrLinkValues($url, $img, 'attributes', 'src');
                        if ( $imgsrc )
                            $data[] = [
                                          'htmlurl' => attrLinkValues($url, $img, 'attributes', 'src', true),
                                          'url'     => $imgsrc,
                                      ];
                    }
                }

                // JS
                $html_scripts = $_scraper->get($html, 'script');
                if ( $html_scripts ) {
                    foreach ($html_scripts as $script) {
                        $scriptsrc = attrLinkValues($url, $script, 'attributes', 'src');
                        if ( $scriptsrc )
                            $data[] = [
                                          'htmlurl' => attrLinkValues($url, $script, 'attributes', 'src', true),
                                          'url'     => $scriptsrc,
                                      ];
                    }
                }

                $fullsitedata = [];
                $dirhost      = '';

                if ( $data ) {

                    $_downloader = new Downloader();
                    $_zip        = new Zip();
                    $parseurl    = parse_url($url);

                    $dirhost  = str_replace('.', '-', $parseurl['host']);
                    $dirhost .= '-' . uniqid();

                    $dirname  = 'websites' . DIRECTORY_SEPARATOR;
                    $dirname .= $dirhost;

                    $savehtml    = $html;
                    $downloadext = [];
                    $downloadfiles = [];
                    foreach ($data as $linkvalue) {

                        if ( !in_array($linkvalue['url'], $downloadfiles) ) { 

                            $downloadfiles[] = $linkvalue['url'];

                            $linkinfo = pathinfo($linkvalue['url']);
                            $linkext  = @$linkinfo['extension'];
                            $basename = $linkinfo['basename'];

                            if ( $linkext ) {
                                $filename = $linkext . DIRECTORY_SEPARATOR . $basename;
                                $fullsitedata[$linkext][] = [
                                                                'basename'  => $basename,
                                                                'link'      => $linkvalue['url'],
                                                                'directory' => $filename
                                                            ];

                                // FOR DEMO PORPUSES ONLY
                                // YOU CAN REMOVE THIS CONDITION IF YOU ALREADY PURCHASE THIS PROJECT
                                // if ( !in_array($linkext, $downloadext) || DEBUG === false ) { 

                                    $savehtml  = str_replace($linkvalue['htmlurl'], $filename, $savehtml);
                                    $savepath  = storage_path($dirname . DIRECTORY_SEPARATOR . $linkext);
                                    $savepath .= DIRECTORY_SEPARATOR . $basename;
                                    $_downloader->save($linkvalue['url'], $savepath);
                                    $downloadext[] = $linkext;

                                // } // END OF DEMO PORPUSES ONLY CONDITION

                            } // if ( $linkext )

                        } // if ( !in_array($linkvalue['url'], $downloadfiles) )

                    } // foreach ($data as $linkvalue)

                    $storage_dir = storage_path($dirname);

                    $index_path  = $storage_dir . DIRECTORY_SEPARATOR . 'index.html';
                    $_downloader->saveContent($savehtml, $index_path);


                    $zip      = new ZipArchive();
                    $zipname  = storage_path('zip');
                    $zipname .= DIRECTORY_SEPARATOR . $dirhost . '.zip';
                    $zip->open($zipname, ZipArchive::CREATE | ZipArchive::OVERWRITE);

                    $files = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($storage_dir),
                        RecursiveIteratorIterator::LEAVES_ONLY
                    );

                    if ( $files ) {
                        foreach ($files as $name => $file)
                        {
                            if ( !$file->isDir() )
                            {
                                $filePath     = $file->getRealPath();
                                $relativePath = substr($filePath, strlen($storage_dir) + 1);
                                $zip->addFile($filePath, $relativePath);
                            }
                        }
                    }
                    $zip->close();

                    $recursivedir = new RecursiveDirectoryIterator($storage_dir, RecursiveDirectoryIterator::SKIP_DOTS);
                    $gfiles       = new RecursiveIteratorIterator($recursivedir, RecursiveIteratorIterator::CHILD_FIRST);
                    foreach($gfiles as $gfile) {
                        if ($gfile->isDir())
                            rmdir($gfile->getRealPath());
                        else 
                            unlink($gfile->getRealPath());
                    } // foreach($gfiles as $gfile)
                    rmdir($storage_dir);

                } // if ( $data )

                $response['data'] = [
                                        'files' => $fullsitedata,
                                        'zip'   => $dirhost
                                    ];


        }
    }

}

if (!headers_sent())
    header('content-type: application/json; charset=utf-8');

echo json_encode($response);

?>