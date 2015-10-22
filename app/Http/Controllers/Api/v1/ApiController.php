<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class ApiController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public $outputType = 'application/json';
    public $httpCode = 500;
    public $errorType = null;
    public $errorMessage = null;
    public $output = [];

    /**
     * Construct the API call be bootstrapping response, request and metadata
     *
     * @author Jamie Howard <jhoward@rethinkgroup.org>
     */
    public function __construct() {
        $this->output = [
            "response" => [
                "error" => null
            ],
            "request" => [
                "url" => $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                "method" => $_SERVER['REQUEST_METHOD'],
                "timestamp" => time()
            ],
            "data" => null
        ];
    }


    /**
     * Build the API response
     *
     * @author Jamie Howard <jhoward@rethinkgroup.org>
     */
    public function response() {

        if (is_null($this->errorType)):
            $this->httpCode = 200;
        elseif (! is_null($this->errorType)):
            $this->output['response']['error'] = array(
                'type' => $this->errorType,
                'message' => $this->errorMessage
            );
        else:
            $this->httpCode = 500;
            $this->output['response']['error'] = array(
                'type' => 'api_error',
                'message' => 'General failure'
            );
        endif;

        http_response_code($this->httpCode);
        header("Content-type: " . $this->outputType);
        echo json_encode($this->output);
        exit();
    }

    /**
     * Build the API response
     *
     * @author Jamie Howard <jhoward@rethinkgroup.org>
     * @param string $type Type of error to be returned
     * @param string $message Custom/specific error message to be returned
     * @return Bool
     */
    public function set_error($type = null, $message = null)
    {
        // TODO: This can probably handled with constants and an array - jhoward
        if ($type == 'invalid_request_error'): // If malformed request
            $this->httpCode = 400;
        elseif ($type == 'authentication_failed'): // If authentication failure
            $this->httpCode = 401;
            header('WWW-Authenticate: Basic realm="Materials API"');
        elseif ($type == 'third_party_error'): // If third-party failure
            $this->httpCode = 409;
        elseif ($type == 'object_not_found'): // If the object was not found
            $this->httpCode = 404;
        else:
            $this->httpCode = 500;
        endif;

        $this->errorType = $type;

        if ( ! is_null($message)):
            $this->errorMessage = $message;
        else:
            // This is to help us catch generic server errors if they arise - jhoward
            $this->errorMessage = 'Server error';
        endif;

        return true;
    }

}
