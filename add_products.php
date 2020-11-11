<?php

$title = 'Ajout de produits - Le Chouette Coin';
require 'includes/header.php';

$sql = 'SELECT * FROM categories';
$res = $conn->query($sql);
$categories = $res->fetchAll();
?>
<div class="row">
    <div class="col-12">
        <form action="process.php" method="POST">
            <div class="form-group">
                <label for="InputName">Nom de l'article</label>
                <input type="text" class="form-control" id="InputName" placeholder="Nom de votre article"
                    name="product_name" required>
            </div>
            <div class="form-group">
                <label for="InputDescription">Description de l'article</label>
                <textarea class="form-control" id="InputDescription" rows="3" name="product_description"
                    required></textarea>
            </div>
            <div class="form-group">
                <label for="InputPrice">Prix de l'article</label>
                <input type="number" max="999999" class="form-control" id="InputPrice"
                    placeholder="Prix de votre article en €" name="product_price" required>
            </div>
            <div class="form-group">
                <label for="InputPrice">Ville où l'article est situé</label>
                <input type="text" class="form-control" id="InputPrice" placeholder="Ville où l'article est situé"
                    name="product_city" required>
            </div>
            <div class="form-group">
                <label for="InputCategory">Catégorie de l'article</label>
                <select class="form-control" id="InputCategory" name="product_category">
                    <?php foreach ($categories as $category) { ?>
                    <option
                        value="<?php echo $category['categories_id']; ?>">
                        <?php echo $category['categories_name']; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success" name="product_submit">Enregistrer l'article</button>
        </form>
    </div>
</div>

<?php
require 'includes/footer.php';
