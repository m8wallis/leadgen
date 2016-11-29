<?php
//Start SkullCandy customization section
//This section is the first customized section.  The next starts at line 65, the final at line 95.
$fb_verify_token = 'abc12345' //put in your facebook verify_token here
$fb_user_access_token = 'EAATeansT7awBALJqOiA0L4M5BzO4cW8xawHak7f2FRd3ZB7jwWEklci9gsDVPiRCMOa83sZAWYXcaZCcppb2UoVF2CZBMiXAiLcpdgQKsL0yjOFfk1gaEeUBeKygZA1mXtjA9l2HWTbxwMNVOGzvJ' //put in your facebook user access token here - you must generate this in the FB API Explorer - tip: exchange it to a long-lived (valid 60 days) token 
$wc_api_realm = 'skullcandy' //no need to change this, it's already populated with your whatcounts API realm
$wc_api_password = 'etylinel4322' //no need to change this unless you change your api password for whatcounts
//End SkullCandy customization section
    
//Begin code to be left alone -------->
//Require composer's autoloader for zayconwhatcounts
require 'vendor/autoload.php';

//include whatcounts php script
include 'whatcounts-master/src/whatcounts_required.php';

//FB Webhook validation
$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === $fb_verify_token) {
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

//FB API Token - you must generate this in the FB API Explorer - tip: exchange it to a long-lived (valid 60 days) token
$user_access_token = $fb_user_access_token;

//Get the lead info using function defined above
$lead = getLead($leadgen_id,$user_access_token);

//extract the data from Facebook to new variables that were pre-defined in FB ($email and $full_name and $date_of_birth)
extract($lead, EXTR_SKIP);
//---> end code to be left alone

//Map the Facebook variables to WhatCounts-ready variables
//For this section, you want to replace the examples below with the name of the variables you setup on the facebook form.
//For instance, if you have "email" as the field you're pulling from facebook, the "email" line below would look like this:
//$fb_email = $email;
//So leave the first field alone (as it's mapped later on in this script, but replace the second variable with the name of the Facebook variable you're using.
$fb_first_name = $firstname;
$fb_last_name = $lastname;
$fb_email = $email;
//this area commented out for fields you're not using.  If you choose to use these fields, uncomment them here and then at their corresponding lines starting at line 95
//$fb_address1 = $address1;
//$fb_address2 = $address2;
//$fb_city = $city;
//$fb_state = $state;
//$fb_zip = $zip;
//$fb_country = $country;
//$fb_phone = $phone;
//$fb_fax = $fax;
//$fb_company = $company;

//begin code to be left alone --->
//initialize whatcounts variable with API credentials
$whatcounts = new ZayconWhatCounts\WhatCounts($wc_api_realm,$wc_api_password);

//get whatcounts realm settings
$realm = $whatcounts->getRealmSettings();
//---> end code to be left alone

//Prep new subscriber for whatcounts
$subscriber = new ZayconWhatCounts\Subscriber;
$subscriber
    ->setFirstName("$fb_first_name");
$subscriber
    ->setLastName("$fb_last_name");
$subscriber
    ->setEmail("$fb_email");
//This section commented out as unnecessary fields- if you want to gather any of this data via your FaceBook form feel free to uncomment these.
//$subscriber
//    ->setAddress1("$fb_address1");
//$subscriber
//    ->setAddress2("$fb_address2");
//$subscriber
//    ->setCity("$fb_city");
//$subscriber
//    ->setState("$fb_state");
//$subscriber
//    ->setZip("$fb_zip");
//$subscriber
//    ->setCountry("$fb_country");
//$subscriber
//    ->setPhone("$fb_phone");
//$subscriber
//    ->setFax("$fb_fax");
//$subscriber
//    ->setCompany("$fb_company");
//End commented out section
$subscriber
    ->setForceSub(false);
$subscriber
    ->setFormat(99);
$subscriber
    ->setOverrideConfirmation(false);
$subscriber
    ->setListId(115);

$subscribers = $whatcounts->subscribe($subscriber);
?>
