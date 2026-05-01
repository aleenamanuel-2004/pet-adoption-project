<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$page_title = 'All Adoptions - Admin';
include '../includes/header.php';

// Fetch all adoptions with breed and category info
$sql = "SELECT a.*, b.name as breed_name, c.name as category_name 
        FROM adoptions a
        JOIN breeds b ON a.breed_id = b.id
        JOIN categories c ON b.category_id = c.id
        ORDER BY a.adoption_date DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container">
    <a href="../index.php" class="back-btn">← Back to Home</a>
    
    <h1> All Adoptions</h1>
    <p class="subtitle">Total Adoptions: <?php echo mysqli_num_rows($result); ?></p>
    
    <div class="table-container">
        <table class="adoption-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pet Type</th>
                    <th>Breed</th>
                    <th>Adopter Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($adoption = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>#<?php echo $adoption['id']; ?></td>
                        <td><?php echo $adoption['category_name']; ?></td>
                        <td><?php echo $adoption['breed_name']; ?></td>
                        <td><?php echo $adoption['adopter_name']; ?></td>
                        <td><?php echo $adoption['email']; ?></td>
                        <td><?php echo $adoption['phone']; ?></td>
                        <td><?php echo $adoption['address']; ?></td>
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