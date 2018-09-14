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
else if($EchoReqObj->request->intent->name =="today"){
  
$ch = curl_init('http://ec2-34-228-218-131.compute-1.amazonaws.com/AlexaIvanti/Api/Incident/GetCountOfTodaysIncident');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$text=curl_exec($ch);
  $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>"Today incidents". $text),"shouldEndSession"=>false));
echo json_encode($array);
curl_close($ch);
}

else if($EchoReqObj->request->intent->name =="status"){
  $text="Enter the user id";
$array = array ('version' => '1.0','response' => array ('outputSpeech' => array ('type' => 'PlainText','text' => $text,),'directives' => 
    array (
      0 => 
      array (
        'type' => 'Dialog.ElicitSlot',
        'slotToElicit' => 'id',
      ),
    ),
    'shouldEndSession' => false,
  ),
);
  echo json_encode($array);
 if ($EchoReqObj->request->intent->slots->id->value == "123"){
 $text = "respose";
$array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false));
echo json_encode($array);
}
  else{
 $text = "error";
$array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false));
echo json_encode($array);
}
}




?>
