<?php

defined('DEBUG') or define('DEBUG', true);

/* FUNCTION FOR http://localhost
if (!function_exists('url'))
{
    function url($str = null, $http = 'http')
    {

        $url = $http . '://' . $_SERVER['HTTP_HOST'] . '/';

        if ( $str !== null )
            $url .= $str;

        return $url;
    }
}
*/
// BACK

// FUNCTION FOR http://localhost/path/
if (!function_exists('url'))
{
function url()
{
    $url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
    $url .= '://' . $_SERVER['HTTP_HOST'];
    $url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    return $url;
    }
}

// $ROOT_URL = url();

if ( !function_exists('storage_path') )
{
    function storage_path($dir = null)
    {

        $dirname = __DIR__ . DIRECTORY_SEPARATOR . 'storage';

        if ( $dir !== null )
            $dirname .= DIRECTORY_SEPARATOR . $dir;

        if ( !file_exists($dirname) )
            mkdir($dirname, 0777, true);

        return $dirname;
    }
}

if ( !function_exists('pre') )
{
    function pre($str, $return = false)
    {
        echo '<pre>';
        return print_r($str, $return);
        echo '</pre>';
    }
}

if ( !function_exists('viaStrpos') )
{
    function viaStrpos($haystack, $needle, $num = null)
    {
        if ( is_integer($num) )
            return strpos($haystack, $needle) === $num;

        return strpos($haystack, $needle) !== false;
    }
}

if ( !function_exists('attrLinkValues') )
{
    function attrLinkValues($url, $collection, $index_1, $index_2 = null, $getresult = false)
    {

        $result = @$collection[$index_1];
        if ( $index_2 )
            $result = @$result[$index_2];

        if ( $getresult === true ) 
            return $result;

        if ( $result ) {
            $link = httpImage($result, $url);
            if ( !filter_var($link, FILTER_VALIDATE_URL ) === false)
                return $link;
        }

        return null;

    }
}

if ( !function_exists('linkExtension') )
{
    function linkExtension($link, $empty_response = '_', $type = PHP_URL_PATH)
    {

        $path = parse_url($link, $type);
        if ( $path ) {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            if ( $extension ) 
                return $extension;
        }

        return $empty_response;

    }
}

if ( !function_exists('getAllLinks') )
{
    function getAllLinks($html)
    {

        $httplinks = [];
        preg_match_all('/https?\:\/\/[^\"\' ]+/i', $html, $httplinks);
        return reset($httplinks);

    }
}

if ( !function_exists('httpImage') )
{
    function httpImage($url, $main_url = null)
    {

        if ( viaStrpos($url, 'http', 0) )
            return $url;
        elseif ( viaStrpos($url, '//', 0) ) 
            return 'http:' . $url;
        else {

            $dirname = parse_url($main_url, PHP_URL_SCHEME);
            $dirname .= '://';
            $dirname .= parse_url($main_url, PHP_URL_HOST);
            $dirname .= parse_url($main_url, PHP_URL_PATH);
            $dirname = rtrim($dirname, '/');
            
            if ( viaStrpos($url, './', 0) ) {
                $url  = substr($url, 2);
                return $dirname . '/' . $url;
            }

            if ( viaStrpos($url, '/', 0) ) {
                $url  = substr($url, 1);
                return $dirname . '/' . $url;
            }

            if ( viaStrpos($url, '../') ) {

                $dirconcat    = '';
                $path_dirname = explode('/', $dirname);
                $substr_count = substr_count($url, '../');

                for ($i=0; $i < $substr_count; $i++) { 
                    array_pop($path_dirname);
                    $dirconcat .= '../';
                }
                $dirurl   = implode('/', $path_dirname);
                $basename = str_replace($dirconcat, '', $url);

                return $dirurl . '/' . $basename;
            }

            $data  = parse_url($main_url, PHP_URL_SCHEME);
            $data .= '://';
            $data .= parse_url($main_url, PHP_URL_HOST);
            $data .= '/' . ltrim(parse_url($url, PHP_URL_PATH), '/');
            
            return $data;

        }

        return null;

    }
}