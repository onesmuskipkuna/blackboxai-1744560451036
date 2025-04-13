<?php
include '../../includes/header.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class = $_POST['class'];
    $term = $_POST['term'];
    $amount = $_POST['amount'];

    // Insert fee structure data into the database
    $stmt = $pdo->prepare("INSERT INTO fee_structures (class, term, amount) VALUES (?, ?, ?)");
    if ($stmt->execute([$class, $term, $amount])) {
        $success_message = "Fee structure added successfully!";
    } else {
        $error_message = "Failed to add fee structure.";
    }
}

// Fetch fee structures
$stmt = $pdo->query("SELECT * FROM fee_structures");
$fee_structures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Add Fee Structure</h1>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <form method="POST" class="mt-4">
        <input type="text" name="class" placeholder="Class" required class="border p-2 mb-4 w-full">
        <select name="term" required class="border p-2 mb-4 w-full">
            <option value="">Select Term</option>
            <option value="Term 1">Term 1</option>
            <option value="Term 2">Term 2</option>
            <option value="Term 3">Term 3</option>
        </select>
        <input type="number" name="amount" placeholder="Amount" required class="border p-2 mb-4 w-full">
        <button type="submit" class="bg-blue-500 text-white p-2">Add Fee Structure</button>
    </form>

    <h2 class="text-xl font-bold mt-6">Fee Structures</h2>
    <table class="min-w-full mt-4 border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Class</th>
                <th class="border px-4 py-2">Term</th>
                <th class="border px-4 py-2">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fee_structures as $fee_structure): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($fee_structure['class']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($fee_structure['term']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($fee_structure['amount']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include '../../includes/footer.php';
?>
