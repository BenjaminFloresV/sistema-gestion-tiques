<?php

namespace SistemaTique\API\BaseController;

class BaseController
{

    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function sendOutput(string $data, $httpHeaders = array())
    {

        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }

        echo $data;
        exit;
    }

    /**
     * Get query string params.
     *
     * @return array
     */

    protected function getQueryStringParams()
    {
        return parse_str($_SERVER['QUERY_STRING'], $query);
    }

    protected function fixBadUnicode($str) {
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})/mi", fn($m) => chr(hexdec($m[1])).chr(hexdec($m[2])).chr(hexdec($m[3])).chr(hexdec($m[4])), $str);
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})/mi", fn($m) => chr(hexdec($m[1])).chr(hexdec($m[2])).chr(hexdec($m[3])), $str);
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})/mi", fn($m) => chr(hexdec($m[1])).chr(hexdec($m[2])), $str);
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})/i", fn($m) => chr(hexdec($m[1])), $str);
        return $str;
    }



}