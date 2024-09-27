<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // replace with your MySQL username
$password = ""; // replace with your MySQL password
$dbname = "big_data"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get table name and column details
$table_name = $_POST['table_name'];
$column_names = $_POST['column_names'];

if (empty($table_name) || empty($column_names)) {
    die("Table name and at least one column are required.");
}

// Check if file is uploaded
if (isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];

    if (($handle = fopen($file, 'r')) !== FALSE) {
        // Skip the header if there is one
        fgetcsv($handle);

        // Read CSV line by line
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            // Prepare SQL insert statement
            $columns = implode(", ", array_map(function($col) {
                return "`$col`";
            }, $column_names));
            $placeholders = implode(", ", array_fill(0, count($column_names), '?'));
            $sql = "INSERT INTO `$table_name` ($columns) VALUES ($placeholders)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(str_repeat('s', count($column_names)), ...$data); // Adjust 's' based on data type
            
            // Execute the statement
            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error . "<br>";
            }
        }

        fclose($handle);
        echo "Data imported successfully!";
    } else {
        echo "Error opening the file.";
    }
} else {
    echo "No file uploaded.";
}

// Close connection
$conn->close();
?>
