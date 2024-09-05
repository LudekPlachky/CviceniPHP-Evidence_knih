<?php
require_once 'db_config.php';

$page_title = "Přehled knih";

$sql = "SELECT * FROM knihy";
$result = $conn->query($sql);

ob_start();
?>
<div class="table-responsive">
<table class="table table-striped">
    <thead>
        <tr>
            <th>ISBN</th>
            <th>Autor</th>
            <th>Název knihy</th>
            <th>Popis</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["ISBN"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Jmeno"]) . " " . htmlspecialchars($row["Prijmeni"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Nazev"]) . "</td>";
                echo "<td>" . htmlspecialchars(substr($row["Popis"], 0, 100)) . "...</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Žádné knihy nebyly nalezeny</td></tr>";
        }
        ?>
    </tbody>
</table>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>