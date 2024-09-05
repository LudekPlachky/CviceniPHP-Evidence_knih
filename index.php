<?php
require_once 'db_config.php';

$page_title = "Vkládání nových knih";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $jmeno = $conn->real_escape_string($_POST['jmeno']);
    $prijmeni = $conn->real_escape_string($_POST['prijmeni']);
    $nazev = $conn->real_escape_string($_POST['nazev']);
    $popis = $conn->real_escape_string($_POST['popis']);

    $sql = "INSERT INTO knihy (ISBN, Jmeno, Prijmeni, Nazev, Popis) VALUES ('$isbn', '$jmeno', '$prijmeni', '$nazev', '$popis')";

    if ($conn->query($sql) === TRUE) {
        $message = "Nová kniha byla úspěšně přidána.";
    } else {
        $message = "Chyba: " . $sql . "<br>" . $conn->error;
    }
}

ob_start();
?>

<div class="row">
    <div class="col-12 col-md-8 col-lg-6 mx-auto">
        <?php
        if (isset($message)) {
            echo "<div class='alert alert-info'>$message</div>";
        }
        ?>
        <form method="post" action="">
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>
            <div class="mb-3">
                <label for="jmeno" class="form-label">Křestní jméno autora</label>
                <input type="text" class="form-control" id="jmeno" name="jmeno" required>
            </div>
            <div class="mb-3">
                <label for="prijmeni" class="form-label">Příjmení autora</label>
                <input type="text" class="form-control" id="prijmeni" name="prijmeni" required>
            </div>
            <div class="mb-3">
                <label for="nazev" class="form-label">Název knihy</label>
                <input type="text" class="form-control" id="nazev" name="nazev" required>
            </div>
            <div class="mb-3">
                <label for="popis" class="form-label">Popis</label>
                <textarea class="form-control" id="popis" name="popis" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Přidat knihu</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>