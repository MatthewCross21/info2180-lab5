<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$country = $_GET['country'] ?? ''; // used to set an empty string

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Configure PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($country)) {
        // If country parameter is given, search using a LIKE query
        $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country");
        $stmt->execute([":country" => "%{$country}%"]);
    } else {
        // If no country is searched, select all countries
        $stmt = $conn->query("SELECT name, continent, independence_year, head_of_state FROM countries");
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<?php if (!empty($results)): ?>
<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th style="border: 1px solid #000; padding: 8px;">Country Name</th>
            <th style="border: 1px solid #000; padding: 8px;">Continent</th>
            <th style="border: 1px solid #000; padding: 8px;">Independence Year</th>
            <th style="border: 1px solid #000; padding: 8px;">Head of State</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($results as $row): ?>
        <tr>
            <td style="border: 1px solid #000; padding: 8px;"><?= htmlspecialchars($row['name']) ?></td>
            <td style="border: 1px solid #000; padding: 8px;"><?= htmlspecialchars($row['continent']) ?></td>
            <td style="border: 1px solid #000; padding: 8px;"><?= htmlspecialchars($row['independence_year']) ?></td>
            <td style="border: 1px solid #000; padding: 8px;"><?= htmlspecialchars($row['head_of_state']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>No results found.</p>
<?php endif; ?>


<ul>
<?php foreach ($results as $row): ?>
  <li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
<?php endforeach; ?>
</ul>
