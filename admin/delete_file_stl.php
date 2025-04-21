<?php
if (isset($_POST['filename']) && is_array($_POST['filename'])) {
    // Directory path
    $directory = '../api/stl_files/';
    
    // Get the array of filenames from the POST data
    $filenames = $_POST['filename'];
    
    $responses = []; // Array to store the responses for each file

    foreach ($filenames as $filename) {
        // Construct the full path to the file
        $filepath = $directory . $filename;
        
        // Check if the file exists
        if (file_exists($filepath)) {
            // Attempt to delete the file
            if (unlink($filepath)) {
                $responses[] = "File '" . $filename . "' has been deleted.";
            } else {
                $responses[] = "Error: Unable to delete the file '" . $filename . "'.";
            }
        } else {
            // File does not exist
            $responses[] = "Error: File '" . $filename . "' does not exist.";
        }
    }
    
    // Return the responses for each file
    echo implode('<br>', $responses);

} else {
    // If filename(s) are not provided or not an array
    echo "Error: Filename(s) not provided or not valid.";
}
?>
