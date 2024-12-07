<?php
include 'db.php';

// Handle Add Class
if (isset($_POST['add_class'])) {
    $class_name = $_POST['class_name'];
    if (!empty($class_name)) {
        $query = "INSERT INTO classes (name) VALUES ('$class_name')";
        $conn->query($query);
        header("Location: classes.php");
    }
}

// Handle Edit Class
if (isset($_POST['edit_class'])) {
    $class_id = $_POST['class_id'];
    $class_name = $_POST['class_name'];
    if (!empty($class_name)) {
        $query = "UPDATE classes SET name = '$class_name' WHERE class_id = $class_id";
        $conn->query($query);
        header("Location: classes.php");
    }
}

// Handle Delete Class
if (isset($_GET['delete'])) {
    $class_id = $_GET['delete'];
    // Check if there are students in the class
    $check_students = $conn->query("SELECT COUNT(*) AS count FROM student WHERE class_id = $class_id")->fetch_assoc()['count'];
    if ($check_students == 0) {
        $query = "DELETE FROM classes WHERE class_id = $class_id";
        $conn->query($query);
        header("Location: classes.php");
    } else {
        echo "<script>alert('Cannot delete class with students assigned to it.');</script>";
    }
}

// Fetch Classes
$classes = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Manage Classes</h1>

        <!-- Add Class Form -->
        <form method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" name="class_name" class="form-control" placeholder="New Class Name" required>
                <button type="submit" name="add_class" class="btn btn-primary">Add Class</button>
            </div>
        </form>

        <!-- List of Classes -->
        <table class="table">
            <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($class = $classes->fetch_assoc()): ?>
                    <tr>
                        <td><?= $class['name']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editClass(<?= $class['class_id']; ?>, '<?= $class['name']; ?>')">Edit</button>
                            <a href="classes.php?delete=<?= $class['class_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this class?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Class Modal -->
    <div id="editClassModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="class_id" id="editClassId">
                        <div class="mb-3">
                            <label for="editClassName" class="form-label">Class Name</label>
                            <input type="text" name="class_name" id="editClassName" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="edit_class" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editClass(classId, className) {
            document.getElementById('editClassId').value = classId;
            document.getElementById('editClassName').value = className;
            var modal = new bootstrap.Modal(document.getElementById('editClassModal'));
            modal.show();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
