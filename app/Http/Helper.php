<?php
namespace App\Http;


class Helper
{
    public function getReadableFileSize($size, $precision = 2) {
        if ( $size > 0 ) {
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    }
    return $size;
    }
}
