<?php
require_once 'includes/config.php';

// Get category ID from URL
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Fetch category info
$sql_cat = "SELECT * FROM categories WHERE id = $category_id";
$result_cat = mysqli_query($conn, $sql_cat);
$category = mysqli_fetch_assoc($result_cat);

if (!$category) {
    header('Location: index.php');
    exit;
}

$page_title = $category['name'] . ' - Pet Adoption';
include 'includes/header.php';

// Fetch breeds for this category
$sql_breeds = "SELECT * FROM breeds WHERE category_id = $category_id";
$result_breeds = mysqli_query($conn, $sql_breeds);
?>

<div class="container">
    <a href="index.php" class="back-btn">← Back to Categories</a>
    
    <h1>Choose Your <?php echo $category['name']; ?></h1>
    <p class="subtitle">Select a breed to adopt</p>
    
    <div class="breeds">
        <?php while($breed = mysqli_fetch_assoc($result_breeds)): ?>
            <a href="adopt.php?breed_id=<?php echo $breed['id']; ?>" class="breed-link">
                <div class="breed-card">
                    <div class="breed-image">
                        <img src="images/breeds/<?php echo strtolower($category['name']); ?>/<?php echo $breed['image']; ?>" alt="<?php echo $breed['name']; ?>">
                    </div>
                    <h3><?php echo $breed['name']; ?></h3>
                    <p>Click to adopt</p>
                </div>
            </a>
        <?php endwhile; ?>
    </div>
</div>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>