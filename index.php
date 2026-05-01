<?php
require_once 'includes/config.php';
$page_title = 'Pet Adoption Center - Home';
include 'includes/header.php';

// Fetch categories from database
$sql = "SELECT * FROM categories";
$result = mysqli_query($conn, $sql);
?>

<div class="container">
    <h1>🐾 Pet Adoption Center</h1>
    <p class="subtitle">Find your perfect companion today!</p>
    
    <div class="categories">
        <?php while($category = mysqli_fetch_assoc($result)): ?>
            <a href="breeds.php?category_id=<?php echo $category['id']; ?>" class="category-link">
                <div class="category-card">
                    <div class="category-image">
                        <img src="images/categories/<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>">
                    </div>
                    <h2><?php echo $category['name']; ?></h2>
                    <p><?php echo $category['description']; ?></p>
                </div>
            </a>
        <?php endwhile; ?>
    </div>
    
    <div style="text-align: center; margin-top: 30px;">
        <a href="admin/login.php" class="admin-link">Admin Login</a>
    </div>
</div>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>