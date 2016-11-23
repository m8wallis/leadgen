<?php
//include whatcounts php script
include 'whatcounts-master/src/whatcounts_required.php';

//FB Webhook validation
$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'abc12345') {
    echo $challenge;
}

//getlead function
function getLead($leadgen_id,$user_access_token) {
    //fetch lead info from FB API
    $graph_url= 'https://graph.facebook.com/v2.8/'.$leadgen_id."?access_token=".$user_access_token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $graph_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $output = curl_exec($ch); 
    curl_close($ch);

    //work with the lead data
    $leaddata = json_decode($output);
    $lead = [];
    for($i=0;$i<count($leaddata->field_data);$i++) {
        $lead[$leaddata->field_data[$i]->name]=$leaddata->field_data[$i]->values[0];
    }
    return $lead;
}
    
//Take input from Facebook webhook request
$input = json_decode(file_get_contents('php://input'),true);
$leadgen_id = $input["entry"][0]["changes"][0]["value"]["leadgen_id"];

//FB API Token - you must generate this in the FB API Explorer - tip: exchange it to a long-lived (valid 60 days) token - done
$user_access_token = 'EAATeansT7awBALJqOiA0L4M5BzO4cW8xawHak7f2FRd3ZB7jwWEklci9gsDVPiRCMOa83sZAWYXcaZCcppb2UoVF2CZBMiXAiLcpdgQKsL0yjOFfk1gaEeUBeKygZA1mXtjA9l2HWTbxwMNVOGzvJ';

//Get the lead info using function defined above
$lead = getLead($leadgen_id,$user_access_token);

//extract the data from Facebook to new variables that were pre-definied in FB ($email and $full_name and $date_of_birth)
extract($lead, EXTR_SKIP);

//initialize whatcounts variable with API credentials
$whatcounts = new ZayconWhatCounts\WhatCounts( skullcandy, etyline14322 );

//get whatcounts realm settings
$realm = $whatcounts->getRealmSettings();

//Prep new subscriber for whatcounts
$subscriber = new ZayconWhatCounts\Subscriber;
$subscriber
    ->setFirstName(full_name);
    ->setEmail(email);
    ->setForceSub(false);
    ->setFormat(99);
    ->setOverrideConfirmation(false);
    ->setListId(115);

$subscribers = $whatcounts->subscribe($subscriber);

//Print the variables to the error log to show it's working
error_log(print_r($email, true));
error_log(print_r($full_name, true));

?>
