<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "authordb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $AuthorID = $_GET["id"];

   
    $AuthorID = mysqli_real_escape_string($conn, $AuthorID);

   
    $checkIfExists = "SELECT * FROM authorstb WHERE AuthorID = '$AuthorID'";
    $result = $conn->query($checkIfExists);

    if ($result->num_rows > 0) {
        $deleteSql = "DELETE FROM authorstb WHERE AuthorID = '$AuthorID'";

        if ($conn->query($deleteSql) === true) {
        
            header("Location: viewAuthors.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Author with ID $AuthorID not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
