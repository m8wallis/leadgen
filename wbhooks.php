<?php
//include 'whatcounts-master/src/whatcounts_required.php';

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'abc12345') {
    echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);
error_log(print_r($input, true));

//getlead function
function getLead($leadgen_id,$user_access_token) {
    //fetch lead info from FB API
    $graph_url= 'https://graph.facebook.com/v2.5/'.$leadgen_id."?access_token=".$user_access_token;
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

//Token - you must generate this in the FB API Explorer - tip: exchange it to a long-lived (valid 60 days) token
$user_access_token = 'EAATeansT7awBABOrV8ZAbUZBkrLvReWJqmSJ8rAZAZC2qLlV1fNpbpqJesZAR6CrggYJqws5RLkZAStbBUgdzd2';

//Get the lead info
$lead = getLead($leadgen_id,$user_access_token);//get lead info

foreach($lead as $attr=>$val) {
    error_log(print_r($attr),true);
    error_log(print_r($val),true);
}
?>
