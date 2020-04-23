<?php

$result = -1;
$successPage = "https://domain.com/success.html";
$errorPage = "https://domain.com/error.html";

$permitted = "https://www.domain.com/testcontact.php";
$permitted2  = "https://domain.com/testcontact.php";
$calling = $_SERVER['HTTP_REFERER'];

//Verify referer, this prevents abuse
if ($calling == $permitted || $calling == $permitted2) {

//build out email message body
  $Body = "";
  $Body .= "Name: ";
  $Body .= $_POST['Name'];
  $Body .= "\n";
  $Body .= "Email: ";
  $Body .= $_POST['EmailFrom'];
  $Body .= "\n";
  $Body .= "Phone: ";//
  $Body .= $_POST['Phone'];
  $Body .= "\n";
  $Body .= "Message: ";
  $Body .= "\n";
  $Body .= "\n";
  $Body .= $_POST['Comments'];
  $Body .= "\n";
  $Body .= "\n";
  $Body .= "================";
  $Body .= "\n";
  $Body .= "Website lead from online form, please contact.";

//set email message headers, this sets the from address
  // $headers  = 'MIME-Version: 1.0' . "\r\n";
  //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= "From: contacttest@domain.com\r\n";
//setup email recipient
  $emailaddress = "amclint@gmail.com";
   
//send out email message
$subject = "Website Form Lead";
  $status = mail ($emailaddress, $subject, $Body, $headers);
  
//Check result of send
  if ($status) {
	//Set result flag and message, if populated redirect user to success page.
	$result = 1;
	$resultMsg = "Your request has been submitted successfully.";
	if (strlen($successPage) > 0) {
        //print "<meta http-equiv=refresh content=0;URL=".$successPage.">";
        header("Location: ".$successPage);
        die();
	}
  } else {
    	//Set result flag and message, if populated redirect user to error page.
	$result = 0;
	$resultMsg = "There was a problem submitting your request, please try again.";
	
	if (strlen($errorPage) > 0) {
        //print "<meta http-equiv=refresh content=0;URL=".$errorPage.">";
        header("Location: ".$errorPage);
        die();
	}
  }
} else {
    //show URL back to user if they are trying to post against this form from an invalid referer
    print $_SERVER['HTTP_REFERER'];
}

?>
<html>
<head>
<title>Test</title>
<!--
Configured to support recaptcha, to make it work you will need to signup and configure the key at the bottom of the page
-->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
     function IsRecapchaValid()
     {
          var res = grecaptcha.getResponse();
          if (res == "" || res == undefined || res.length == 0) {
            alert('You must enter the checkbox');
            return false;
          }      
          return true;
     }
</script>
</head>
<body>
  <div id="copy">
    <h3>Contact Us
    </h3>
	<?php if ($result == 0) {
		print "<p style='color:red'>".$resultMsg."</p>";
	} else if ($result == 1) {
		print "<p style='color:green'>".$resultMsg."</p>";
	}
	?>
    <form action="testcontact.php" method="post" name="contact">
	<input type="hidden" name="FormAction" value="1">
          Name:
          <input name="Name" id="Name" type="text" size="38" maxlength="38" required style="background:white">
          <br>
          <br>
          Email:
          <input type="text" name="EmailFrom" id="EmailFrom" size="38" maxlength="38" required maxlength="38" style="background:white">
          <br><br>
          Phone:
          <input type="tel" name="Phone" size="30" id="Phone" maxlength="30" style="background:white">
          <br>
          <br>
          Comments: <br>
          <textarea name="Comments" id="Comments" cols="65" rows="7" wrap="soft" required style="background:white"></textarea>
          <br>
          <br>
          <div class="g-recaptcha" data-sitekey="RECAPTCHA_KEY_GOES_HERE" align="center"></div>
          <br>
          <br>
          <input type="submit" value="Submit" class="submit" onclick="return IsRecapchaValid()">        
          <br>
    </form>
</div>
</body>
</html>
