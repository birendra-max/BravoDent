<?php
if (isset($_POST['filename'])) {
    // Directory path
    $directory = '../api/files/';
    
    // Get the filename(s) from the POST data
    $filenames = $_POST['filename'];
    
    // Check if filenames is a string or an array
    if (!is_array($filenames)) {
        $filenames = [$filenames]; // Convert single filename to an array
    }

    // Initialize a response array
    $response = [];

    foreach ($filenames as $filename) {
        // Construct the full path to the file
        $filepath = $directory . $filename;

        // Check if the file exists
        if (file_exists($filepath)) {
            // Attempt to delete the file
            if (unlink($filepath)) {
                $response[] = "File '" . $filename . "' has been deleted.";
            } else {
                $response[] = "Error: Unable to delete the file '" . $filename . "'.";
            }
        } else {
            $response[] = "Error: File '" . $filename . "' does not exist.";
        }
    }

    // Return response as a JSON array
    echo json_encode($response);
} else {
    // If filename is not provided
    echo json_encode(["Error: Filename not provided."]);
}
?>
