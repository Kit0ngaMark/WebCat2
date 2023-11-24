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

    // Validate and sanitize input to prevent SQL injection
    $AuthorID = mysqli_real_escape_string($conn, $AuthorID);

    // Check if the author with the given ID exists before attempting to delete
    $checkIfExists = "SELECT * FROM authorstb WHERE AuthorID = '$AuthorID'";
    $result = $conn->query($checkIfExists);

    if ($result->num_rows > 0) {
        // Author exists, proceed with deletion
        $deleteSql = "DELETE FROM authorstb WHERE AuthorID = '$AuthorID'";

        if ($conn->query($deleteSql) === true) {
            // Redirect to viewauthors.php after successful deletion
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
