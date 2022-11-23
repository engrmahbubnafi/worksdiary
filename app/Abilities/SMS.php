<?php
namespace App\Abilities;

use App\Abilities\Interfaces\ISMS;
use Illuminate\Database\Eloquent\Model;

class SMS implements ISMS
{
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Model $data)
    {
        $this->data = $data;
    }

    private function getConfigUrl()
    {
        return config('conf.smsApi.host');
    }

    // Send SMS.
    public function send()
    {
        // Generate URL-encoded query string.
        $queryString = http_build_query($this->data);

        // Initialize a new session and return a cURL handle.
        $curlHandle = curl_init();

        // Set options for cURL transfer.
        // Set the URL to fetch.
        curl_setopt($curlHandle, CURLOPT_URL, $this->getConfigUrl());
        // Set regular HTTP post true.
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        // Set the full data to post in a HTTP "POST" operation.
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $queryString);
        // Do not check the Common Name field or, Subject Alternate Name field in SSL peer certificate.
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 0);
        // Stop cURL from verifying the peer's certificate by making it false.
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);

        // An array of HTTP header fields to set.
        $httpHeaders = [
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Cache-Control: no-cache",
            "Connection: keep-alive",
            "Content-Type: application/x-www-form-urlencoded",
            "cache-control: no-cache",
        ];
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $httpHeaders);

        // Execute the given cURL session.
        curl_exec($curlHandle);
    }

}
