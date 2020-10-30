<?php
include "Database.php";
$mydb = new Database('rest');
if (isset($_POST["posalji"]) && $_POST["posalji"] = "Posalji zahtev") {
    if ($_POST["naslov_novosti"] != null && $_POST["tekst_novosti"] != null && $_POST["kategorija_odabir"] != null) {
        $niz = ["naslov" => "'" . $_POST["naslov_novosti"] . "'", "tekst" => "'" . $_POST["tekst_novosti"] . "'", "datumvreme" => "NOW()", "kategorija_id" => $_POST["kategorija_odabir"]];
        if ($mydb->insert("novosti", "naslov, tekst, datumvreme, kategorija_id", $niz)) {
            echo "vrednosti ubacene";
        } else {
            echo "vrednosti nisu ubacene";
        }
        $_POST = array();
        exit();
    } elseif ($_POST["brisanje"] != null && $_POST["odabir_tabele"] != null) {
        $tabela = $_POST["odabir_tabele"];
        $id = "id";
        $id_val = $_POST["brisanje"];
        if ($mydb->delete($tabela, $id, $id_val)) {
            echo "red obrisan";
        } else {
            echo "greska prilikom brisanja";
        }
        echo $_POST["odabir_tabele"];
        echo $_POST["http_zahtev"];
        $_POST = array();
        exit();
    } elseif ($_POST["odabir_tabele"] != null && $_POST["http_zahtev"]  != null) {
        if ($_POST["odabir_tabele"] == "kategorije" && $_POST["http_zahtev"] == "get") {
            $mydb->select("kategorije", "*", null, null, null);
            echo "Kategorije: " . "<br>";
            while ($red = $mydb->getResult()->fetch_object()) {
                echo "id kategorije: " . $red->id . ", naziv: " . $red->kategorija . "<br>";
            }
            $_POST = array();
            exit();
        } else if ($_POST["odabir_tabele"] == "novosti" && $_POST["http_zahtev"] == "get") {
            $mydb->select();
            echo "Novosti: " . "<br>";
            while ($red = $mydb->getResult()->fetch_object()) {
                echo "id novosti: " . $red->id . ", naslov: " . $red->naslov . ", <br>" . "tekst: " . $red->tekst . ", datum i vreme: " . $red->datumvreme . ", kategorija_id: " . $red->kategorija_id . "<br>";
            }
            $_POST = array();
            exit();
        }
    }
}
