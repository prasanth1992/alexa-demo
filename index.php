<?php
$rawJSON = file_get_contents('php://input');
$EchoReqObj = json_decode($rawJSON);
$text = "Welcome World This is my First Https app using webhook";
$array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text)));
echo json_encode($array);
if($EchoReqObj->request->intent->name=="New"){
$text = "Welcome New";
$array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text)));
echo json_encode($array);
}
?>
