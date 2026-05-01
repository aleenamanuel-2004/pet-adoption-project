<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$page_title = 'Admin Dashboard';
include '../includes/header.php';

// Get statistics
$total_adoptions = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM adoptions"));
$total_breeds = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM breeds"));
$total_categories = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM categories"));

// Get recent adoptions
$sql_recent = "SELECT a.*, b.name as breed_name, c.name as category_name 
               FROM adoptions a
               JOIN breeds b ON a.breed_id = b.id
               JOIN categories c ON b.category_id = c.id
               ORDER BY a.adoption_date DESC
               LIMIT 5";
$result_recent = mysqli_query($conn, $sql_recent);
?>

<div class="container">
    <div class="admin-header">
        <h1> Admin Dashboard</h1>
        <div class="admin-info">
            <span>Welcome, <strong><?php echo $_SESSION['admin_username']; ?></strong></span>
            <a href="logout.php" class="logout-btn">Logout</a>
            <a href="index.php" class="back-btn">← Dashboard</a>
        <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
    <h1>📋 All Adoptions</h1>
    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">🐾</div>
            <div class="stat-info">
                <h3><?php echo $total_adoptions; ?></h3>
                <p>Total Adoptions</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🏷️</div>
            <div class="stat-info">
                <h3><?php echo $total_breeds; ?></h3>
                <p>Total Breeds</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">📁</div>
            <div class="stat-info">
                <h3><?php echo $total_categories; ?></h3>
                <p>Categories</p>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2>Quick Actions</h2>
        <div class="action-buttons">
            <a href="view_adoptions.php" class="action-btn">
                <span class="btn-icon">📋</span>
                View All Adoptions
            </a>
            <a href="../index.php" class="action-btn">
                <span class="btn-icon">🏠</span>
                Visit Website
            </a>
        </div>
    </div>
    
    <!-- Recent Adoptions -->
    <div class="recent-adoptions">
        <h2>Recent Adoptions</h2>
        <table class="adoption-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pet Type</th>
                    <th>Breed</th>
                    <th>Adopter</th>
                    <th>Email</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($adoption = mysqli_fetch_assoc($result_recent)): ?>
                    <tr>
                        <td>#<?php echo $adoption['id']; ?></td>
                        <td><?php echo $adoption['category_name']; ?></td>
                        <td><?php echo $adoption['breed_name']; ?></td>
                        <td><?php echo $adoption['adopter_name']; ?></td>
                        <td><?php echo $adoption['email']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($adoption['adoption_date'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
mysqli_close($conn);
include '../includes/footer.php';
?>