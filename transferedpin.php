<?php
include 'connect.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $queries = explode(";", $_POST['query']); // Split multiple queries by ";"
    
    foreach ($queries as $query) {
        $query = trim($query); // Remove extra spaces or new lines
        if (!empty($query)) {
            if (mysqli_query($bd, $query)) {
                $success .= "<p>Query executed successfully: <br><code>" . htmlspecialchars($query) . "</code></p>";
            } else {
                $error .= "<p>Error executing query: <br><code>" . htmlspecialchars($query) . "</code><br> " . mysqli_error($bd) . "</p>";
            }
        }
    }
}

// Close the connection
mysqli_close($bd);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Execute Multiple SQL Queries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        textarea {
            width: 100%;
            height: 150px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<h2>Execute Multiple SQL Queries</h2>

<form method="post">
    <label for="query">Enter SQL Queries (separate with ";"):</label><br>
    <textarea name="query" id="query"><?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?></textarea><br><br>
    <input type="submit" value="Execute">
</form>

<?php
if (!empty($success)) {
    echo "<div class='success'>$success</div>";
}
if (!empty($error)) {
    echo "<div class='error'>$error</div>";
}
?>

</body>
</html>
