<?php
    include_once('../includes/auth_check.php');
    include_once('../configuration/connexion.php');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: liste.php");
        exit();
    }

    $id = $_POST['id'] ?? '';
    if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
        $_SESSION['message'] = "Identifiant invalide.";
        $_SESSION['type_message'] = "danger";
        header("Location: liste.php");
        exit();
    }else{
        $id = (int) $id;
        $rqtClasse = "SELECT C.Id_classe, A.statut, C.fk_id_anneeScolaire
                        FROM CLASSE C
                        INNER JOIN ANNEE_SCOLAIRE A ON C.fk_id_anneeScolaire = A.Id_anneeScolaire
                        WHERE C.Id_classe = ?;";
        $stmtClasse = $connexion->prepare($rqtClasse);
        $stmtClasse->execute([$id]);
        $classe = $stmtClasse->fetch(PDO::FETCH_ASSOC);
        if($classe === false){
            $_SESSION['message'] = "Classe introuvable.";
            $_SESSION['type_message'] = "danger";
            header("Location: liste.php");
            exit();
        }else{
            if ($classe['statut'] !== 'active') {
                $_SESSION['message'] = "Impossible de supprimer une classe appartenant à une année scolaire non active.";
                $_SESSION['type_message'] = "danger";
                header("Location: liste.php");
                exit();
            }
            $rqtVerifInscription = "SELECT 1
                                    FROM INSCRIPTION
                                    WHERE fk_id_classe = ? AND fk_id_anneeScolaire = ?
                                    LIMIT 1;";
            $stmtVerifInscription = $connexion->prepare($rqtVerifInscription);
            $stmtVerifInscription->execute([$id, $classe['fk_id_anneeScolaire']]);
            $inscription = $stmtVerifInscription->fetch(PDO::FETCH_ASSOC);
            if ($inscription !== false) {
                $_SESSION['message'] = "Impossible de supprimer cette classe car elle contient déjà au moins une inscription.";
                $_SESSION['type_message'] = "danger";
                header("Location: liste.php");
                exit();
            }else{
                try {
                    $connexion->beginTransaction();
                    $rqtSupprimer = "DELETE FROM CLASSE WHERE Id_classe = ?;";
                    $stmtSupprimer = $connexion->prepare($rqtSupprimer);
                    $stmtSupprimer->execute([$id]);
                    $connexion->commit();
                    $_SESSION['message'] = "Classe supprimée avec succès.";
                    $_SESSION['type_message'] = "success";
                    header("Location: liste.php");
                    exit();
                } catch (PDOException $e) {
                    if ($connexion->inTransaction()) {
                        $connexion->rollBack();
                    }
                    $_SESSION['message'] = "Une erreur est survenue lors de la suppression.";
                    $_SESSION['type_message'] = 'danger';
                    header("Location: liste.php");
                    exit();
                }

            }
        }
    }
    
?>