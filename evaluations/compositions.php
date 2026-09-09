<?php
    include_once("../configuration/connexion.php");
    $idAnnee = $_GET['id'];
    $rqtComposition = "SELECT C.ID_composition, C.numero, C.date_composition, C.trimestre
                        FROM composition C
                        WHERE C.fk_id_anneeScolaire = ?;";
    $stmtComposition = $connexion->prepare($rqtComposition);
    $stmtComposition->execute([$idAnnee]);
    $liste_composition = $stmtComposition->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($liste_composition);
?>