<?php 
function Total_row($bd,$status,$clid)
{
    if($status=="All")
    
    $sql="SELECT count(*) as cnt FROM orders where clientid='$clid'";
    else
    $sql="SELECT count(*) as cnt FROM orders where  clientid='$clid' and status='$status'";
    $res=mysqli_query($bd,$sql);
    $row=mysqli_fetch_array($res);
    return $row['cnt'];
}
?>


   <style type="text/css">
  .small-box-footer:hover
  {
    box-shadow: 8px 8px 8px 4px rgba(0,0,0,0.5);
    transition: all 0.2s ease-in-out;
  }
  .info-box
  {
    background-color: #343A40 !important;
    color: #FFF !important;
  }
 
</style>
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
              <li class="breadcrumb-item active"></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   <!-- Small boxes (Stat box) -->
        <div class="row">

            <div class="col-lg-3 col-6" >
              <a href="index.php">
              <div class="info-box" style="background-color: #343A40 !important">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">New Cases</span>
                <span class="info-box-num
                ber">
                   <?php 

                        $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE clientid='$em' and status='New'");
                        $rowh = mysqli_fetch_assoc($resulth);
                        echo $rowh['sm'];   ?>  
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
              </a>
            <!-- /.info-box -->
          </div>

            <div class="col-lg-3 col-6">
              <a href="index3.php">
              <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">In Progress</span>
                <span class="info-box-num
                ber">
                   <?php
                     $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE clientid='$em' and status='progress'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];
                    ?>   
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
           <div class="col-lg-3 col-6">
              <a href="pagination.php?type=<?php echo base64_encode('Cancel') ?>&clientid=<?php echo base64_encode($em)?>">
              <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Canceled Case</span>
                <span class="info-box-num
                ber">
                    <?php
                    $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE clientid='$em' and status='Cancel'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];
                    ?>      
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
       
            <div class="col-lg-3 col-6">
              <a href="pagination.php?type=<?php echo base64_encode('Completed') ?>&clientid=<?php echo base64_encode($em)?>">
              <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tasks"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Completed Cases</span>
                <span class="info-box-num
                ber">
                   <?php
                      $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE clientid='$em' and status='Completed'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];
                    ?>              
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- ./col -->
        </div>


           <!-- Small boxes (Stat box) -->
        <div class="row">      


            <div class="col-lg-3 col-6">
              <a href="index2.php">
              <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Rush Cases</span>
                <span class="info-box-num
                ber">
                   <?php 
                        
                        $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE clientid='$em' and tduration='Rush' and status='New'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];   ?>     
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>

         
         
          <div class="col-lg-3 col-6">
              <a href="index7.php">
              <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-bell"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">QC Required</span>
                <span class="info-box-num
                ber">
                  <?php
                     $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE clientid='$em' and status='QC Required'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];

                    ?>             
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
               <div class="col-lg-3 col-6">
              <a href="pagination.php?type=<?php echo base64_encode('Hold') ?>&clientid=<?php echo base64_encode($em)?>">
              <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Case On Hold</span>
                <span class="info-box-num
                ber">
                    <?php
                    $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE clientid='$em' and status='Hold'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];
                    ?>     
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
         
           <div class="col-lg-3 col-6">
              <a href="pagination.php?type=<?php echo base64_encode('All') ?>&clientid=<?php echo base64_encode($em)?>">
              <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">All Cases</span>
                <span class="info-box-num
                ber">
                 <?php
                 $tdate=date('d-M-Y', strtotime('-1 day', strtotime(date("d-M-Y"))));
                  $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE clientid='$em'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];
                    ?>            
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>

       
        </div>


           <!-- Small boxes (Stat box) -->
        <div class="row">    

           <div class="col-lg-3 col-6">
              <a href="index8.php">
              <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-sun"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Yesterday's Cases</span>
                <span class="info-box-num
                ber">
                 <?php
                 $tdate=date('d-M-Y', strtotime('-1 day', strtotime(date("d-M-Y"))));
                 $cc=0;
                    $resulth = mysqli_query($bd,"SELECT created_at FROM orders WHERE clientid='$em'");
                        while($rowh = mysqli_fetch_array($resulth))
                        {

                          if (strtotime($tdate)==strtotime(date("d-M-Y",strtotime($rowh['created_at']))))
                            $cc++;                          
                        }
                        echo $cc;
                    ?>            
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>

                   <div class="col-lg-3 col-6">
              <a href="index10.php">
              <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-bell"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Today's Cases</span>
                <span class="info-box-num
                ber">
                  <?php
                  $tdate=date('d-M-Y');
                 $cc=0;
                    $resulth = mysqli_query($bd,"SELECT created_at FROM orders WHERE clientid='$em'");
                        while($rowh = mysqli_fetch_array($resulth))
                        {

                          if (strtotime($tdate)==strtotime(date("d-M-Y",strtotime($rowh['created_at']))))
                            $cc++;                          
                        }
                        echo $cc;
                    ?>           
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
         
         </div>