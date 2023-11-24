
<?php



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "authordb";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM authorstb";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Authors</title>
</head>
<body>
    <h2>Author Details</h2>
    
    <?php
    
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Full Name</th><th>Email</th><th>Address</th><th>Biography</th><th>Date of Birth</th><th>Suspended</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td> {$row['AuthorID']}</td>";
            echo "<td>{$row['AuthorFullName']}</td>";
            echo "<td>{$row['AuthorEmail']}</td>";
            echo "<td>{$row['AuthorAddress']}</td>";
            echo "<td>{$row['AuthorBiography']}</td>";
            echo "<td>{$row['AuthorDateOfBirth']}</td>";
            echo "<td>{$row['AuthorSuspended']}</td>";
            echo "<td><a href='editauth.php?id={$row['AuthorID']}'>Edit</a> | <a href='DelAuth.php?id={$row['AuthorID']}'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No authors found.";
    }

    $conn->close();
    ?>

    
</body>
</html>
