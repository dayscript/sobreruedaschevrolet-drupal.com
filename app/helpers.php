<?php
function cleanUrl($url)
{
    $lastpoint = strrpos($url,".");

    $url = str_slug(substr($url,0,$lastpoint)).substr($url,$lastpoint);
    return $url;

}