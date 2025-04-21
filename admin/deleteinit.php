<?php
include 'header.php';
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Delete INIT</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Delete INIT</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="table-responsive">
                <button id="delete_selected" class="btn btn-danger mb-2">Delete Selected</button>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all" /></th>
                            <th>File Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $directory = '../api/files/';
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
                                            echo '<tr id="row' . $count . '">';
                                            echo '<td><input type="checkbox" class="file-checkbox" value="' . $file . '"></td>';
                                            echo '<td>' . $file . '</td>';
                                            echo '<td>' . date("d-M-Y", strtotime($creation_date)) . '</td>';
                                            echo '<td><button onclick="deleteFile(\'' . $file . '\', ' . $count . ')" class="btn btn-danger btn-sm">Delete</button></td>';
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

<!-- Loader -->
<div id="loader" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
    <img src="loader.gif" alt="Loading...">
</div>

<script type="text/javascript">
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
                $('#loader').show(); // Show loader
                $.ajax({
                    url: 'delete_file_init.php',
                    type: 'POST',
                    data: { filename: selectedFiles },
                    success: function (response) {
                        alert(response);
                        selectedFiles.forEach(function (file) {
                            $('input[value="' + file + '"]').closest('tr').remove();
                        });
                        $('#loader').hide(); // Hide loader
                    },
                    error: function () {
                        alert('Error occurred while deleting files.');
                        $('#loader').hide(); // Hide loader
                    }
                });
            }
        } else {
            alert('Please select at least one file to delete.');
        }
    });

    // Delete individual file
    function deleteFile(filename, rowno) {
        if (confirm('Are you sure you want to delete the file ' + filename + '?')) {
            $('#loader').show(); // Show loader
            $.ajax({
                url: 'delete_file_init.php',
                type: 'POST',
                data: { filename: [filename] },
                success: function (response) {
                    alert(response);
                    $('#row' + rowno).remove();
                    $('#loader').hide(); // Hide loader
                },
                error: function () {
                    alert('Error occurred while deleting the file.');
                    $('#loader').hide(); // Hide loader
                }
            });
        }
    }
</script>

<?php
include 'footer.php';
?>
