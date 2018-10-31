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

  
else if($EchoReqObj->request->intent->name == "CreateObject"){
	 
	if($EchoReqObj->request->intent->slots->subject->name=="subject"){
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
   
	$subject = array("subject" => $var);                                                                    
	$subject_string = json_encode($subject); 

    $array1= array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$subject_string),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$result));
    echo json_encode($array1);                                                                                 

}
	 }
if($EchoReqObj->request->intent->slots->description->name=="description"){
		 $text="please enter description of Incident";
    $array = array ('version' => '1.0','response' => array ('outputSpeech' => array ('type' => 'PlainText','text' => $text,),'directives' => 
    array (
      0 => 
      array (
        'type' => 'Dialog.ElicitSlot',
        'slotToElicit' => 'description',
      ),
    ),
    'shouldEndSession' => false,
    ),
    );
   if ($var=$EchoReqObj->request->intent->slots->description->value){
   
	$description = array("description" => $var);                                                                    
	$description_string = json_encode($description); 

    $array2= array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$description_string),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$result));
    echo json_encode($array2);                                                                                 

}
		 
		 
	 }
	
	     

  echo json_encode($array);
}





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
