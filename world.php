<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$country = $_GET['country'] ?? '';
$context = $_GET['context'] ?? 'countries';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($context === 'cities') {
        // Fetch cities
        if (!empty($country)) {
            // Join with countries to get cities from the country
            $stmt = $conn->prepare("SELECT c.name, c.district, c.population
                                    FROM cities c
                                    JOIN countries co ON c.country_code = co.code
                                    WHERE co.name LIKE :country");
            $stmt->execute([":country" => "%{$country}%"]);
        } else {
            // No country provided, fetch all cities 
            $stmt = $conn->query("SELECT name, district, population FROM cities");
        }

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {
            echo "<table style='border-collapse: collapse; width: 100%;'>";
            echo "<thead><tr>";
            echo "<th style='border:1px solid #000; padding:8px;'>City Name</th>";
            echo "<th style='border:1px solid #000; padding:8px;'>District</th>";
            echo "<th style='border:1px solid #000; padding:8px;'>Population</th>";
            echo "</tr></thead><tbody>";

            foreach ($results as $row) {
                echo "<tr>";
                echo "<td style='border:1px solid #000; padding:8px;'>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td style='border:1px solid #000; padding:8px;'>" . htmlspecialchars($row['district']) . "</td>";
                echo "<td style='border:1px solid #000; padding:8px;'>" . htmlspecialchars($row['population']) . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No city results found.</p>";
        }

    } else {
        // Fetch countries
        if (!empty($country)) {
            $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state 
                                    FROM countries 
                                    WHERE name LIKE :country");
            $stmt->execute([":country" => "%{$country}%"]);
        } else {
            $stmt = $conn->query("SELECT name, continent, independence_year, head_of_state FROM countries");
        }

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {
            echo "<table style='border-collapse: collapse; width: 100%;'>";
            echo "<thead><tr>";
            echo "<th style='border:1px solid #000; padding:8px;'>Country Name</th>";
            echo "<th style='border:1px solid #000; padding:8px;'>Continent</th>";
            echo "<th style='border:1px solid #000; padding:8px;'>Independence Year</th>";
            echo "<th style='border:1px solid #000; padding:8px;'>Head of State</th>";
            echo "</tr></thead><tbody>";

            foreach ($results as $row) {
                echo "<tr>";
                echo "<td style='border:1px solid #000; padding:8px;'>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td style='border:1px solid #000; padding:8px;'>" . htmlspecialchars($row['continent']) . "</td>";
                echo "<td style='border:1px solid #000; padding:8px;'>" . htmlspecialchars($row['independence_year']) . "</td>";
                echo "<td style='border:1px solid #000; padding:8px;'>" . htmlspecialchars($row['head_of_state']) . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No country results found.</p>";
        }
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
