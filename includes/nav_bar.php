<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Le chouette coin</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="products.php">Produits</a>
            </li>
        </ul>

        <ul class=navbar-nav>
            <?php
            if (!empty($_SESSION)) {
                ?>
            <div class="dropdown nav-item dropleft">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['username']; ?></a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="profil.php">Profil</a>
                    <a class="dropdown-item" href="addproducts.php">Ajouter un produit</a>
                    <hr>
                    <a class="dropdown-item" href="?logout">Déconnexion</a>
                </div>
                <?php
            } else {
                ?>

                <li class="nav-item">
                    <a href="signin.php" class="nav-link">S'identifier</a>
                </li>
                <?php
            }
                 ?>
            </div>
        </ul>
    </div>
</nav>