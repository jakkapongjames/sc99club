<?php
require 'vendor/autoload.php';
$client = new \GuzzleHttp\Client();
$response = $client->request('POST', 'https://otp.thaibulksms.com/v1/otp/request',
[
 'form_params' => [
 'key' => '{{app_key}}',
 'secret' =>{app_secret},
 'msisdn' => '{{number phone}}'
 ]
]);
try {
 if($response->getStatusCode()){
 echo $response->getBody();
 }else{
 echo "Error Code: ".$response->getStatusCode();
 }
} catch (Exception $e) {
 echo 'Caught exception: ', $e->getMessage(), "\n";
}
?>