<?php
//include 'whatcounts-master/src/whatcounts_required.php';

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'abc12345') {
    echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);
error_log(print_r($input, true));


//require('FacebookRequest.php');
//require('Url/FacebookUrlManipulator.php');
//require('Authentication/AccessToken.php');
//require('FileUpload/FacebookFile.php');
//require('FileUpload/FacebookVideo.php');
//require('Http/RequestBodyMultipart.php');
//require('Http/RequestBodyUrlEncoded.php');
//require('Exceptions/FacebookSDKException.php');
//require('Http/RequestBodyInterface.php');

//include 'Facebook/Facebook.php';
//include 'Facebook/FacebookRequest.php';
//require 'Facebook.php';




//required
//use Facebook\Authentication\AccessToken;
//use Facebook\Url\FacebookUrlManipulator;
//use Facebook\FileUpload\FacebookFile;
//use Facebook\FileUpload\FacebookVideo;
//use Facebook\Http\RequestBodyMultipart;
//use Facebook\Http\RequestBodyUrlEncoded;
//use Facebook\Exceptions\FacebookSDKException;
//use Facebook\Http\RequestBodyInterface;

//require 'FacebookRequest.php';
//use Facebook\FacebookRequest;
/* PHP SDK v5.0.0 */
/* make the API call */
//$request = new FacebookRequest(
//  $session,
//  'GET',
//  '/1370448819645868/subscriptions'
//);
//$response = $request->execute();
//$graphObject = $response->getGraphObject();
/* handle the result */
//print_r($graphObject);
?>
