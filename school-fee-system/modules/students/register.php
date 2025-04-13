<?php
include '../../includes/header.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $guardian_name = $_POST['guardian_name'];
    $phone_number = $_POST['phone_number'];
    $school_level = $_POST['school_level'];
    $class = $_POST['class'];

    // Insert student data into the database
    $stmt = $pdo->prepare("INSERT INTO students (first_name, last_name, guardian_name, phone_number, school_level, class) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$first_name, $last_name, $guardian_name, $phone_number, $school_level, $class])) {
        $success_message = "Student added successfully!";
    } else {
        $error_message = "Failed to add student.";
    }
}
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Add New Student</h1>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <form method="POST" class="mt-4">
        <input type="text" name="first_name" placeholder="First Name" required class="border p-2 mb-4 w-full">
        <input type="text" name="last_name" placeholder="Last Name" required class="border p-2 mb-4 w-full">
        <input type="text" name="guardian_name" placeholder="Guardian Name" required class="border p-2 mb-4 w-full">
        <input type="text" name="phone_number" placeholder="Phone Number" required class="border p-2 mb-4 w-full">
        <select name="school_level" required class="border p-2 mb-4 w-full">
            <option value="">Select School Level</option>
            <option value="Primary">Primary</option>
            <option value="Junior Secondary">Junior Secondary</option>
        </select>
        <input type="text" name="class" placeholder="Class" required class="border p-2 mb-4 w-full">
        <button type="submit" class="bg-blue-500 text-white p-2">Add Student</button>
    </form>
</div>

<?php
include '../../includes/footer.php';
?>
