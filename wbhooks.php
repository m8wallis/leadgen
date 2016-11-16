<?php

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'abc1234') {
    echo $challenge;
}
else{
    echo "Error, wrong validation token";
}

?>
