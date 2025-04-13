<?php
include '../../includes/header.php';
include '../../config/database.php';

// Fetch registered students
$stmt = $pdo->query("SELECT * FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle deletion of a student
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    if ($delete_stmt->execute([$delete_id])) {
        $success_message = "Student deleted successfully!";
    } else {
        $error_message = "Failed to delete student.";
    }
}
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Registered Students</h1>
    <a href="register.php" class="bg-blue-500 text-white p-2">Add New Student</a>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <table class="min-w-full mt-4 border">
        <thead>
            <tr>
                <th class="border px-4 py-2">First Name</th>
                <th class="border px-4 py-2">Last Name</th>
                <th class="border px-4 py-2">Guardian Name</th>
                <th class="border px-4 py-2">Phone Number</th>
                <th class="border px-4 py-2">School Level</th>
                <th class="border px-4 py-2">Class</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($student['first_name']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($student['last_name']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($student['guardian_name']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($student['phone_number']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($student['school_level']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($student['class']); ?></td>
                    <td class="border px-4 py-2">
                        <a href="edit.php?id=<?php echo $student['id']; ?>" class="text-blue-500">Edit</a>
                        <a href="?delete_id=<?php echo $student['id']; ?>" class="text-red-500">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include '../../includes/footer.php';
?>
