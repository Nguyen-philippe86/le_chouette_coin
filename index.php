<?php
    $title = 'Accueil - Le Chouette Coin';
    require 'includes/header.php';
?>

<div class="jumbotron-fluid">
    <div class="container">
        <h1 class="display-3">Bienvenue sur le Chouette Coin !</h1>
        <h3 class="lead">Votre site d'annonces entre particuliers</h3>
        <?php
            if (!isset($_SESSION['id'])) {
                ?>
        <a href="signin.php" class="btn btn-primary mt-2">Se connecter !</a>
        <?php
            }
        ?>
    </div>
</div>

<?php
    require 'includes/footer.php';
