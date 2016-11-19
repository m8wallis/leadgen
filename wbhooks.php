<?php
//include 'whatcounts-master/src/whatcounts_required.php';

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'abc12345') {
    echo $challenge;
}

//$input = json_decode(file_get_contents('php://input'), true);
//error_log(print_r($input, true));

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
    error_log(print_r($leaddata, true));
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
$user_access_token = '1370448819645868|sgLw85cgMuAKTaYm1p975DAVBnI';

//Get the lead info
$lead = getLead($leadgen_id,$user_access_token);//get lead info

//$fbfullname = $lead["field_data"][0]["values"][0];
//$fbemail = $lead["field_data"][0]["email"][0];

//foreach($lead as $attr=>$val) {
//    error_log(print_r($attr, true));
//    error_log(print_r($val, true));


//Create an email with the lead info
$mail="<html><body><h2>New lead</h2><blockquote>";
$mail.="Lead id: ".$leadgen_id."<br>";
//$mail.="Email: ".$fbemail."<br>";
//$mail.="Name: ".$fbfullname."<br>";
$mail.="Lead dump: ".$lead."<br>";
foreach($lead as $attr=>$val) {
    $mail.=$attr.": ".$val."<br>";
}
$mail.="</blockquote></body></html>";
error_log(print_r($mail, true));

$string=implode(",",$lead);
error_log(print_r($string, true));

?>
