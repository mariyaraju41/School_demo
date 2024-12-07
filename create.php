<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image']['name'];

    // Upload image
    if ($image) {
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    // Insert data into the database
    $query = "INSERT INTO student (name, email, address, class_id, image) 
              VALUES ('$name', '$email', '$address', $class_id, '$image')";
    $conn->query($query);

    header('Location: index.php');
}

// Fetch classes for the dropdown
$class_result = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email">
        <textarea name="address" placeholder="Address"></textarea>
        <select name="class_id">
            <?php while ($class = $class_result->fetch_assoc()): ?>
                <option value="<?= $class['class_id']; ?>"><?= $class['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <input type="file" name="image" accept=".jpg, .png">
        <button type="submit">Add Student</button>
    </form>
</body>
</html>
