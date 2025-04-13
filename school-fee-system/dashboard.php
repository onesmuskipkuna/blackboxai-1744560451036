<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    <a href="logout.php" class="text-blue-500">Logout</a>
</div>

<?php
include 'includes/footer.php';
?>
