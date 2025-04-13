<?php
include '../../includes/header.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $salary = $_POST['salary'];
    $allowances = $_POST['allowances'];
    $deductions = $_POST['deductions'];

    // Insert staff data into the database
    $stmt = $pdo->prepare("INSERT INTO staff (name, salary, allowances, deductions) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $salary, $allowances, $deductions])) {
        $success_message = "Staff added successfully!";
    } else {
        $error_message = "Failed to add staff.";
    }
}

// Fetch recorded staff
$staff_stmt = $pdo->query("SELECT * FROM staff");
$staff = $staff_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Add Staff</h1>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <form method="POST" class="mt-4">
        <input type="text" name="name" placeholder="Staff Name" required class="border p-2 mb-4 w-full">
        <input type="number" name="salary" placeholder="Salary" required class="border p-2 mb-4 w-full">
        <input type="number" name="allowances" placeholder="Allowances" class="border p-2 mb-4 w-full">
        <input type="number" name="deductions" placeholder="Deductions" class="border p-2 mb-4 w-full">
        <button type="submit" class="bg-blue-500 text-white p-2">Add Staff</button>
    </form>

    <h2 class="text-xl font-bold mt-6">Recorded Staff</h2>
    <table class="min-w-full mt-4 border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Salary</th>
                <th class="border px-4 py-2">Allowances</th>
                <th class="border px-4 py-2">Deductions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staff as $member): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($member['name']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($member['salary']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($member['allowances']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($member['deductions']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include '../../includes/footer.php';
?>
