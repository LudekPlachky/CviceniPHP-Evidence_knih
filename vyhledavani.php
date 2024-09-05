<?php
require_once 'db_config.php';

$page_title = "Vyhledávání knih";

$where_conditions = array();
$params = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['prijmeni'])) {
        $where_conditions[] = "Primeni LIKE ?";
        $params[] = "%" . $_POST['prijmeni'] . "%";
    }
    if (!empty($_POST['jmeno'])) {
        $where_conditions[] = "Jmeno LIKE ?";
        $params[] = "%" . $_POST['jmeno'] . "%";
    }
    if (!empty($_POST['nazev'])) {
        $where_conditions[] = "Nazev LIKE ?";
        $params[] = "%" . $_POST['nazev'] . "%";
    }
    if (!empty($_POST['isbn'])) {
        $where_conditions[] = "ISBN LIKE ?";
        $params[] = "%" . $_POST['isbn'] . "%";
    }
}

ob_start();
?>

<div class="row mb-4">
    <div class="col-12 col-md-8 col-lg-6 mx-auto">
        <form method="post" action="">
            <div class="mb-3">
                <label for="prijmeni" class="form-label">Příjmení autora</label>
                <input type="text" class="form-control" id="prijmeni" name="prijmeni">
            </div>
            <div class="mb-3">
                <label for="jmeno" class="form-label">Křestní jméno autora</label>
                <input type="text" class="form-control" id="jmeno" name="jmeno">
            </div>
            <div class="mb-3">
                <label for="nazev" class="form-label">Název knihy</label>
                <input type="text" class="form-control" id="nazev" name="nazev">
            </div>
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn">
            </div>
            <button type="submit" class="btn btn-primary">Vyhledat</button>
        </form>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM knihy";
    if (!empty($where_conditions)) {
        $sql .= " WHERE " . implode(" AND ", $where_conditions);
    }

    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>ISBN</th><th>Autor</th><th>Název knihy</th><th>Popis</th></tr></thead>";
        echo "<tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["ISBN"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["Jmeno"]) . " " . htmlspecialchars($row["Prijmeni"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["Nazev"]) . "</td>";
            echo "<td>" . htmlspecialchars(substr($row["Popis"], 0, 100)) . "...</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>Žádné knihy nebyly nalezeny</p>";
    }
}

$content = ob_get_clean();
include 'layout.php';
?>