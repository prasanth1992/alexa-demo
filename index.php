<?php
$rawJSON = file_get_contents('php://input');
$EchoReqObj = json_decode($rawJSON);
if($EchoReqObj->request->type=="LaunchRequest"){
  $text = "Welcome to Ivanti Services";
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
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>"Today incidents". $text),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$text));
    echo json_encode($array);
    curl_close($ch);
 }

  else if($EchoReqObj->request->intent->name == "status"){
    $text="Enter the incident id";
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
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>"Today incidents". $text),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$text));
    echo json_encode($array);
    curl_close($ch);
   
   
}
  echo json_encode($array);
}
// Test of Create object

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
$data_string = json_encode($data);                                                                                   
$ch = curl_init('http://ec2-34-228-218-131.compute-1.amazonaws.com/AlexaIvanti/Api/Incident/CreateIncident');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json'                                                                              
                                                                          
));                                                                                                                   
                                                                                                                     
    $result = curl_exec($ch);
    curl_close($ch);                                                                                                                     

    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$result),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$result));
    echo json_encode($array);
  
}
  echo json_encode($array);
}


//end of test

 else if($EchoReqObj->request->intent->name =="AMAZON.StopIntent"){
    $text = "Hmm Ok ";
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>true));
    echo json_encode($array);
 }

else if($EchoReqObj->request->intent->name =="AMAZON.RepeatIntent"){
    $text = $EchoReqObj->session->attributes->lastSpeech;
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false));
    echo json_encode($array);
 }
   else if($EchoReqObj->request->intent->name =="todaysummary"){
  
    $ch = curl_init('http://ec2-34-228-218-131.compute-1.amazonaws.com/AlexaIvanti/Api/Incident/GetSummaryOfTodaysIncident');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
    $text=curl_exec($ch);
  
    if($text==""){
      $text="No summary Today";
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$text));
    echo json_encode($array);
       curl_close($ch);
    }
    else{
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$text));
    echo json_encode($array);
    curl_close($ch);
    }
  
  }
  else if($EchoReqObj->request->intent->name == "closeincident"){
    $text="Enter the close incident id";
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

    $ch = curl_init('http://ec2-34-228-218-131.compute-1.amazonaws.com/AlexaIvanti/Api/Incident/CloseIncident/'.$var);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
    $text=curl_exec($ch);
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$text));
    echo json_encode($array);
    curl_close($ch);
   
   
}
  echo json_encode($array);
}
 else if($EchoReqObj->request->intent->name == "incidentDescription"){
    $text="Enter Description incident id";
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

    $ch = curl_init('http://ec2-34-228-218-131.compute-1.amazonaws.com/AlexaIvanti/Api/Incident/GetDescriptionOfIncident/'.$var);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
    $text=curl_exec($ch);
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$text));
    echo json_encode($array);
    curl_close($ch);
   
   
}
  echo json_encode($array);
}


?>
