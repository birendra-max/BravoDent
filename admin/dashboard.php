<?php 
function Total_row($bd,$status)
{
    if($status=="All")
    
    $sql="SELECT count(*) as cnt FROM orders";
    else
    $sql="SELECT count(*) as cnt FROM orders where  status='$status'";
    $res=mysqli_query($bd,$sql);
    $row=mysqli_fetch_array($res);
    return $row['cnt'];
}
?>


<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
             <a href="allmember.php" class="small-box-footer">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>
                  <?php 
                          $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM user");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $tclient=$rowh['sm'];   ?>  
                </h3>
                <p>Total Client</p>
              </div>
              <div class="icon">
                <i class="fas fa-warning"></i>
              </div>
              
            </div>
            </a>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="allmemberd.php" class="small-box-footer">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php 
                          $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM user1");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $tdesigner=$rowh['sm'];   ?>                        
                </h3>

                <p>Total Designer</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-friends"></i>
              </div>              
            </div>
            </a>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="allmember.php" class="small-box-footer">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>  <?php 
                          $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM user where acpinid<>0");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $tactclient=$rowh['sm'];   ?> 
                    </h3>

                <p>Total Active Client</p>
              </div>
              <div class="icon">
               <i class="fas fa-users"></i>
              </div>
             
            </div>
            </a>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="allmemberd.php" class="small-box-footer">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>
                 <?php 
                          $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM user1 where acpinid<>0");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $tactclient=$rowh['sm'];   ?> 
                </h3>

                <p>Total Active Designer</p>
              </div>
              <div class="icon">
               <i class="fas fa-users"></i>
              </div>
              
            </div>
            </a>
          </div>
          <!-- ./col -->
        </div>

           <!-- Small boxes (Stat box) -->
        <div class="row">

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="allmember.php" class="small-box-footer">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>
                 <?php 
                          $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM user where acpinid=0");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $tactclient=$rowh['sm'];   ?> 
                </h3>

                <p>Total Deactive Client</p>
              </div>
              <div class="icon">
               <i class="fas fa-users"></i>
              </div>
             </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="allmemberd.php" class="small-box-footer">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>
               <?php 
                          $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM user1 where acpinid=0");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $tactclient=$rowh['sm'];   ?>                 
                </h3>

                <p>Total Deactive Designer</p>
              </div>
              <div class="icon">
               <i class="fas fa-users"></i>
              </div>
               
            </div>
            </a>
          </div>
          <!-- ./col -->      
        </div>
        
        <div class="row">
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="index10.php" class="small-box-footer">
            <div class="small-box " style="background-color: rgba(10,10,250,0.7) !important">
              <div class="inner">
                <h3>
             <?php 

                        $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE status='New'");
                        $rowh = mysqli_fetch_assoc($resulth);
                        echo $rowh['sm'];   ?>        
                </h3>

                <p>New Cases</p>
              </div>
              <div class="icon">
               
              </div>
               <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="index2.php" class="small-box-footer">
            <div class="small-box" style="background-color: rgba(10,10,250,0.7) !important">
              <div class="inner">
                <h3>
                <?php 
                        
                        $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE  tduration='Rush' and status='New'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];   ?>   
                </h3>
                <p>Rush Hour Cases</p>
              </div>
              <div class="icon">
               
              </div>
               <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="index5.php" class="small-box-footer">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php 
                        
                        $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE tduration='Same Day'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];   ?>                         
                </h3>

                <p>6 Hour Cases</p>
              </div>
              <div class="icon">
                
              </div>
               <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="index3.php" class="small-box-footer">
            <div class="small-box" style="background-color: rgba(10,10,250,0.7) !important">
              <div class="inner">
                <h3>  <?php
                 $tdate=date('d-M-Y');
                 $cc=0;
                    $resulth = mysqli_query($bd,"SELECT created_at FROM orders");
                        while($rowh = mysqli_fetch_array($resulth))
                        {

                          if (strtotime($tdate)==strtotime(date("d-M-Y",strtotime($rowh['created_at']))))
                            $cc++;                          
                        }
                        echo $cc;
                    ?> 
                      
                    </h3>

                <p>Today Cases</p>
              </div>
              <div class="icon">
               
              </div>
              <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="pagination.php?type=<?php echo base64_encode('Hold') ?>" class="small-box-footer">
            <div class="small-box" style="background-color: rgba(10,10,250,0.7) !important">
              <div class="inner">
                <h3>
                <?php 

                        $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE status='Hold'");
                        $rowh = mysqli_fetch_assoc($resulth);
                        echo $rowh['sm'];   ?>     
                </h3>

                <p>Case On Hold</p>
              </div>
              <div class="icon">
               
              </div>
              <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

            <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="index55.php" class="small-box-footer">
            <div class="small-box"  style="background-color: rgba(102,102,255,0.8) !important">
              <div class="inner">
                <h3 style="color: #000 !important">  <?php
                     $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE status='progress'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];
                    ?>
                      
                    </h3>

                <p style="color: #000 !important">In Progress</p>
              </div>
              <div class="icon">
                <i class="fas fa-tasks"></i>
              </div>
               <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
           <div class="col-lg-3 col-6">
            <!-- small box -->
             <a href="pagination.php?type=<?php echo base64_encode('Cancel') ?>" class="small-box-footer">
            <div class="small-box" style="background-color: rgba(102,102,255,0.8) !important">
              <div class="inner">
                <h3 style="color: #000 !important">
                   <?php
                    $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE status='Cancel'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];
                    ?>    
                </h3>

                <p style="color: #000 !important">Canceled Case</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill-alt"></i>
              </div>
              <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="pagination.php?type=<?php echo base64_encode('Completed') ?>" class="small-box-footer">
            <div class="small-box" style="background-color: #FFF !important">
              <div class="inner">
                <h3 style="color: #000 !important"> <?php
                      $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE status='Completed'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];
                    ?>    
                 
               </h3>

                <p style="color: #000 !important">Completed Cases</p>
              </div>
              <div class="icon">
                <i class="fas fa-dollar-sign"></i>
              </div>
               <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


        </div>

        <div class="row">
          <!-- Left col -->
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="index8.php" class="small-box-footer">
            <div class="small-box" style="background-color: rgba(102,102,255,0.8) !important">
              <div class="inner">
                <h3 style="color: #000 !important"><?php
                     $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders WHERE status='QC Required'");
                        $rowh = mysqli_fetch_array($resulth);
                        echo $rowh['sm'];

                    ?>             
               </h3>
                <p style="color: #000 !important">QC Required</p>
              </div>
              <div class="icon">
               <i class="fas fa-money-bill-alt"></i>
              </div>
               <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
           <div class="col-lg-3 col-6">
            <!-- small box -->
             <a href="pagination.php?type=<?php echo base64_encode('All') ?>" class="small-box-footer">
                <div class="small-box" style="background-color: #FFF !important">
                  <div class="inner">
                    <h3 style="color: #000 !important"><?php
                     $tdate=date('d-M-Y', strtotime('-1 day', strtotime(date("d-M-Y"))));
                      $resulth = mysqli_query($bd,"SELECT count(*) as sm FROM orders");
                            $rowh = mysqli_fetch_array($resulth);
                            echo $rowh['sm'];
                        ?> 
                                  
                  </h3>

                    <p style="color: #000 !important">All Cases</p>
                  </div>
                  <div class="icon">
                      <i class="fas fa-tasks"></i>
                  </div>
                   <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="index9.php" class="small-box-footer">
            <div class="small-box" style="background-color: #FFFFFF !important">
              <div class="inner"  style="color: #000;font-weight: bold;">
                <h3>  <?php
                 $tdate=date('d-M-Y', strtotime('-1 day', strtotime(date("d-M-Y"))));
                 $cc=0;
                    $resulth = mysqli_query($bd,"SELECT created_at FROM orders");
                        while($rowh = mysqli_fetch_array($resulth))
                        {

                          if (strtotime($tdate)==strtotime(date("d-M-Y",strtotime($rowh['created_at']))))
                            $cc++;                          
                        }
                        echo $cc;
                    ?> 
                      
                    </h3>

                <p  style="color: #000;font-weight: bold;">Yesterday Cases</p>
              </div>
               <div class="icon">
                  <i class="fas fa-tasks"></i>
              </div>
              <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

       
        </div>

