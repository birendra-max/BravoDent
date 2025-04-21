<?php
// the message
$msg = "this is a testing mail.";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
if(mail("support@intechdc.com","Hello Papi",$msg))
  echo "mail sent";
?>