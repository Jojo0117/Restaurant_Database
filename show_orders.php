<?php
// Include connection file
require_once('connectdb.php');

// Get the date entered by the user from the POST parameter
$date = $_POST["date"];

// Prepare the SQL query with a parameterized statement
$sql = "SELECT o.id, o.totalP, o.tip, c.fname, c.lname, e.fname AS delivery_person, GROUP_CONCAT(ctn.Food_Name SEPARATOR ', ') AS items_ordered
        FROM orders o 
        JOIN delivery d ON o.delivery = d.deliID 
        JOIN employee e ON d.deliID = e.id 
        JOIN payment ON payment.orderID = o.id
        JOIN customers c ON c.email = payment.CEmail 
        JOIN containing ctn ON ctn.orderID = o.id
        WHERE DATE(o.date) = :date
        GROUP BY o.id";

$stmt = $connection->prepare($sql);
$stmt->bindParam(':date', $date);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // output data of each row
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Order ID: " . $row["id"] . "<br>" .
             "Customer: " . $row["fname"] . " " . $row["lname"] . "<br>" .
             "Items Ordered: " . $row["items_ordered"] . "<br>" .
             "Total Amount: $" . $row["totalP"] . "<br>" .
             "Tip: $" . $row["tip"] . "<br>" .
             "Delivery Person: " . $row["delivery_person"] . "<br><br>";
    }
} else {
    echo "There is no order on this date.";
}

?>