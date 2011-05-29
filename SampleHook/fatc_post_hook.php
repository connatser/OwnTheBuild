<?php
	$gitHubJSON = $_POST['payload'];
	$gitHubPayload = json_decode(stripslashes($gitHubJSON));
  	$prodFlag = 'PROD';  
	$commits = '';
	
	foreach($gitHubPayload->{'commits'} as $commit) {
		$message = $commit->{'message'};
	}
	
	if (strlen(strstr($message,$prodFlag))>0){
		sendGitHubHookMail();
	}	
?>
  
<?php  
	function sendGitHubHookMail(){
		require_once "Mail.php";
		$from = "Hello from MyCompany <myEmail@myDomain.com>";
		$to = "myClient@theirDomain.com";
		$subject = "An update has been made to MyProject";
		$body = "We just thought you would like to know that MyProject has been updated, please let us know if you have any questions.";
		$host = "mail.myDomain.com";
		$username = "myEmail@myDomain.com";
		$password = "myPassword";
	  
		$headers = array ('From' => $from,
		'To' => $to,
		'Subject' => $subject);
		$smtp = Mail::factory('smtp',
		array ('host' => $host,
		  'auth' => true,
		  'username' => $username,
		  'password' => $password));
	  	
		$mail = $smtp->send($to, $headers, $body);
	  
		if (PEAR::isError($mail)) {
			echo("<p>" . $mail->getMessage() . "</p>");
		} else {
			echo("<p>Message successfully sent!</p>");
	  	}
  	}
?>