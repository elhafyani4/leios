<?php

function is_php(string $phpVersion)
{
    $version = PHP_VERSION;
    $version_parts = explode(".", $version);
    $in_version_parts = explode(".", $version);
    for ($i = 0; $i < sizeof($in_version_parts); $i ++) {
        if(!isset($version_parts[$i])){
            return true;
        }
        
        if ($version_parts[$i] == $in_version_parts) {
            continue;
        }

        if ($version_parts[$i] >= $in_version_parts) {
            return true;
        } else {
            return false;
        }
    }

    return false;
}