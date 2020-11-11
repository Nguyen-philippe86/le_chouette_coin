<?php
    $title = 'Produits - Le Chouette Coin';
    require 'includes/header.php';
    $user_id = $_SESSION['id'];

    $sql = "SELECT * FROM users WHERE id = '{$user_id}'";
    $res = $conn->query($sql);
    $user = $res->fetch(PDO::FETCH_ASSOC);
?>

<h3>Bienvenue <?php echo $user['username']; ?>
</h3>

<form action="process.php" method="post">
    <div class="form-group">
        <label for="InputPhone1">Votre numéro de téléphone</label>
        <input class="form-control" type="tel" name="user_phone" id="InputPhone1"
            value="<?php echo $user['phone']; ?>"
            pattern="[0-9]{10,}" title="Un numéro de téléphone à 9 chiffres minimum sans indicatif">
    </div>
    <input type="hidden" name="user_id"
        value="<?php echo $user['id']; ?>">
    <input type="submit" class="btn btn-success" name="user_edit" value="Mettre à jour">
</form>

<hr>
<h2>Vos produits</h2>
<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Nom du produit</th>
            <th scope="col">Description</th>
            <th scope="col">Prix</th>
            <th scope="col">Ville</th>
            <th scope="col">Categorie</th>
            <th scope="col" colspan=3>Fonctions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            affichageProduitsByUser($user_id);
        ?>
    </tbody>
</table>

<?php
    require 'includes/footer.php';
