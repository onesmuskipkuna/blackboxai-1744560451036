<?php
include '../../includes/header.php';
include '../../config/database.php';

// Fetch registered users
$users_stmt = $pdo->query("SELECT users.id, users.username, roles.role_name FROM users JOIN roles ON users.role_id = roles.id");
$users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle deletion of a user
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($delete_stmt->execute([$delete_id])) {
        $success_message = "User deleted successfully!";
    } else {
        $error_message = "Failed to delete user.";
    }
}
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Registered Users</h1>
    <a href="register.php" class="bg-blue-500 text-white p-2">Add New User</a>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <table class="min-w-full mt-4 border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Username</th>
                <th class="border px-4 py-2">Role</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($user['username']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($user['role_name']); ?></td>
                    <td class="border px-4 py-2">
                        <a href="edit.php?id=<?php echo $user['id']; ?>" class="text-blue-500">Edit</a>
                        <a href="?delete_id=<?php echo $user['id']; ?>" class="text-red-500">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include '../../includes/footer.php';
?>
