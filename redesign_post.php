<?php
include 'connect.php';
include 'testmail.php';

if (isset($_POST['submit2'])) {
	// Capture User's IP Address
	function getUserIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			return $_SERVER['REMOTE_ADDR'];
		}
	}
	$user_ip = getUserIP(); // Get User IP Address
	$log_file = "file.log"; // Define the log file name

	// Ensure the log file exists, then write the IP address with a timestamp
	$log_entry = date("Y-m-d H:i:s") . " - IP: " . $user_ip . PHP_EOL;
	file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);

	$tdate=date("d-M-Y h:i:sa");
	$orderid = isset($_POST['redesignorderid']) ? htmlspecialchars($_POST['redesignorderid']) : 0;
	$linkurl = isset($_POST['linkurl']) ? filter_var(trim($_POST['linkurl']), FILTER_SANITIZE_URL) : '';
	$em = isset($_SESSION['email']) ? filter_var(trim($_SESSION['email']), FILTER_SANITIZE_EMAIL) : '';
	$status = isset($_POST['status']) ? htmlspecialchars(trim($_POST['status']), ENT_QUOTES, 'UTF-8') : '';
	$msg = isset($_POST['msg']) ? htmlspecialchars(trim($_POST['msg']), ENT_QUOTES, 'UTF-8') : '';

	// Secure database connection
	$em = mysqli_real_escape_string($bd, $em);


	$blacklist_patterns = ['\$\(\d+', 'phpinfo\(\)', 'system\(', 'exec\(', 'print\(eval', 'popen\(', 'proc_open\('];

	foreach ($blacklist_patterns as $pattern) {
		if (preg_match('/' . $pattern . '/i', $orderid)) {
			// Log the attack
			$file = "attack_logs.txt";
			$log_entry = date("Y-m-d H:i:s") . " - Suspicious Input: " . $orderid . " - IP: " . getUserIP() . PHP_EOL;
			file_put_contents($file, $log_entry, FILE_APPEND | LOCK_EX);
			
			die("Potential attack detected.");
		}
	}
	$sqlem="SELECT * FROM user where em='$em'";
$res_sqlem=mysqli_query($bd,$sqlem);
$row_sqlem=mysqli_fetch_array($res_sqlem);


	$sql="UPDATE orders set status='New', tduration='$status' where orderid='$orderid'";
	mysqli_query($bd,$sql);
	$sql2="INSERT INTO chatbox (orderid,msg,user_type,created_at,attachment,userid,filename) VALUES('$orderid','$msg','user','$tdate','','$em','')";
	mysqli_query($bd,$sql2);

	       $to = 'bravodent@bravodentdesigns.com';
    $em=$_SESSION['email'];
          $resulth = mysqli_query($bd,"SELECT * FROM user where em='$em'");
      $rowh = mysqli_fetch_array($resulth);
      $cname=$rowh['name'];
      $subject = ' Name ('.$_SESSION['labname'].') ('.($i+1).') RUSH Order Recieved : ('.$foid.'-'.$loid.')';

      $headers  = "From: " . strip_tags("bravodent@bravodentdesigns.com") . "\r\n";
      $headers .= "Reply-To: " . strip_tags("bravodent@bravodentdesigns.com") . "\r\n";
      $headers .= "CC: bravodent@bravodentdesigns.com\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

      $message = '<p><strong>You have recieve the redesign case. Orderid : '. $orderid .'</strong> </p>';
	  sendEmail($email, $subject, $message);

      
	if (mysqli_query($bd,$sql)) {
		echo "<script> alert('$orderid is updated successfully.');window.location='$linkurl'</script>";
	}
	else
	{
		echo "<script>   alert('Selected case of status can not be change. Plese try after sometime.');window.location='$linkurl'</script>";
	}
}

?>