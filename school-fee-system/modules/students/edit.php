<?php
include '../../includes/header.php';
include '../../config/database.php';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student data for the given ID
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $guardian_name = $_POST['guardian_name'];
    $phone_number = $_POST['phone_number'];
    $school_level = $_POST['school_level'];
    $class = $_POST['class'];

    // Update student data in the database
    $stmt = $pdo->prepare("UPDATE students SET first_name = ?, last_name = ?, guardian_name = ?, phone_number = ?, school_level = ?, class = ? WHERE id = ?");
    if ($stmt->execute([$first_name, $last_name, $guardian_name, $phone_number, $school_level, $class, $student_id])) {
        $success_message = "Student updated successfully!";
    } else {
        $error_message = "Failed to update student.";
    }
}
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Edit Student</h1>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <form method="POST" class="mt-4">
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required class="border p-2 mb-4 w-full">
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required class="border p-2 mb-4 w-full">
        <input type="text" name="guardian_name" value="<?php echo htmlspecialchars($student['guardian_name']); ?>" required class="border p-2 mb-4 w-full">
        <input type="text" name="phone_number" value="<?php echo htmlspecialchars($student['phone_number']); ?>" required class="border p-2 mb-4 w-full">
        <select name="school_level" required class="border p-2 mb-4 w-full">
            <option value="Primary" <?php echo $student['school_level'] == 'Primary' ? 'selected' : ''; ?>>Primary</option>
            <option value="Junior Secondary" <?php echo $student['school_level'] == 'Junior Secondary' ? 'selected' : ''; ?>>Junior Secondary</option>
        </select>
        <input type="text" name="class" value="<?php echo htmlspecialchars($student['class']); ?>" required class="border p-2 mb-4 w-full">
        <button type="submit" class="bg-blue-500 text-white p-2">Update Student</button>
    </form>
</div>

<?php
include '../../includes/footer.php';
?>
