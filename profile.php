<?php
session_start();

// Sertakan file koneksi
include('koneksi.php');

// Cek apakah user sudah login dan role-nya adalah 'user'
if ($_SESSION['role'] != 'user') {
    header("Location: login.php"); // Proteksi halaman
    exit();
}

// Ambil data profil pengguna
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Cek jika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password']; // Ambil password baru

    // Hash password baru sebelum disimpan
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update data pengguna di database
    $updateQuery = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssi", $newUsername, $newEmail, $hashedPassword, $user['id']);
    
    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
    } else {
        $error = "Error updating profile!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Link ke file CSS profile.css -->
    <link rel="stylesheet" href="assets/css/profile.css">
</head>
<body>
    <!-- Profile Section -->
    <div class="profile">
        <h2>Profile of <?php echo htmlspecialchars($user['username'] ?? ''); ?></h2>

        <!-- Display success or error message -->
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Profile Edit Form -->
        <form action="profile.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>

            <label for="password">New Password</label>
            <input type="password" id="password" name="password" placeholder="Enter new password" required>

            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
