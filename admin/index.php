<?php
include 'header.php';
//$x='RSV9999';

 


?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <h1>
<?php
// Execute the 'df -h' command using shell_exec
$output = shell_exec('df -h');

// Split the output into lines
$lines = explode("\n", trim($output));

// Start the table
echo '<table class="table table-hover" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">';

// Output the header row (the first line)
echo '<tr>';
$headers = preg_split('/\s+/', array_shift($lines));
foreach ($headers as $header) {
    echo "<th>$header</th>";
}
echo '</tr>';

// Output each line as a row
foreach ($lines as $line) {
    echo '<tr>';
    $columns = preg_split('/\s+/', $line);
    foreach ($columns as $column) {
        echo "<td>$column</td>";
    }
    echo '</tr>';
}

// Close the table
echo '</table>';
?>
          </h1>
          
        <!-- Small boxes (Stat box) -->
       <?php include 'dashboard.php' ?>
           <!-- Small boxes (Stat box) -->
      

        

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Cases</span>
                <span class="info-box-number"><?php echo 0?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            
        
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="far fa-comment"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total </span>
                <span class="info-box-number">0</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.card -->

                 <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Client</h3>

                    <div class="card-tools">
                      <span class="badge badge-danger">New Client</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>

                  <div class="card-body p-0">
                    <ul class="users-list clearfix">

                      

                        <?php
                     
                       $sql="SELECT * FROM user limit 10";
                        $res=mysqli_query($bd,$sql);
                        while($row=mysqli_fetch_array($res))
                        {
                    
                           ?>
                             <li>
                                <?php 
                                if ($row['pic']=="" OR $row['pic']=="0") {                          
                                ?>
                                <img src="dist/img/avatar5.png" alt="User n" style="width:128px;height: 128px;">  
                                <?php
                                }else
                                {
                                  ?>
                                  <img src="../<?php echo $row['pic'] ?>" alt="User Image" style="width:128px;height: 128px;">  
                                  <?php
                                }
                                ?>
                                <a class="users-list-name" href="#"><?php echo $row['name'] ?></a>
                                <span class="users-list-date"><?php echo date("d-M-Y",strtotime($row['todaydate'])) ?></span>
                              </li>

                           <?php                           
                            
				                } 
				               
                  ?>
                     
                     
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer text-center">
                    <a href="allmember.php">View All Client</a>
                  </div>
                  <!-- /.card-footer -->
                </div>


            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">
            <!-- Map card -->
               <!-- TABLE: LATEST ORDERS -->
          <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Joining Of Designer</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>User ID</th>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Joinging Date</th>
                    </tr>
                    </thead>
                    <tbody>
                 

                    	  <?php
                   
                       $sql="SELECT * FROM user1 limit 10";
            $res=mysqli_query($bd,$sql);
            while($row=mysqli_fetch_array($res))
            {
                           ?>
                         <tr>
                             <td><?php echo $row['id'] ?></td>
                             <td><?php echo $row['name'] ?></td>
                             <td>  <?php 
                                  if ($row['acpinid']!=0) {
                                    ?>
                                <span class="badge badge-success">Activated</span>

                                    <?php
                                  }else
                                  {
                                  ?>
                                  <span class="badge badge-danger">Not Active</span>
                                  <?php
                                  }
                                  ?>
                              </td>                             
                             <td>
                               <div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo date("d-M-Y",strtotime($row['todaydate'])) ?></div>                               
                             </td>
                           </tr>

                           <?php                           
                            
				                } 
				              
                  ?>            
               
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                
                <a href="allmemberd.php" class="btn btn-sm btn-secondary float-right">View All Designer</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->

          

            
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


<?php
include 'footer.php';
?>