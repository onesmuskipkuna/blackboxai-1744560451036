<?php
include '../../includes/header.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = $_POST['role_id'];

    // Insert user data into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $password, $role_id])) {
        $success_message = "User added successfully!";
    } else {
        $error_message = "Failed to add user.";
    }
}

// Fetch roles for user registration
$roles_stmt = $pdo->query("SELECT * FROM roles");
$roles = $roles_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Add User</h1>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <form method="POST" class="mt-4">
        <input type="text" name="username" placeholder="Username" required class="border p-2 mb-4 w-full">
        <input type="password" name="password" placeholder="Password" required class="border p-2 mb-4 w-full">
        <select name="role_id" required class="border p-2 mb-4 w-full">
            <option value="">Select Role</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['id']; ?>"><?php echo htmlspecialchars($role['role_name']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="bg-blue-500 text-white p-2">Add User</button>
    </form>
</div>

<?php
include '../../includes/footer.php';
?>
