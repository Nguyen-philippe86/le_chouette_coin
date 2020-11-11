<?php

    $title = 'Processing - Le Chouette Coin';
    require 'includes/header.php';

    //VERROUILLAGE D'ACCES : Est-ce que le moyen d'accéder à cette page est différent d'une méthode POST (formulaire) ?
    if ('POST' != $_SERVER['REQUEST_METHOD']) {
        // méthode d'accès différente -> Page inaccessible, message d'erreur
        echo "<div class='alert alert-danger'> La page à laquelle vous tentez d'accéder n'existe pas </div>";

    //Méthode d'accès valide (POST)

    // Le 1er elseif va servir au traitement du formulaire de création de produits
    } elseif (isset($_POST['product_submit'])) { // Est-ce que l'utilisateur veut envoyer la création du formulaire ?
        // Si oui -> Est-ce que TOUS les champs ont été renseignés ?
        if (!empty($_POST['product_name']) && !empty($_POST['product_description']) && !empty($_POST['product_price']) && !empty($_POST['product_city']) && !empty(['product_category'])) {
            //Si oui -> création des variables avec les données entrées dans le formulaire
            $name = strip_tags($_POST['product_name']);
            $description = strip_tags($_POST['product_description']);
            $price = intval(strip_tags($_POST['product_price']));
            $city = strip_tags($_POST['product_city']);
            $category = strip_tags($_POST['product_category']);
            $user_id = $_SESSION['id']; // Seule la variable user_id correspond à l'ID de la session en cours (donc de l'utilisateur connecté qui crée l'annonce)
            ajoutProduits($name, $description, $price, $city, $category, $user_id); //Exécution de la fonction ajoutProduits
        } else {
            echo "<div class='alert alert-danger'> Tous les champs sont requis !</div>";
        }
        // 2ème elseif sert au traitement de modification du formulaire
    } elseif (isset($_POST['product_edit'])) {
        // Si oui -> Est-ce que TOUS les champs d'édition ont été renseignés ?
        if (!empty($_POST['product_name']) && !empty($_POST['product_description']) && !empty($_POST['product_price']) && !empty($_POST['product_city']) && !empty(['product_category'])) {
            //Si oui -> création des variables avec les données entrées dans le formulaire
            $name = strip_tags($_POST['product_name']);
            $description = strip_tags($_POST['product_description']);
            $price = intval(strip_tags($_POST['product_price']));
            $city = strip_tags($_POST['product_city']);
            $category = strip_tags($_POST['product_category']);
            $user_id = $_SESSION['id']; // Seule la variable user_id correspond à l'ID de la session en cours (donc de l'utilisateur connecté qui crée l'annonce)
            $id = strip_tags($_POST['product_id']);

            modifProduits($name, $description, $price, $city, $category, $id, $user_id);
        }
        //3eme elseif -> SUPPRESSION DE PRODUIT
    } elseif (isset($_POST['product_delete'])) {
        // echo "<div class='alert alert-danger'> Vous tentez de supprimer l'article n°".$_POST['product_id'].'</div>';

        try {
            $sth = $conn->prepare('DELETE FROM products WHERE products_id = :products_id AND user_id =:user_id');
            $sth->bindValue(':products_id', $_POST['product_id']);
            $sth->bindValue(':user_id', $_SESSION['id']);
            $sth->execute();

            echo "<div class='alert alert-danger'> Vous avez supprimé l'article n°".$_POST['product_id'].'</div>';
        } catch (PDOException $e) {
            echo 'Error: '.$e->getMessage();
        }
        // MODIFICATION NUMEROS DE PHONE
    } elseif (isset($_POST['user_edit'])) {
        try {
            $sth = $conn->prepare('UPDATE users SET phone=:phone WHERE id=:user_id');
            $sth->bindValue(':phone', $_POST['user_phone']);
            $sth->bindValue(':user_id', $_POST['user_id']);
            if ($sth->execute()) {
                echo "<div class='alert alert-success'> Vous avez mis à jour le numéro de téléphone avec ".$_POST['user_phone']."</div>'";
            }
        } catch (PDOException $e) {
            echo 'Error: '.$e->getMessage();
        }
    } elseif (isset($_POST['user_edit2'])) {
        $user_id = $_POST['user_id'];
        $phone = $_POST['user_phone'];
        // echo "Tu essaie de modifier le téléphone de l'utilisateur ".$_POST['user_id'].' avec le numéro '.$_POST['user_phone'].' ! ';
        try {
            $sth = $conn->prepare('UPDATE users SET phone=:phone WHERE id=:user_id');
            $sth->bindValue(':phone', $phone);
            $sth->bindValue(':user_id', $user_id);

            if ($sth->execute()) {
                echo "<div class='alert alert-success'> Vous avez bien mis à jour votre numéro de téléphone ! </div>";
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    require 'includes/footer.php';
