<?php
include 'header.php';
?>
<style>
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
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Delete Finished</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Delete Finished</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div id="loader" style="display:none;">
        <div class="spinner"></div> <!-- The spinner -->
        <p>Deleting files, please wait...</p>
        <p id="timer">Time left: <span id="countdown"></span></p>
    </div>
    <section class="content">
        <div class="container-fluid">
            <button id="delete_selected" class="btn btn-danger mb-3">Delete Selected</button>
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all"></th>
                            <th>File Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $directory = '../api/finished_files/';
                        $files_per_page = 1000;
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($current_page - 1) * $files_per_page;

                        if (is_dir($directory)) {
                            if ($handle = opendir($directory)) {
                                $count = 0;
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
                            echo '<a href="?page=' . $i . '" class="' . ($i == $current_page ? 'active' : '') . '">' . $i . '</a> ';
                        }
                        echo '</div>';
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php
include 'footer.php';
?>



<script type="text/javascript">
    $(document).ready(function () {
    // Select all checkboxes
    $('#select_all').on('click', function () {
        $('.file-checkbox').prop('checked', this.checked);
    });

    // Delete selected files
    $('#delete_selected').on('click', function () {
        var selectedFiles = [];
        $('.file-checkbox:checked').each(function () {
            selectedFiles.push($(this).val());
        });

        if (selectedFiles.length > 0) {
            if (confirm('Are you sure you want to delete the selected files?')) {
                // Show the loader and start the countdown
                $('#loader').show();

                // Set the countdown timer (e.g., 10 seconds initially)
                var countdownTime = 5; // seconds
                $('#countdown').text(countdownTime + 's');

                // Start the countdown timer
                var timerInterval = setInterval(function () {
                    countdownTime--;
                    $('#countdown').text(countdownTime + 's');

                    // Stop the timer once it reaches 0
                    if (countdownTime <= 0) {
                        clearInterval(timerInterval);
                    }
                }, 1000);

                var deleteRequests = [];

                $.each(selectedFiles, function (index, file) {
                    var request = $.ajax({
                        url: 'delete_file_finished.php',
                        type: 'POST',
                        data: { filename: file }, // Sending the filename to the PHP script
                        success: function (response) {
                            console.log('File "' + file + '" deleted successfully.');
                        },
                        error: function (xhr, status, error) {
                            console.error('Error deleting file: ' + file);
                            console.error(xhr.responseText);
                        }
                    });

                    // Add each AJAX request to the deleteRequests array
                    deleteRequests.push(request);
                });

                // Use $.when() to wait for all AJAX requests to finish
                $.when.apply($, deleteRequests).done(function () {
                    // Hide the loader and stop the countdown
                    $('#loader').hide();
                    alert('All selected files deleted successfully.');
                    location.reload(); // Reload the page after all files are deleted
                });
            }
        } else {
            alert('Please select at least one file to delete.');
        }
    });
});



    function deleteFile(filename, rowno) {
        if (confirm('Are you sure you want to delete the file ' + filename + '?')) {
            $.ajax({
                url: 'delete_file_finished.php',
                type: 'POST',
                data: { filename: filename },
                success: function (response) {
                    console.log(response);
                    $('#stl' + rowno).remove();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>

