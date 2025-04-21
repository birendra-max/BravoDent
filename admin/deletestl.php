<?php
include 'header.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Delete STL</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Delete STL</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <style>
    .pagination {
      margin-top: 20px;
    }
    
    .pagination a {
      color: #333;
      padding: 8px 12px;
      text-decoration: none;
      border: 1px solid #ccc;
      margin-right: 5px;
    }
    
    .pagination a.active {
      background-color: #333;
      color: #fff;
      border-color: #333;
    }
    
    .pagination a:hover {
      background-color: #f4f4f4;
    }

    /* Loader styles */
    #loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      color: white;
      text-align: center;
      display: none;
      z-index: 9999;
    }

    .spinner {
      margin-top: 20%;
      border: 8px solid #f3f3f3;
      border-top: 8px solid #3498db;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 2s linear infinite;
    }

    #timer {
      font-size: 18px;
      margin-top: 20px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
    <button id="delete_selected" class="btn btn-danger mb-3">Delete Selected</button>
      <div class="table table-responsive">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><input type="checkbox" id="select_all"> Select All</th>
              <th>File Name</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $directory = '../api/stl_files/';
            $files_per_page = 1000;
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($current_page - 1) * $files_per_page;
            $count = 0;
            
            if (is_dir($directory)) {
              if ($handle = opendir($directory)) {
                while (($file = readdir($handle)) !== false) {
                  if ($file != "." && $file != "..") {
                    $count++;
                    if ($count > $offset && $count <= ($offset + $files_per_page)) {
                      $creation_date = date("Y-m-d H:i:s", filemtime($directory . $file));
                      echo '<tr id="stl' . $count . '">';
                      echo '<td><input type="checkbox" class="file-checkbox" value="' . $file . '"></td>';
                      echo '<td>' . $file . '</td>';
                      echo '<td>' . date("d-M-Y", strtotime($creation_date)) . '</td>';
                      echo '<td><button onclick="deleteFile(\'' . $file . '\', ' . $count . ')">Delete</button></td>';
                      echo '</tr>';
                    }
                  }
                }
                closedir($handle);
              }
            }
            
            $total_pages = ceil($count / $files_per_page);
            echo '<div class="pagination">';
            for ($i = 1; $i <= $total_pages; $i++) {
              echo '<a href="?page=' . $i . '">' . $i . '</a> ';
            }
            echo '</div>';
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<!-- Loader Overlay -->
<div id="loader">
  <div class="spinner"></div>
  <div id="timer"></div>
</div>

<?php
include 'footer.php';
?>

<script type="text/javascript">
  // Select/Deselect all checkboxes
  $('#select_all').on('click', function() {
    $('.file-checkbox').prop('checked', this.checked);
  });

  // Delete selected files
  $('#delete_selected').on('click', function() {
    var selectedFiles = [];
    $('.file-checkbox:checked').each(function() {
      selectedFiles.push($(this).val());
    });

    if (selectedFiles.length > 0) {
      if (confirm('Are you sure you want to delete the selected files?')) {
        var deleteRequests = [];
        
        // Show loader
        $('#loader').show();
        var timer = 10; // 10 seconds for example
        $('#timer').text('Time left: ' + timer + ' seconds');
        
        var countdown = setInterval(function() {
          timer--;
          $('#timer').text('Time left: ' + timer + ' seconds');
          if (timer <= 0) {
            clearInterval(countdown);
          }
        }, 1000);

        //$.each(selectedFiles, function(index, file) {
          var request = $.ajax({
            url: 'delete_file_stl.php',
            type: 'POST',
            data: { filename: selectedFiles },
            success: function(response) {
              console.log(response);
              alert('All selected files deleted successfully.'+response);
              location.reload();
              // console.log('File "' + response + '" deleted successfully.');
              // $("#stl" + (index + 1)).remove(); // Update row removal
            },
            error: function(xhr, status, error) {
              console.error('Error deleting file: ' + error);
              console.error(xhr.responseText);
            }
          });

          //deleteRequests.push(request);
        //});

        // $.when.apply($, deleteRequests).done(function() {
        //   alert('All selected files deleted successfully.');
        //   location.reload();
        // });

      }
    } else {
      alert('Please select at least one file to delete.');
    }
  });

  function deleteFile(filename, rowno) {
    if (confirm("Are you sure you want to delete this file?")) {
      $.ajax({
        url: 'delete_file_stl.php',
        type: 'POST',
        data: { filename: filename },
        success: function(response) {
          console.log(response);
          $("#stl" + rowno).remove();
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    }
  }
</script>
