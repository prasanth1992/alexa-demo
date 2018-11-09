<?php
$rawJSON = file_get_contents('php://input');
$EchoReqObj = json_decode($rawJSON);
/* Launch Request*/
if($EchoReqObj->request->type=="LaunchRequest"){
  $text = "Welcome to Ivanti Services";
  $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false));
  echo json_encode($array);
 }
 /* End of launch request*/
 /* Active incidents*/ 
  else if($EchoReqObj->request->intent->name =="active"){
  
    $ch = curl_init('http://ec2-34-228-218-131.compute-1.amazonaws.com/AlexaIvanti/Api/Incident/GetCountOfTodaysIncident');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
    	  $text=curl_exec($ch);
	 $nextText=json_decode($text,true);
	  if($nextText['Message']='An error has occurred.'){
		  $text="Services are Down, Please check after some time";
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>"Today incidents". $text),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$text));
    echo json_encode($array);
	  }
	  else{
	  $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>"Today incidents". $text),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$text));
    echo json_encode($array);
	  }
    
	 
   
    curl_close($ch);
 }
 /* End of Active Incidents*/
 /* Status of Incidents*/

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
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>"Incidents". $text),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$text));
    echo json_encode($array);
    curl_close($ch);
   
   
}
  echo json_encode($array);
}

/* End of Status of Incidents*/

 /*Create Incident*/


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

  if($EchoReqObj->request->intent->slots->description->name=="description"){
	$text="please enter description of Incident";
    $description_array = array ('version' => '1.0','response' => array ('outputSpeech' => array ('type' => 'PlainText','text' => $text,),'directives' => 
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
	$entire_string=json_encode(array_merge(json_decode($subject_string, true),json_decode($description_string, true)));
	/* Curl For ADD Incident*/
	
	$ch = curl_init('http://ec2-34-228-218-131.compute-1.amazonaws.com/AlexaIvanti/Api/Incident/AddIncident');                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $entire_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json'                                                                              
																			  
	));                                                                                                                   
                                                                                                                     
    $result = curl_exec($ch);
    curl_close($ch);                                                                                                                     


    $entire_array= array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$result),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$result));
    echo json_encode($entire_array);                                                                                 

}
		echo json_encode($description_array);
	 }                                                                          

}
		echo json_encode($array);
	 }
	
	

}

/* End of Create Incident*/
/* Stop Intent*/
 else if($EchoReqObj->request->intent->name =="AMAZON.StopIntent"){
    $text = "Hmm Ok ";
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>true));
    echo json_encode($array);
 }
/* End of Stop Intent*/
/* Repeat Intent*/
else if($EchoReqObj->request->intent->name =="AMAZON.RepeatIntent"){
    $text = $EchoReqObj->session->attributes->lastSpeech;
    $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false));
    echo json_encode($array);
 }
 /* End ofRepeat Intent*/
 /* Today Summary*/
   else if($EchoReqObj->request->intent->name =="todaysummary"){
  
    $ch = curl_init('http://ec2-34-228-218-131.compute-1.amazonaws.com/AlexaIvanti/Api/Incident/GetSummaryOfTodaysIncident');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
    $text=curl_exec($ch);
  
    if($text = ""){
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
  /* End of Today Summary*/
  /* Close incident*/
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
/* End of close incident*/
/* Incident Description*/
 else if($EchoReqObj->request->intent->name == "incidentDescription"){
    $text="Enter incident id";
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
/* End of incident Description*/
/* Services */

  else if($EchoReqObj->request->intent->name == "services"){
  $text = "I had Ivanti Services, create incident,Add Incident,Incident status,Active incidents,Incident summary, Incident details";

  
  $array = array("version"=>"1.0","response"=>array("outputSpeech"=>array("type"=>"PlainText","text"=>$text),"shouldEndSession"=>false),"sessionAttributes"=>array("lastSpeech"=>$text));
  echo json_encode($array);
}

/* End of Services*/

?>
