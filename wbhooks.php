<?php
use FacebookAds\Object\Lead;
$form = new Lead(<LEAD_ID>);
// $form->read();

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'abc12345') {
    echo $challenge;
}

?>
