   <?php
    //session_start();
    include('connect.php');
	
	extract($_POST);

		$rq=mysqli_query($bd,"SELECT userid as mxid FROM user order by userid desc");
		$roww=mysqli_fetch_assoc($rq);
		$sss=$roww['mxid'];
		 $id="BRC".$sss;
		$tdate=date("d-M-Y");


		$rqc=mysqli_query($bd,"SELECT count(*) as cnt FROM user where em='$email'");
		$rowwc=mysqli_fetch_assoc($rqc);
		 $sssc=$rowwc['cnt'];
		if($sssc<1)
          {
		if(mysqli_query($bd,"INSERT INTO user(id,name,designation,em,mobile,labname,occlusion,password,status,todaydate,anatomy,pontic,remark,contact,acpinid,pic) VALUES('$id','$name','$designation','$email','$mobile','$labname','$occlusion','12345','active','$tdate','$anatomy','$pontic','$remark','$contact','0','')"))
          {
          

         
		?>
          <script>  
	    alert('Client is registered successfully  with BRAVODENT PRIVATE LIMITED.Your Login ID is <?php echo $email ?> and Default Password is 12345 . You can change your password after the login.');
	  window.location="new_client.php";
	</script>
      <?php
          }else
          {
          echo mysqli_error($bd);die;
        }
        }
		else
          {
		echo "<script>alert('This email ( $email ) is already registered.')</script>";    
        }
	?>
	 