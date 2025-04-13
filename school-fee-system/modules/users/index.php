<?php
include '../../includes/header.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role_name = $_POST['role_name'];

    // Insert user role data into the database
    $stmt = $pdo->prepare("INSERT INTO roles (role_name) VALUES (?)");
    if ($stmt->execute([$role_name])) {
        $success_message = "Role added successfully!";
    } else {
        $error_message = "Failed to add role.";
    }
}

// Fetch recorded roles
$roles_stmt = $pdo->query("SELECT * FROM roles");
$roles = $roles_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Manage User Roles</h1>
    <?php if (isset($success_message)) { echo "<p class='text-green-500'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>
    <form method="POST" class="mt-4">
        <input type="text" name="role_name" placeholder="Role Name" required class="border p-2 mb-4 w-full">
        <button type="submit" class="bg-blue-500 text-white p-2">Add Role</button>
    </form>

    <h2 class="text-xl font-bold mt-6">User Roles</h2>
    <table class="min-w-full mt-4 border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Role Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $role): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($role['role_name']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include '../../includes/footer.php';
?>
