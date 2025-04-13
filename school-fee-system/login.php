<?php
include 'includes/header.php';
include 'config/database.php';
include 'includes/functions.php';

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Call the login function
    $login_result = login($username, $password);
    if ($login_result) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Login</h1>
    <?php if (isset($error)) { echo "<p class='text-red-500'>$error</p>"; } ?>
    <form method="POST" class="mt-4">
        <input type="text" name="username" placeholder="Username" required class="border p-2 mb-4 w-full">
        <input type="password" name="password" placeholder="Password" required class="border p-2 mb-4 w-full">
        <button type="submit" class="bg-blue-500 text-white p-2">Login</button>
    </form>
</div>

<?php
include 'includes/footer.php';
?>
