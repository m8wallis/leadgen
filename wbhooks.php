<?php
//include 'whatcounts-master/src/whatcounts_required.php';

//use FacebookAds\Object\Lead;
//$form = new Lead(<LEAD_ID>);
//$form->read();

//pulls email address out of the form, puts it into the $email variable
//preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i", $form, $email);

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'abc12345') {
    echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);
error_log(print_r($input, true));

?>
