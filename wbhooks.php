<?php
namespace Facebook;
include 'whatcounts-master/src/whatcounts_required.php';

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'abc12345') {
    echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);
error_log(print_r($input, true));

require_once('Facebook/Facebook.php');
require_once('Facebook/FacebookRequest.php');
require_once('Facebook/Url/FacebookUrlManipulator.php');
require_once('Facebook/Authentication/AccessToken.php');
require_once('Facebook/FileUpload/FacebookFile.php');
require_once('Facebook/FileUpload/FacebookVideo.php');
require_once('Facebook/Http/RequestBodyMultipart.php');
require_once('Facebook/Http/RequestBodyUrlEncoded.php');
require_once('Facebook/Exceptions/FacebookSDKException.php');
require_once('Facebook/Http/RequestBodyInterface.php');



//include 'Facebook/Facebook.php';
include 'Facebook/FacebookRequest.php';
use FacebookRequest;

//required
use Authentication\AccessToken;
use Url\FacebookUrlManipulator;
use FileUpload\FacebookFile;
use FileUpload\FacebookVideo;
use Http\RequestBodyMultipart;
use Http\RequestBodyUrlEncoded;
use Exceptions\FacebookSDKException;
use Http\RequestBodyInterface;


/* PHP SDK v5.0.0 */
/* make the API call */
$request = new FacebookRequest(
  $session,
  'GET',
  '/1370448819645868/subscriptions'
);
$response = $request->execute();
$graphObject = $response->getGraphObject();
/* handle the result */
print_r($graphObject);
?>
