<?php

$result = -1;
$successPage = "https://domain.com/success.html";
$errorPage = "https://domain.com/error.html";

$permitted = "https://www.domain.com/testcontact.php";
$permitted2  = "https://domain.com/testcontact.php";
$calling = $_SERVER['HTTP_REFERER'];

if ($calling == $permitted || $calling == $permitted2) {

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

  // $headers  = 'MIME-Version: 1.0' . "\r\n";
  //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= "From: contacttest@domain.com\r\n";
  $emailaddress = "amclint@gmail.com";
   
  $status = mail ($emailaddress, "Website Form Lead", $Body, $headers);
  
  if ($status) {
	$result = 1;
	$resultMsg = "Your request has been submitted successfully.";
	if (strlen($successPage) > 0) {
        //print "<meta http-equiv=refresh content=0;URL=".$successPage.">";
        header("Location: ".$successPage);
        die();
	}
  } else {
    $result = 0;
	$resultMsg = "There was a problem submitting your request, please try again.";
	
	if (strlen($errorPage) > 0) {
        //print "<meta http-equiv=refresh content=0;URL=".$errorPage.">";
        header("Location: ".$errorPage);
        die();
	}
  }
} else {
    print $_SERVER['HTTP_REFERER'];
}

?>
<html>
<head>
<title>Test</title>
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
          <div class="g-recaptcha" data-sitekey="6LcZEpEUAAAAAOSAq_BefQYHo0up7r5UOMaVu9F7" align="center"></div>
          <br>
          <br>
          <input type="submit" value="Submit" class="submit" onclick="return IsRecapchaValid()">        
          <br>
    </form>
</div>
</body>
</html>
