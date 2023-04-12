<?php
			require 'connectdb.php';

			$query = "SELECT date as order_date, COUNT(*) AS total_orders FROM orders GROUP BY order_date";
			$stmt = $connection->prepare($query);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach ($results as $result) {
				echo "<tr>";
				echo "<td>" . $result['order_date'] . "</td>";
				echo "<td>" . $result['total_orders'] . "</td>";
				echo "</tr>";
			}

			$connection = null; // close the database connection
		?>