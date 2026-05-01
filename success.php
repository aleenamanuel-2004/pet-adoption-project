<?php
require_once 'includes/config.php';

// Check if we have session data
if (!isset($_SESSION['adoption_id'])) {
    header('Location: index.php');
    exit;
}

// Get breed name
$breed_id = $_SESSION['breed_id'];
$sql = "SELECT name FROM breeds WHERE id = $breed_id";
$result = mysqli_query($conn, $sql);
$breed = mysqli_fetch_assoc($result);

$page_title = 'Adoption Successful!';
include 'includes/header.php';
?>

<div class="container">
    <div class="success-message">
        <h2>🎉 Congratulations!</h2>
        <p>You have successfully adopted a <strong><?php echo $breed['name']; ?></strong>!</p>
        <p>Your pet is on its way to you, <?php echo $_SESSION['adopter_name']; ?>!</p>
        <p>We will contact you at <strong><?php echo $_SESSION['email']; ?></strong> with delivery details.</p>
        <p class="adoption-id">Your adoption ID: <strong>#<?php echo $_SESSION['adoption_id']; ?></strong></p>
        <a href="index.php" class="submit-btn">Adopt Another Pet</a>
    </div>
</div>

<?php
// Clear session data
unset($_SESSION['adoption_id']);
unset($_SESSION['breed_id']);
unset($_SESSION['adopter_name']);
unset($_SESSION['email']);

mysqli_close($conn);
include 'includes/footer.php';
?>