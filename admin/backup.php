<?php
include 'header.php';
?>
<style>
    .loader {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
      margin: 0 auto;
    }

    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Backup </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Backup</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Backup</h3>
                    </div>
                    <!-- /.card-header -->
                    <?php 
                       function roundsize($size){
    $i=0;
    $iec = array("B", "Kb", "Mb", "Gb", "Tb");
    while (($size/1024)>1) {
        $size=$size/1024;
        $i++;}
    return(round($size,1)." ".$iec[$i]);
  }
             //  echo  substr(roundsize( disk_free_space("c:")), 0, -2);  ; 

              // echo substr("P210_Kim_TiA_FC_Upper-Lower_York_Tommy_BL2.zip ", 0,strlen("P210_Kim_TiA_FC_Upper-Lower_York_Tommy_BL2.zip")-4)


               ?>
                         <div class="row">
                          <div class="col-3">
                            <div class="form-group">
                              <label>By Date group</label><br>
                            <button name="today" class="btn btn-primary" onclick="showHint('1')">Today</button>
                            <button name="weekly" class="btn btn-primary"  onclick="showHint('2')">Weekly</button>
                            <button name="monthly" class="btn btn-primary"  onclick="showHint('3')">Monthly</button>
                            </div>
                          </div>
                            <div class="col-2">
                              <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="sdate" id="sdate" class="form-control">
                              </div>
                            </div>
                            <div class="col-2">
                              <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="edate" id="edate" class="form-control">
                              </div>
                            </div>
                            <div class="col-2">
                              <div class="form-group">
                                <label>Lab wise</label>
                                <select name="labname" id="labname" class="form-control">
                                  <option value="all">All Labs</option>
                                <?php 
                                $sql="SELECT labname FROM orders group by labname";
                        $res=mysqli_query($bd,$sql);
                        while($row=mysqli_fetch_array($res))
                        {?>
                          <option value="<?php echo $row['labname']?>"><?php echo $row['labname']?></option>
                          <?php 
                        }
                          ?>
                          </select>
                              </div>
                            </div>
                            <div class="col-2">
                              <div class="form-group">
                                <label>.</label><br>
                                <input type="submit" name="submit" value="Submit" onclick="showHint2('1')" class="btn btn-success">
                              </div>
                            </div>
                          </div>
                          <div class="progress" id="progress_bar" style="display:none; height:auto;padding:5px;">
                          <div class="progress-bar bg-success" id="progress_bar_process" role="progressbar" style="width:0%; height:auto;padding:5px;white-space:pre-wrap">0%</div>
                          </div>
                          
                          
<div class="loader" id="loader" style="display:none;"></div>

                      <div id="report_data"></div>
                    
                    </div>
                  
                </div>
            </div>

          </div>
      </section>
    </div>
<script>
  $(function () {
    $("#example1").DataTable({
      buttons: [ 
        'excelHtml5', 
    ]
    });
   
  });
</script>


<script>
function showHint(str) {
  if (str.length == 0) {
    document.getElementById("report_data").innerHTML = "";
    return;
  } else {
    // Show progress bar
          document.getElementById("loader").style.display = "block";


    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("report_data").innerHTML = this.responseText;
        // Hide progress bar when request is completed
                  document.getElementById("loader").style.display = "none";

        document.getElementById("progress_bar").innerHTML = "";
        $(function() {
          $("#example1").DataTable({
            "lengthMenu": [
              [100, 500, 1000, -1],
              [100, 500, 1000, "All"]
            ],
            "buttons": ['excel'],
            "iDisplayLength": 100,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
      }
    };
    xmlhttp.onprogress = function(event) {
      if (event.lengthComputable) {
        var percentComplete = (event.loaded / event.total) * 100;
        document.getElementById("progress_bar_inner").style.width = percentComplete + "%";
        document.getElementById("progress_bar_inner").setAttribute("aria-valuenow", percentComplete);
      }
    };
    xmlhttp.open("GET", "backup3.php?q=" + str, true);
    xmlhttp.send();
  }
}

 function showHint2(str) {
    str = document.getElementById("sdate").value + "," + document.getElementById("edate").value + "," + document.getElementById("labname").value;
    if (str.length == 0) {
      document.getElementById("report_data").innerHTML = "";
      return;
    } else {
      // Show loader
      document.getElementById("loader").style.display = "block";
               var xmlhttp = new XMLHttpRequest();
    //   document.getElementById('progress_bar').style.display='block';

        // xmlhttp.addEventListener('progress', function(event) {

        //     var percent_completed = Math.round((event.loaded / event.total) * 100);
        //     //alert("call");
        //     document.getElementById('progress_bar_process').style.width = percent_completed + '%';

        //     document.getElementById('progress_bar_process').innerHTML = percent_completed + '% completed';

        // });
      
      
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("report_data").innerHTML = this.responseText;
          // Hide loader when request is completed
          document.getElementById("loader").style.display = "none";
        //   document.getElementById('progress_bar_process').innerHTML = '<div class="" style="width:250px;"> Loaded</div>';
          $(function() {
            $("#example1").DataTable({
              "lengthMenu": [
                [100, 500, 1000, -1],
                [100, 500, 1000, "All"]
              ],
              "buttons": ['excel'],
              "iDisplayLength": 100,
              "responsive": true,
              "lengthChange": true,
              "autoWidth": false
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
          });
        }
      };
      xmlhttp.open("GET", "backup2.php?q=" + str, true);
      xmlhttp.send();
    }
  }
</script>


<?php
include 'footer.php';
?>