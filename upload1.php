<?php
include 'connect.php';
$imageData = '';
$flag = 0;
// $_SESSION['userid']="1";
// $_SESSION['labname']="papi lab";
// $_SESSION['email']="abc@gmail.com";
if (isset($_FILES['file']['name']) and isset($_SESSION['userid'])) {
  $flag = 0;

  $filename = "";
  $source = "";
  $type = "";
  $fileName = $_FILES['file']['name'];
  $filename = $_FILES["file"]["name"];
  $source = $_FILES["file"]["tmp_name"];
  $type = $_FILES["file"]["type"];
  $fname = basename($_FILES["file"]["name"]);
  $okay = false;

  $name = explode(".", $filename);
  $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
  foreach ($accepted_types as $mime_type) {
    if ($mime_type == $type) {
      $okay = true;
      break;
    }
  }
  if ($okay) {



    $continue = strtolower($name[1]) == 'zip' ? true : false;
    if (!$continue) {
      $message = "The file you are trying to upload is not a .zip file. Please try again.";
    }

    /* PHP current path */
    $path = 'api/files/';  // absolute path to the directory where zipper.php is in
    $ffname = $path . $name[0] . "/" . $name[0] . '/' . $name[0] . ".xml";
    $filenoext = basename($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
    $filenoext = basename($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)

    $targetdir = $path . $filenoext; // target directory
    $targetzip = $path . $filename; // target zip file

    /* create directory if not exists', otherwise overwrite */
    /* target directory is same as filename without extension */



    if (file_exists($targetdir)) {
      echo "File is already uploaded." . $filename;
      $flag = 1;
    } else
    /* here it is really happening */ {

      if (move_uploaded_file($source, $targetzip)) {
        $zip = new ZipArchive();
        $x = $zip->open($targetzip);  // open the zip file to extract
        if ($x === true) {
          $zip->extractTo($targetdir); // place in the directory with same name  
          $zip->close();

          //unlink($targetzip);
        }
        $message = "Your .zip file was uploaded and unpacked.";
      } else {
        $message = "There was a problem with the upload. Please try again.";
      }
      $succes = "";
      $unit = 0;
      $t = "";
      $orderComment = "";
      $items = "";
      //echo $ffname;
      if (!empty($ffname) and file_exists($ffname)) {

        $unit = 0;
        $t = "";
        $xml2 = $xml = simplexml_load_file($ffname);
        foreach ($xml->Object[0]->Object as $value) {

          if ($value->attributes()->name == 'ToothElementList') {

            foreach ($value->List->Object as $tuth) {
              foreach ($tuth->Property as $pr) {
                //echo $pr->attributes()->name;
                if ($pr->attributes()->name == "ToothNumber") {

                  if ($unit == 0)
                    $t = $pr->attributes()->value;
                  else
                    $t = $t . "," . $pr->attributes()->value;
                  $unit++;
                }
              }
            }
          }
        }
        //echo "hello ". $unit. ", hello";

        $orderComment = (string) simplexml_load_file($ffname)->xpath('//Property[@name="OrderComments"]')[0]['value'];
        $items = (string) simplexml_load_file($ffname)->xpath('//Property[@name="Items"]')[0]['value'];

        $succes = $fileName . "," . $t . " " . $unit;
      } else {
        $succes = $fileName . "0,0, 0";
      }

      $tdate = date("d-M-Y h:i:sa");

      $resulth = mysqli_query($bd, "SELECT max(id) as sm FROM orders");
      $rowh = mysqli_fetch_array($resulth);
      $orderid = $rowh['sm'];
      if ($orderid >= 0 and $orderid < 10)
        $oid = $_SESSION['userid'] . "0000" . $orderid;
      elseif ($orderid >= 10 and $orderid < 100)
        $oid = $_SESSION['userid'] . "000" . $orderid;
      elseif ($orderid >= 100 and $orderid < 1000)
        $oid = $_SESSION['userid'] . "00" . $orderid;
      elseif ($orderid >= 1000 and $orderid < 10000)
        $oid = $_SESSION['userid'] . "0" . $orderid;
      elseif ($orderid >= 10000)
        $oid = $_SESSION['userid'] . $orderid;
      $clientid = $_SESSION['email'];
      $tdate = date("d-M-Y h:i:sa");
      $labname = $_SESSION['labname'];
      $sqq = "INSERT INTO orders(orderid,clientid,unit,product_type,tooth,message,created_at,status,fname,labname,filename,crown,model,framework,abu,custom,tduration,flag,status_ch_date)VALUES('$oid','$clientid','$unit','$items','$t','$orderComment','$tdate','New','$fname','$labname','$fileName','Crown','N','N','N','N','Next Day',0,'$tdate')";


      $fileName = "log";
      // Set log file name with current date
      $logFileName = $fileName . '_' . date('d-M-Y') . '.sql';

      // Log file path (you can customize the path where you want to store the log)
      $logFilePath = 'logfiles/' . $logFileName;

      // Message to log (including the SQL query)
      $logMessage = $sqq . ";\n"; // Add a newline for better readability

      // Write the log message to the log file
      file_put_contents($logFilePath, $logMessage, FILE_APPEND);


      mysqli_query($bd, $sqq);
      echo "$oid|$filename|$items|$unit|$t|$orderComment";
    }
  } else {
    echo "File is format is not correct.";
  }
}
