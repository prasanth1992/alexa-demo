<?php
$rawJSON = file_get_contents('php://input');
$EchoReqObj = json_decode($rawJSON);
if($EchoReqObj->request->type=="LaunchRequest"){
$text = "Welcome World This is my First Https app using webhook";
$array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false));
echo json_encode($array);
}
else if($EchoReqObj->request->intent->name =="New"){
$text = "Welcome World This New";
$array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false));
echo json_encode($array);
}
else if($EchoReqObj->request->intent->name =="latest"){
$text = "Welcome World This latest";
$array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false));
echo json_encode($array);
}

?>
