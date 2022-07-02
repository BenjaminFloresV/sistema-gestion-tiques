<?php

namespace SistemaTique\API\BaseController;

use SistemaTique\Helpers\Helpers;
use SistemaTique\Helpers\NewLogger;

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



    protected function getPUTdata(): array
    {
        $logger = NewLogger::newLogger('HELPERS_GETPUTDATA');
        $putfp = fopen('php://input', 'r');
        $putdata = [];
        while($data = fread($putfp, 1024))
            // Incov converts string to requested character enconding
            // $decoded = iconv( 'ISO-8859-1', 'UTF-8', urldecode( $encoded ) );
            // In this case, when we use iconv produces an unexpected results, so we just use urldecode only
            $cleanData = urldecode($data);
            $logger->debug('Actual data recivied', array('data' => $data));
            $entities = explode('&', $cleanData);
            if( $entities ) {
            foreach ($entities as $entity) {
                $values = explode('=', $entity);

                $putdata[$values[0]] = $values[1] ;
            }
        }

        fclose($putfp);
        return $putdata;
    }



}