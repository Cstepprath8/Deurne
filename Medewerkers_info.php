<?php
include('db_connect.php'); 

echo '<link rel="stylesheet" type="text/css" href="medewerkersTabel.css">';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$sql = "SELECT * FROM werknemers_db"; 
$result = $conn->query($sql);

echo "<table border='1'>";
echo "<tr>";

if ($result->num_rows > 0) {
    $columns = $result->fetch_fields();

    // Tabelkoppen
    foreach ($columns as $column) {
        if ($column->name === "ID") {
            echo "<th class='hidden-column'>" . $column->name . "</th>"; // Verborgen kolom
        } else {
            echo "<th>" . $column->name . "</th>";
        }
    }
    echo "</tr>";

    // Tabelinhoud
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($columns as $column) {
            $colName = $column->name;
            $value = $row[$colName];
            if ($colName === "ID") {
                echo "<td class='hidden-column'>" . htmlspecialchars($value) . "</td>"; // Verborgen data
            } else {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='100%'>Geen gegevens gevonden</td></tr>";
}
echo "</table>";

$conn->close();
?>
