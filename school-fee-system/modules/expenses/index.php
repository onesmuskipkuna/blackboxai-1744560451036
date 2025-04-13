<?php
include '../../includes/header.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];

    // Insert expense data into the database
    $stmt = $pdo->prepare("INSERT INTO expenses (category, description, amount, date) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$category, $description, $amount, $date])) {
        $success_message = "Expense recorded successfully!";
    } else {
        $error_message = "Failed to record expense.";
    }
}

// Fetch recorded expenses
$expenses_stmt = $pdo->query("SELECT * FROM expenses");
$expenses = $expenses_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Record Expense</h1>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <form method="POST" class="mt-4">
        <input type="text" name="category" placeholder="Expense Category" required class="border p-2 mb-4 w-full">
        <input type="text" name="description" placeholder="Description" required class="border p-2 mb-4 w-full">
        <input type="number" name="amount" placeholder="Amount" required class="border p-2 mb-4 w-full">
        <input type="date" name="date" required class="border p-2 mb-4 w-full">
        <button type="submit" class="bg-blue-500 text-white p-2">Record Expense</button>
    </form>

    <h2 class="text-xl font-bold mt-6">Recorded Expenses</h2>
    <table class="min-w-full mt-4 border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Category</th>
                <th class="border px-4 py-2">Description</th>
                <th class="border px-4 py-2">Amount</th>
                <th class="border px-4 py-2">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenses as $expense): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($expense['category']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($expense['description']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($expense['amount']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($expense['date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include '../../includes/footer.php';
?>
