<?php

$title = 'Modification de produit - Le Chouette Coin';
require 'includes/header.php';
// On récupère l'ID du produit avec $_GET (c'est la data ?id= dans l'adresse du lien)
$id = $_GET['id'];
//Requête  pour récupérer les données du produits
$sql1 = "SELECT p.*, c.* FROM products AS p INNER JOIN categories AS c ON p.category_id = c.categories_id WHERE p.products_id = {$id}";
//Requête pour récupérer la liste des catégories
$sql2 = 'SELECT * FROM categories';

$res1 = $conn->query($sql1);
$product = $res1->fetch(PDO::FETCH_ASSOC);
$res2 = $conn->query($sql2);
$categories = $res2->fetchAll();
?>
<div class="row">
    <div class="col-12">
        <form action="process.php" method="POST">
            <!-- On remplace les attributs PLACEHOLDER="" par VALUE="" dans lequel on met un echo 
            avec la valeur désirée correspondant au nom de la colonne dans la base de données (ici PRODUCTS) -->
            <div class="form-group">
                <label for="InputName">Nom de l'article</label>
                <input type="text" class="form-control" id="InputName"
                    value="<?php echo $product['products_name']; ?>"
                    name="product_name" required>
            </div>
            <!-- DESCRIPTION -->
            <div class="form-group">
                <label for="InputDescription">Description de l'article</label>
                <!-- Pour un textarea, on met l'echo directement 
                à l'intérieur des balises pour afficher la valeur correspondante -->
                <textarea class="form-control" id="InputDescription" rows="3" name="product_description"
                    required><?php echo $product['description']; ?></textarea>
            </div>
            <!-- PRIX -->
            <div class="form-group">
                <labEl for="InputPrice">Prix de l'article</label>
                <input type="number" max="999999" class="form-control" id="InputPrice"
                    value="<?php echo $product['price']; ?>"
                    name="product_price" required>
            </div>
            <!-- VILLE -->
            <div class="form-group">
                <label for="InputCity">Ville où l'article est situé</label>
                <input type="text" class="form-control" id="InputCity"
                    value="<?php echo $product['city']; ?>"
                    name="product_city" required>
            </div>
            <!-- CATEGORIE -->
            <div class="form-group">
                <label for="InputCategory">Catégorie de l'article</label>
                <select class="form-control" id="InputCategory" name="product_category">
                    <!-- 1ère option : Affiche la valeur (categories_name) de la table categories enregistrée pour cet article -->
                    <option
                        value="<?php echo $product['category_id']; ?>"
                        selected>
                        -- <?php echo $product['categories_name']; ?>
                        --
                    </option>
                    <?php foreach ($categories as $category) { ?>
                    <!-- 2ème option : Affiche la liste de TOUTES les catégories -->
                    <!-- Il y a un doublon avec l'option 1, c'est de la bidouille mais ça marche -->
                    <option
                        value="<?php echo $category['categories_id']; ?>">
                        <?php echo $category['categories_name']; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" name="product_id"
                value="<?php echo $product['products_id']; ?>" />
            <button type="submit" class="btn btn-success" name="product_edit">Enregistrer l'article</button>
        </form>
    </div>
</div>

<?php
require 'includes/footer.php';
