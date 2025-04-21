<?php
if (isset($_POST['filename'])) {
    // Directory path
    $directory = '../api/finished_files/';
    
    // Get the filename from the POST data
    $filename = $_POST['filename'];
    
    // Construct the full path to the file
    $filepath = $directory . $filename;
    
    // Check if the file exists
    if (file_exists($filepath)) {
        // Attempt to delete the file
        if (unlink($filepath)) {
            echo "File '" . $filename . "' has been deleted.";
        } else {
            echo "Error: Unable to delete the file '" . $filename . "'.";
        }
    } else {
        echo "Error: File '" . $filename . "' does not exist.";
    }
} else {
    // If filename is not provided
    echo "Error: Filename not provided.";
}
?>
