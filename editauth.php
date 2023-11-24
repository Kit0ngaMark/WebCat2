<?php
include('configs/c0nstantsss.php');
include('configs/DbConn.php');


if (isset($_GET['id'])) {
    $authorID = $_GET['id'];

    $sql = "SELECT * FROM Authorstb WHERE AuthorId = :authorID";
    $stmt = $DbConn->prepare($sql);
    $stmt->bindParam(':authorID', $authorID, PDO::PARAM_INT);
    $stmt->execute();

       if ($stmt->rowCount() > 0) {
        $author = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Author not found. Author ID: " . $authorID;
        exit; 
    }
} else {
    echo "Author ID not provided in the URL.";
    exit; 
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $updatedFullName = $_POST['updatedFullName'];
    $updatedEmail = $_POST['updatedEmail'];
    $updatedAddress = $_POST['updatedAddress'];
    $updatedBiography = $_POST['updatedBiography'];
    $updatedDateOfBirth = $_POST['updatedDateOfBirth'];
    $updatedSuspended = isset($_POST['updatedSuspended']) ? 1 : 0;

    try {
       
        $updateSql = "UPDATE Authorstb SET
            AuthorFullName = :updatedFullName,
            AuthorEmail = :updatedEmail,
            AuthorAddress = :updatedAddress,
            AuthorBiography = :updatedBiography,
            AuthorDateOfBirth = :updatedDateOfBirth,
            AuthorSuspended = :updatedSuspended
            WHERE AuthorId = :authorID";

        $updateStmt = $DbConn->prepare($updateSql);
        $updateStmt->bindParam(':updatedFullName', $updatedFullName);
        $updateStmt->bindParam(':updatedEmail', $updatedEmail);
        $updateStmt->bindParam(':updatedAddress', $updatedAddress);
        $updateStmt->bindParam(':updatedBiography', $updatedBiography);
        $updateStmt->bindParam(':updatedDateOfBirth', $updatedDateOfBirth);
        $updateStmt->bindParam(':updatedSuspended', $updatedSuspended);
        $updateStmt->bindParam(':authorID', $authorID, PDO::PARAM_INT);

        $updateStmt->execute();

        echo "Author updated successfully";
    } catch (PDOException $e) {
        echo "Error updating author: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edit Author</h2>
        <form action="" method="post">
        <div class="form-group">
                <label for="updatedFullName">Author Full Name:</label>
                <input type="text" class="form-control" id="updatedFullName" name="updatedFullName" value="<?php echo $author['AuthorFullName']; ?>" required>
            </div>

            <div class="form-group">
                <label for="updatedEmail">Author Email:</label>
                <input type="email" class="form-control" id="updatedEmail" name="updatedEmail" value="<?php echo $author['AuthorEmail']; ?>" required>
            </div>

            <div class="form-group">
                <label for="updatedAddress">Author Address:</label>
                <input type="text" class="form-control" id="updatedAddress" name="updatedAddress" value="<?php echo $author['AuthorAddress']; ?>">
            </div>

            <div class="form-group">
                <label for="updatedBiography">Author Biography:</label>
                <textarea class="form-control" id="updatedBiography" name="updatedBiography" rows="4"><?php echo $author['AuthorBiography']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="updatedDateOfBirth">Author Date of Birth:</label>
                <input type="date" class="form-control" id="updatedDateOfBirth" name="updatedDateOfBirth" value="<?php echo $author['AuthorDateOfBirth']; ?>">
            </div>

            <div class="form-group">
                <label for="updatedSuspended">Author Suspended:</label>
                <select class="form-control" id="updatedSuspended" name="updatedSuspended">
                    <option value="False" <?php echo ($author['AuthorSuspended'] == False) ? 'selected' : ''; ?>>False</option>
                    <option value="True" <?php echo ($author['AuthorSuspended'] == True) ? 'selected' : ''; ?>>True</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Author</button>
        </form>
    </div>
</body>
</html>
