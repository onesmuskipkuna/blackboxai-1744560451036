<?php
include '../../includes/header.php';
include '../../config/database.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user data for the given ID
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $role_id = $_POST['role_id'];

    // Update user data in the database
    $stmt = $pdo->prepare("UPDATE users SET username = ?, role_id = ? WHERE id = ?");
    if ($stmt->execute([$username, $role_id, $user_id])) {
        $success_message = "User updated successfully!";
    } else {
        $error_message = "Failed to update user.";
    }
}

// Fetch roles for user editing
$roles_stmt = $pdo->query("SELECT * FROM roles");
$roles = $roles_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Edit User</h1>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <form method="POST" class="mt-4">
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required class="border p-2 mb-4 w-full">
        <select name="role_id" required class="border p-2 mb-4 w-full">
            <option value="">Select Role</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['id']; ?>" <?php echo $user['role_id'] == $role['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($role['role_name']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="bg-blue-500 text-white p-2">Update User</button>
    </form>
</div>

<?php
include '../../includes/footer.php';
?>
