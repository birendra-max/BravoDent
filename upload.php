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
    $em = $_SESSION['email'];
    $que = "SELECT MAX(orderid) as max_order FROM orders WHERE clientid = '$em'";
    $res = mysqli_query($bd, $que);

    $row = mysqli_fetch_assoc($res);
    $oid;
    if (!empty($row['max_order'])) {
      $oid = $row['max_order'] + 1;
    } else {
      $oid = 1000;
    }


    $continue = strtolower($name[1]) == 'zip' ? true : false;
    if (!$continue) {
      $message = "The file you are trying to upload is not a .zip file. Please try again.";
      exit;
    }

    $path = 'api/files/';
    $targetdir = $path . $_SESSION['id'] . '_' . $oid;
    $targetzip = $targetdir . '/' . $filename;

    if (!is_dir($targetdir)) {
      mkdir($targetdir, 0777, true);
    }

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


    $filenoext = basename($filename, '.zip');
    $ffname = "$targetdir/$filenoext/$filenoext.xml";

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

    $clientid = $_SESSION['email'];
    $tdate = date("d-M-Y h:i:sa");
    $labname = $_SESSION['labname'];
    $sqq = "INSERT INTO orders(orderid,clientid,unit,product_type,tooth,message,created_at,status,fname,labname,filename,crown,model,framework,abu,custom,tduration,flag,status_ch_date)VALUES('$oid','$clientid','$unit','$items','$t','$orderComment','$tdate','New','$fname','$labname','$fileName','Crown','N','N','N','N','Next Day',0,'$tdate')";


    $fileName = "log";
    $logFileName = $fileName . '_' . date('d-M-Y') . '.sql';
    $logFilePath = 'logfiles/' . $logFileName;
    $logMessage = $sqq . ";\n";
    file_put_contents($logFilePath, $logMessage, FILE_APPEND);


    mysqli_query($bd, $sqq);
    echo "$oid|$filename|$items|$unit|$t|$orderComment";
  } else {
    echo "File is format is not correct.";
  }
}
