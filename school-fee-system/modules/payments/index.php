<?php
include '../../includes/header.php';
include '../../config/database.php';

// Fetch invoices for payment recording
$invoices_stmt = $pdo->query("SELECT * FROM invoices");
$invoices = $invoices_stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invoice_id = $_POST['invoice_id'];
    $amount_paid = $_POST['amount_paid'];
    $payment_mode = $_POST['payment_mode'];
    $remarks = $_POST['remarks'];

    // Insert payment data into the database
    $stmt = $pdo->prepare("INSERT INTO payments (invoice_id, amount_paid, payment_mode, remarks) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$invoice_id, $amount_paid, $payment_mode, $remarks])) {
        $success_message = "Payment recorded successfully!";
    } else {
        $error_message = "Failed to record payment.";
    }
}

// Fetch recorded payments
$payments_stmt = $pdo->query("SELECT * FROM payments");
$payments = $payments_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Record Payment</h1>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <form method="POST" class="mt-4">
        <select name="invoice_id" required class="border p-2 mb-4 w-full">
            <option value="">Select Invoice</option>
            <?php foreach ($invoices as $invoice): ?>
                <option value="<?php echo $invoice['id']; ?>"><?php echo htmlspecialchars($invoice['amount']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="amount_paid" placeholder="Amount Paid" required class="border p-2 mb-4 w-full">
        <select name="payment_mode" required class="border p-2 mb-4 w-full">
            <option value="">Select Payment Mode</option>
            <option value="Cash">Cash</option>
            <option value="Bank">Bank</option>
            <option value="Mpesa">Mpesa</option>
        </select>
        <textarea name="remarks" placeholder="Remarks" class="border p-2 mb-4 w-full"></textarea>
        <button type="submit" class="bg-blue-500 text-white p-2">Record Payment</button>
    </form>

    <h2 class="text-xl font-bold mt-6">Recorded Payments</h2>
    <table class="min-w-full mt-4 border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Invoice ID</th>
                <th class="border px-4 py-2">Amount Paid</th>
                <th class="border px-4 py-2">Payment Mode</th>
                <th class="border px-4 py-2">Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $payment): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($payment['invoice_id']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($payment['amount_paid']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($payment['payment_mode']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($payment['remarks']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include '../../includes/footer.php';
?>
