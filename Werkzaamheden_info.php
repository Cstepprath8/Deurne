<?php
include('db_connect.php'); 

echo '<link rel="stylesheet" type="text/css" href="medewerkersTabel.css">';

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}



$sql = "SELECT * FROM werkzaamheden"; 
$result = $conn->query($sql);


echo "<table border='1'>";
echo "<tr>";


if ($result->num_rows > 0) {
    $columns = $result->fetch_fields();
   foreach ($columns as $column) {
    if (in_array($column->name, ['opdracht_id', 'medewerker_id' , 'ID' , 'record_id' , 'Jaar'])) continue;
    echo "<th>" . htmlspecialchars($column->name) . "</th>";
}
    echo "</tr>";

   
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
             foreach ($row as $kolom => $value) {
    if (in_array($kolom, ['opdracht_id', 'medewerker_id' , 'ID' , 'record_id' , 'Jaar'])) continue;

    echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
}
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='100%'>Geen gegevens gevonden</td></tr>";
}
echo "</table>";


$conn->close();
?>