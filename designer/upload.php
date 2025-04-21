<?php
include 'connect.php';
$imageData = '';
$flag=0;
// $_SESSION['userid']="1";
// $_SESSION['labname']="papi lab";
$em= $_SESSION['email'];
if (isset($_FILES['file']['name'])) {
 $flag=0;
 $baby=0;
if(isset($_POST['baby_orderid']))
{
    // $_POST['baby_orderid'];
$baby=1;
}
  $filename="";
 $source="";
 $type="";
    $fileName = $_FILES['file']['name'];
   $filename = $_FILES["file"]["name"];
    $source = $_FILES["file"]["tmp_name"];
    $type = $_FILES["file"]["type"];

  /* PHP checking stl file */
 
$imageFileType1 = strtolower(pathinfo(basename($_FILES["file"]["name"]),PATHINFO_EXTENSION));

  if ($imageFileType1=="stl" OR $imageFileType1=="STL") {
     $success="";
    $flag=0;
    $target_dir1 = "../api/stl_files/";
    $target_file1 = $target_dir1 . basename($_FILES["file"]["name"]);
    $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
    $f_name=$_FILES["file"]["name"];
       if (file_exists($target_file1) ) {
          $flag=1;
          }
          if(isset($_POST['baby_orderid']))
          $flag=0;
          if($flag==0) {
             $f_name=$_FILES["file"]["name"];
           $fname2= $fname=basename($_FILES["file"]["name"],".stl"); 
            //$fname=substr($fname, 0,strrpos($fname,'_'));

           $oid="";


             //$fname=substr($fname, 0,strrpos($fname,'_'));
            $rr=mysqli_query($bd,"SELECT orderid FROM orders WHERE filename like '$fname%'");
            $row=mysqli_fetch_assoc($rr);
            if(!empty($row['orderid']))
              {
                $oid=$row['orderid'];
              }else{

             $fname=substr($fname, 0,strrpos($fname,'_'));
            $rr=mysqli_query($bd,"SELECT orderid FROM orders WHERE filename like '$fname%'");
            $row=mysqli_fetch_assoc($rr);
            if(!empty($row['orderid']))
              {
                $oid=$row['orderid'];
              }
            else
            {
              $fname=substr($fname, 0,strrpos($fname,'_',strrpos($fname,'_')-1));
              $rr=mysqli_query($bd,"SELECT orderid FROM orders WHERE filename like '$fname%'");
              $row=mysqli_fetch_assoc($rr);
              if(!empty($row['orderid']))
                {
                  $oid=$row['orderid'];
                }else
                {
              $rr=mysqli_query($bd,"SELECT orderid FROM orders WHERE filename like '$fname2%'");
              $row=mysqli_fetch_assoc($rr);
              $oid=$row['orderid'];
                }

            }
          }

            if (!empty($oid)) {
              if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file1)) {
                $orderid=$oid;
                if(isset($_POST['baby_orderid']))
                $orderid=$_POST['baby_orderid'];
                $tdate=date("d-M-Y h:i:sa");

                mysqli_query($bd,"INSERT INTO orders_stl_files(orderid,filename,created_at,userid) VALUES('$orderid','$f_name','$tdate','$em')");
                $rr=mysqli_query($bd,"SELECT count(*) as cnt FROM orders_finished WHERE orderid ='$orderid'");
                $row=mysqli_fetch_assoc($rr);

                $fileName = "log";         
                // Set log file name with current date
                $logFileName = $fileName . '_' . date('d-M-Y') . '.sql';

                // Log file path (you can customize the path where you want to store the log)
                $logFilePath = 'logfiles/' . $logFileName;
                $sqq="INSERT INTO orders_stl_files(orderid,filename,created_at,userid) VALUES('$orderid','$f_name','$tdate','$em')";
                // Message to log (including the SQL query)
                $logMessage = $sqq . ";\n"; // Add a newline for better readability

                // Write the log message to the log file
                file_put_contents($logFilePath, $logMessage, FILE_APPEND);

                if($row['cnt']>0)
                {
                  mysqli_query($bd,"UPDATE orders SET status='Completed',status_ch_date='$tdate' where orderid ='$orderid'");
                  $fileName = "log";         
                  // Set log file name with current date
                  $logFileName = $fileName . '_' . date('d-M-Y') . '.sql';

                  // Log file path (you can customize the path where you want to store the log)
                  $logFilePath = 'logfiles/' . $logFileName;
                  $sqq="UPDATE orders SET status='Completed',status_ch_date='$tdate' where orderid ='$orderid'";
                  // Message to log (including the SQL query)
                  $logMessage = $sqq . ";\n"; // Add a newline for better readability

                  // Write the log message to the log file
                  file_put_contents($logFilePath, $logMessage, FILE_APPEND);

                }
                $success="STL File is uploaded successfully : ".$f_name;
              }else
              {
                $success="STL File can not be saved at this time, try again : ".$f_name;
              }
              
            }else
            {
               $success="STL file not found like this : ".$f_name;
            }
          }else
          {
            $success="STL File is already uploaded : ".$f_name;
          }
          echo $success;
  }else
      {
  // end of stl file updation

  // checking finished files

  if ($imageFileType1=="zip" OR $imageFileType1=="ZIP") {
    $success="";
  $flag=0;
  $target_dir2 = "../api/finished_files/";
  $target_file2 = $target_dir2 . basename($_FILES["file"]["name"]);
  $f_name=$_FILES["file"]["name"];
  if (file_exists($target_file2) ) {
  $flag=1;
  }
   if(isset($_POST['baby_orderid']))
          $flag=0;
  if($flag==0) {
    $f_name=$_FILES["file"]["name"];
    $fname=basename($_FILES["file"]["name"]);
    $rr=mysqli_query($bd,"SELECT orderid FROM orders WHERE filename like '$fname%'");
    $row=mysqli_fetch_assoc($rr);
    if (!empty($row['orderid'])) {
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file2)) {
        $orderid=$row['orderid'];
        if(isset($_POST['baby_orderid']))
        $orderid=$_POST['baby_orderid'];
        $tdate=date("d-M-Y h:i:sa");
        mysqli_query($bd,"INSERT INTO orders_finished(orderid,finished_file,created_at,userid) VALUES('$orderid','$f_name','$tdate','$em')");
         $rr=mysqli_query($bd,"SELECT count(*) as cnt FROM orders_stl_files WHERE orderid ='$orderid'");
              $row=mysqli_fetch_assoc($rr);

              $fileName = "log";         
                  // Set log file name with current date
                  $logFileName = $fileName . '_' . date('d-M-Y') . '.sql';

                  // Log file path (you can customize the path where you want to store the log)
                  $logFilePath = 'logfiles/' . $logFileName;
                  $sqq="INSERT INTO orders_finished(orderid,finished_file,created_at,userid) VALUES('$orderid','$f_name','$tdate','$em')";
                  // Message to log (including the SQL query)
                  $logMessage = $sqq . ";\n"; // Add a newline for better readability

                  // Write the log message to the log file
                  file_put_contents($logFilePath, $logMessage, FILE_APPEND);


              if($row['cnt']>0)
              {
                mysqli_query($bd,"UPDATE orders SET status='Completed',status_ch_date='$tdate' where orderid ='$orderid'");

                $fileName = "log";         
                // Set log file name with current date
                $logFileName = $fileName . '_' . date('d-M-Y') . '.sql';

                // Log file path (you can customize the path where you want to store the log)
                $logFilePath = 'logfiles/' . $logFileName;
                $sqq="UPDATE orders SET status='Completed',status_ch_date='$tdate' where orderid ='$orderid'";
                // Message to log (including the SQL query)
                $logMessage = $sqq . ";\n"; // Add a newline for better readability

                // Write the log message to the log file
                file_put_contents($logFilePath, $logMessage, FILE_APPEND);

              }
        $success="Finished File is uploaded successfully : ".$f_name;
      }else
      {
        $success="Finished File can not be saved at this time, try again : ".$f_name;
      }
      
    }else
    {
       $success="Finished file not found like this : ".$f_name;
    }
  }else
  {
    $success="Finished File is already uploaded : ".$f_name;
  }
  echo $success;
}else
{
  echo "File format not matched";
}

// end of stl file updation
    
}
}

