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
else if($EchoReqObj->request->intent->name =="status"){
$text = "Provide ID froom github";
$array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"directives"=>array("type"=>"Dialog.ElicitSlot","slotToElicit"=>"id"),"shouldEndSession"=>false));
echo json_encode($array);
  if($value=$EchoReqObj->request->intent->slots->id->value){
  $text = "Welcome $value";
$array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false));
echo json_encode($array);
  }
  else{
  $text = "in else";
$array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false));
echo json_encode($array);
  }
}

?>
