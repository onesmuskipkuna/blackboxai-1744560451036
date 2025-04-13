<?php
include '../../includes/header.php';
include '../../config/database.php';

// Fetch students for invoice generation
$students_stmt = $pdo->query("SELECT * FROM students");
$students = $students_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch fee structures for invoice generation
$fee_structures_stmt = $pdo->query("SELECT * FROM fee_structures");
$fee_structures = $fee_structures_stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $fee_structure_id = $_POST['fee_structure_id'];
    $amount = $_POST['amount'];

    // Insert invoice data into the database
    $stmt = $pdo->prepare("INSERT INTO invoices (student_id, fee_structure_id, amount) VALUES (?, ?, ?)");
    if ($stmt->execute([$student_id, $fee_structure_id, $amount])) {
        $success_message = "Invoice generated successfully!";
    } else {
        $error_message = "Failed to generate invoice.";
    }
}

// Fetch generated invoices
$invoices_stmt = $pdo->query("SELECT * FROM invoices");
$invoices = $invoices_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Generate Invoice</h1>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <form method="POST" class="mt-4">
        <select name="student_id" required class="border p-2 mb-4 w-full">
            <option value="">Select Student</option>
            <?php foreach ($students as $student): ?>
                <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></option>
            <?php endforeach; ?>
        </select>
        <select name="fee_structure_id" required class="border p-2 mb-4 w-full">
            <option value="">Select Fee Structure</option>
            <?php foreach ($fee_structures as $fee_structure): ?>
                <option value="<?php echo $fee_structure['id']; ?>"><?php echo htmlspecialchars($fee_structure['class'] . ' - ' . $fee_structure['term']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="amount" placeholder="Amount" required class="border p-2 mb-4 w-full">
        <button type="submit" class="bg-blue-500 text-white p-2">Generate Invoice</button>
    </form>

    <h2 class="text-xl font-bold mt-6">Generated Invoices</h2>
    <table class="min-w-full mt-4 border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Student ID</th>
                <th class="border px-4 py-2">Fee Structure ID</th>
                <th class="border px-4 py-2">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoices as $invoice): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($invoice['student_id']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($invoice['fee_structure_id']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($invoice['amount']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include '../../includes/footer.php';
?>
