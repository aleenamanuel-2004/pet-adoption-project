<?php
require_once 'includes/config.php';

// Get breed ID from URL
$breed_id = isset($_GET['breed_id']) ? intval($_GET['breed_id']) : 0;

// Fetch breed info with category
$sql = "SELECT b.*, c.name as category_name 
        FROM breeds b 
        JOIN categories c ON b.category_id = c.id 
        WHERE b.id = $breed_id";
$result = mysqli_query($conn, $sql);
$breed = mysqli_fetch_assoc($result);

if (!$breed) {
    header('Location: index.php');
    exit;
}

$page_title = 'Adopt ' . $breed['name'];
include 'includes/header.php';
?>

<div class="container">
    <a href="breeds.php?category_id=<?php echo $breed['category_id']; ?>" class="back-btn">← Back to Breeds</a>
    
    <div class="pet-info">
        <div class="pet-info-image">
            <img src="images/breeds/<?php echo strtolower($breed['category_name']); ?>/<?php echo $breed['image']; ?>" alt="<?php echo $breed['name']; ?>">
        </div>
        <h3>Adopt a <?php echo $breed['name']; ?></h3>
        <p>Fill out the form below to complete your adoption</p>
    </div>
    
    <div class="form-container">
        <form method="POST" action="process_adoption.php">
            <input type="hidden" name="breed_id" value="<?php echo $breed['id']; ?>">
            
            <div class="form-group">
                <label>Your Full Name *</label>
                <input type="text" name="adopter_name" required>
            </div>
            
            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Phone Number *</label>
                <input type="tel" name="phone" required>
            </div>
            
            <div class="form-group">
                <label>Full Address *</label>
                <textarea name="address" rows="3" required></textarea>
            </div>
            
            <button type="submit" name="submit_adoption" class="submit-btn">Complete Adoption</button>
        </form>
    </div>
</div>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>