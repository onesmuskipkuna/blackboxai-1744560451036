<?php
include '../../includes/header.php';
include '../../config/database.php';

// Fetch fee collection report
$fee_collection_stmt = $pdo->query("SELECT SUM(amount) AS total_fee FROM invoices");
$fee_collection = $fee_collection_stmt->fetch(PDO::FETCH_ASSOC);

// Fetch total expenses report
$expenses_stmt = $pdo->query("SELECT SUM(amount) AS total_expenses FROM expenses");
$total_expenses = $expenses_stmt->fetch(PDO::FETCH_ASSOC);

// Fetch payroll report
$payroll_stmt = $pdo->query("SELECT SUM(salary) AS total_salary FROM staff");
$total_salary = $payroll_stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Reports</h1>
    <h2 class="text-xl font-bold mt-6">Fee Collection Report</h2>
    <p>Total Fees Collected: <?php echo htmlspecialchars($fee_collection['total_fee']); ?></p>

    <h2 class="text-xl font-bold mt-6">Expenses Report</h2>
    <p>Total Expenses: <?php echo htmlspecialchars($total_expenses['total_expenses']); ?></p>

    <h2 class="text-xl font-bold mt-6">Payroll Report</h2>
    <p>Total Salary Paid: <?php echo htmlspecialchars($total_salary['total_salary']); ?></p>
</div>

<?php
include '../../includes/footer.php';
?>
