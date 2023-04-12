<?php
require 'connectdb.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $cell = $_POST['cell'];
    $street = $_POST['street'];
    $city = $_POST['city'];

    // Check if customer already exists
    $stmt = $connection->prepare("SELECT * FROM customers WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Customer already exists
        echo "Customer already exists";
    } else {
        // Create new account
        $stmt = $connection->prepare("INSERT INTO customers (fname, lname, email, cell, street, city, credit) VALUES (:fname, :lname, :email, :cell, :street, :city, 5.00)");
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cell', $cell);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':city', $city);

        if ($stmt->execute()) {
            echo "Account created successfully";
        } else {
            echo "Error creating account";
        }
    }
}
?>
