<?php

require_once __DIR__.'/../../config.php';
use \PHPUnit\Framework\TestCase;
use SistemaTique\API\UserController;

class UserControllerTest extends TestCase
{

    public function isValidJson($string) {

        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /** @test  */
    public function getAll()
    {
        // Create curl resource
        $client = curl_init();

        // Set curl options
        curl_setopt_array($client, [
            CURLOPT_URL => BASE_URL.'/api/users/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);

        // $output contains the output string
        $output = curl_exec($client);
        curl_close($client);

        $httpcode = curl_getinfo($client, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($client, CURLINFO_CONTENT_TYPE);

        // Check if the response is a valid JSON
        $this->assertEquals(200, $httpcode);
        $this->assertEquals('application/json', $contentType);
        $this->assertEquals(true, $this->isValidJson($output));

    }
}