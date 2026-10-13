<?php
    include_once('../includes/auth_check.php');
    include_once('../configuration/connexion.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_enseignant = $_POST['id_enseignant'] ?? '';
        $action = $_POST['action'] ?? '';
        if ((filter_var($id_enseignant, FILTER_VALIDATE_INT) && $id_enseignant > 0) && ($action === 'activer' || $action === 'desactiver')) {
            try {
                if ($action === "activer") {
                    $rqtModifierStatut = "UPDATE ENSEIGNANT SET statut = ? WHERE ID_enseignant = ?";
                    $stmtModifierStatut = $connexion->prepare($rqtModifierStatut);
                    $stmtModifierStatut->execute(['actif', $id_enseignant]);
                    $_SESSION['message'] = "Le statut a été modifié avec succès.";
                    $_SESSION['type_message'] = "success";
                }elseif($action === "desactiver"){
                    $rqtModifierStatut = "UPDATE ENSEIGNANT SET statut = ? WHERE ID_enseignant = ?";
                    $stmtModifierStatut = $connexion->prepare($rqtModifierStatut);
                    $stmtModifierStatut->execute(['inactif', $id_enseignant]);
                    $_SESSION['message'] = "Le statut a été modifié avec succès.";
                    $_SESSION['type_message'] = "success";
                }
            } catch (PDOException $e) {
                $_SESSION['message'] = "Une erreur est survenue lors de la modification du statut.";
                $_SESSION['type_message'] = "danger";
            }
        }else{
            $_SESSION['message'] = "Erreur.";
            $_SESSION['type_message'] = "danger";
        }
        header("Location: ../enseignants/liste.php");
        exit();
    }
?>