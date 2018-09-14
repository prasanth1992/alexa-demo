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

  else if($EchoReqObj->request->intent->name == "status"){
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
 if ($var=$EchoReqObj->request->intent->slots->id->value){
   
    $ch = curl_init('http://ec2-34-228-218-131.compute-1.amazonaws.com/AlexaIvanti/Api/Incident/GetStatusOfIncident/'.$var);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
    $text=curl_exec($ch);
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>"Incident Status". $text),"shouldEndSession"=>false));
    echo json_encode($array);
    curl_close($ch);
   
   
}
  echo json_encode($array);
}
 else if($EchoReqObj->request->intent->name == "CreateObject"){
    $text="please enter Subject of Incident";
    $array = array ('version' => '1.0','response' => array ('outputSpeech' => array ('type' => 'PlainText','text' => $text,),'directives' => 
    array (
      0 => 
      array (
        'type' => 'Dialog.ElicitSlot',
        'slotToElicit' => 'subject',
      ),
    ),
    'shouldEndSession' => false,
    ),
    );
 if ($var=$EchoReqObj->request->intent->slots->subject->value){
   
$data = array("subject" => $var);                                                                    
$ch = json_encode($data);                                                                                   
                                                                                                                     

    
 
  
   
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$ch),"shouldEndSession"=>false));
    echo json_encode($array);
   
   
}
  echo json_encode($array);
}






?>
