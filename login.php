<?php
require_once '../includes/config.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

// Process login form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // Using MD5 for simplicity
    
    $sql = "SELECT * FROM admin_users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password!';
    }
}

$page_title = 'Admin Login';
include '../includes/header.php';
?>

<div class="container">
    <div class="login-container">
        <div class="login-box">
            <h1>🔐 Admin Login</h1>
            <p class="subtitle">Pet Adoption Center</p>
            
            <?php if ($error): ?>
                <div class="error-message">
                    ⚠️ <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required autofocus>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" name="login" class="submit-btn">Login</button>
            </form>
            
            <div class="login-footer">
                <a href="../index.php" class="back-link">← Back to Home</a>
            </div>
            
            <div class="default-credentials">
                <p><strong>Default Login:</strong></p>
                <p>Username: admin</p>
                <p>Password: admin123</p>
            </div>
        </div>
    </div>
</div>

<?php
mysqli_close($conn);
include '../includes/footer.php';
?>