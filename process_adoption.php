<?php
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_adoption'])) {
    // Sanitize input
    $breed_id = intval($_POST['breed_id']);
    $adopter_name = mysqli_real_escape_string($conn, $_POST['adopter_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // Insert into database
    $sql = "INSERT INTO adoptions (breed_id, adopter_name, email, phone, address) 
            VALUES ($breed_id, '$adopter_name', '$email', '$phone', '$address')";
    
    if (mysqli_query($conn, $sql)) {
        // Get the inserted ID
        $adoption_id = mysqli_insert_id($conn);
        
        // Store in session for success page
        $_SESSION['adoption_id'] = $adoption_id;
        $_SESSION['breed_id'] = $breed_id;
        $_SESSION['adopter_name'] = $adopter_name;
        $_SESSION['email'] = $email;
        
        // Redirect to success page
        header('Location: success.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header('Location: index.php');
    exit;
}

mysqli_close($conn);
?>