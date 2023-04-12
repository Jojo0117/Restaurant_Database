<?php
// Include connection file
require_once('connectdb.php');

// Get the employee ID selected by the user
$employee_id = $_POST["employee"];

// Prepare the SQL query with a parameterized statement
$sql = "SELECT days, starttime, endtime
        FROM shift
        WHERE EID = :employee_id";

$stmt = $connection->prepare($sql);
$stmt->bindParam(':employee_id', $employee_id);
$stmt->execute();

// Check if any schedules were found
if ($stmt->rowCount() > 0) {
    // Output the schedules for each day
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Split the days string into an array based on the comma separator
        $days_array = explode(',', $row['days']);

        // Loop through the days in the array
        foreach ($days_array as $day) {
            // Trim any extra spaces from the day string
            $day = trim($day);

            // Check if the day is Monday-Friday
            if ($day == "Monday" || $day == "Tuesday" || $day == "Wednesday" || $day == "Thursday" || $day == "Friday") {
                echo "Day: " . $day . "<br>" .
                     "Start Time: " . $row["starttime"] . "<br>" .
                     "End Time: " . $row["endtime"] . "<br><br>";
            }
        }
    }
} else {
    echo "No schedules found for this employee.";
}
?>

