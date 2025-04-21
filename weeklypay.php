<?php
include 'connect.php';

$error = "";
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = trim($_POST['query']);

    if (!empty($query)) {
        $result = mysqli_query($bd, $query);

        if (!$result) {
            $error = "Error executing query: " . mysqli_error($bd);
        }
    } else {
        $error = "Query field cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Form</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<h2>SQL Query Execution</h2>

<form method="post">
    <label for="query">Enter SQL Query:</label><br>
    <textarea name="query" id="query" rows="4" cols="50"><?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?></textarea><br><br>
    <input type="submit" value="Execute">
</form>

<?php
if (!empty($error)) {
    echo "<p class='error'>$error</p>";
}

if ($result && mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr>";

    // Fetch and display table headers
    $fields = mysqli_fetch_fields($result);
    foreach ($fields as $field) {
        echo "<th>" . htmlspecialchars($field->name) . "</th>";
    }
    echo "</tr>";

    // Fetch and display table rows
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} elseif ($result) {
    echo "<p>No records found.</p>";
}

// Close the connection
//mysqli_close($$bd);
?>

</body>
</html>
