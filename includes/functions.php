<?php
// FACTORISATION DU CODE
require 'includes/config.php';
// FONCTION D'INSCRIPTION
function inscription($email, $username, $password1, $password2) //Création de la fonction avec les paramètres requis entre ()
{
    global $conn;

    try { //La série de tests
        $sql1 = "SELECT * FROM users WHERE email = '{$email}'"; //Requête sur email dans la base de donnée
        $sql2 = "SELECT * FROM users WHERE username = '{$username}'"; //Requête sur username dans la base de donnée
        $res1 = $conn->query($sql1); //Lance la requête sur la BDD
        $count_email = $res1->fetchColumn();
        if (!$count_email) { //vérification si l'email n'existe pas déjà
            //l'email n'existe pas déjà
            $res2 = $conn->query($sql2);
            $count_user = $res2->fetchColumn();
            if (!$count_user) { //vérification si utilisateur n'existe pas déjà
                //l'utilisateur n'existe pas
                // LA PARTIE IMPORTANTE APRES LES 2 VERIFICATIONS
                if ($password1 === $password2) { //Le mot de passe et sa confirmation sont-ils identiques ?
                    $password1 = password_hash($password1, PASSWORD_DEFAULT);
                    $sth = $conn->prepare('INSERT INTO users (email, username, password) VALUES (:email, :username, :password)');
                    $sth->bindValue(':email', $email); //On lie la valeur :email de la requête à la variable
                    $sth->bindValue(':username', $username);
                    $sth->bindValue(':password', $password1);
                    $sth->execute();
                    echo '<div class="alert alert-success mt-2" role="alert">L\'utilisateur est bien enregistré !</div>';
                } else { //mots de passe différents
                    echo '<div class="alert alert-danger mt-2" role="alert">Les mots de passes ne sont pas identiques !</div>';
                }
            } elseif ($count_user > 0) { //L'utilisateur existe déjà
                echo '<div class="alert alert-danger mt-2" role="alert">Cet utilisateur existe déjà !</div>';
            }
        } elseif ($count_email > 0) { // Le mail existe déjà
            echo '<div class="alert alert-danger mt-2" role="alert">Cette adresse mail existe déjà !</div>';
        }
    } catch (PDOException $e) {
        echo 'Error : '.$e->getMessage();
    }
}
// FONCTION DE CONNEXION
function connexion($email, $password)
{
    global $conn;

    try {
        $sql = "SELECT * FROM users WHERE email = '{$email}'"; //Requête SQL - On cherche un email dans tous les users
        $res = $conn->query($sql);
        $user = $res->fetch(PDO::FETCH_ASSOC);
        if ($user) { //L'utilisateur (adresse email) existe-t-il dans la base de données ?
            $db_password = $user['password'];
            if (password_verify($password, $db_password)) { //Le mot de passe enoyé correspond-il au mot de passe de la base de données ?
                $_SESSION['id'] = $user['id']; //Si oui     -> l'ID de la Session devient l'ID de l'utilisateur
                $_SESSION['email'] = $user['email']; //      -> l'email de la Session devient l'email de l'utilisateur
                $_SESSION['username'] = $user['username']; //-> le Username de la Session devient le Username de l'utilisateur
                echo '<div class="alert alert-success mt-2" role="alert">Vous êtes connecté !</div>';
                header('Location:index.php');
            } else { // Le mot de passe envoyé ne correspond pas au mot de passe de la BDD
                echo '<div class="alert alert-danger mt-2" role="alert">Mot de passe erroné !</div>';
                unset($_POST);
            }
        } else { // L'adresse email n'existe pas dans la BDD
            echo '<div class="alert alert-danger mt-2" role="alert">Adresse mail non reconnue !</div>';
            unset($_POST);
        }
    } catch (PDOException $e) {// Là c'est quand c'est la merde
        echo 'Error : '.$e->getMessage();
    }
}
// FONCTION D'AFFICHAGE DE L'UTILISATEUR
function affichageUsers()
{
    global $conn;
    $sth = $conn->prepare('SELECT * FROM users');
    $sth->execute();

    $users = $sth->fetchALL(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        // Pour chaque utilisateur ($user) de la table $users ...
        // ... on crée les éléments HTML suivant :?>
<tr>
    <th scope="row">
        <?php echo $user['id']; ?>
    </th>
    <td>
        <?php echo $user['email']; ?>
    </td>
    <td>
        <?php echo $user['username']; ?>
    </td>
    <td>
        <?php echo $user['password']; ?>
    </td>
</tr>
<?php
    }
}
// FONCTION D'AFFICHAGE UTILISATEUR ACTIF
function affichageActiveUser($user_id)
{
    global $conn;
    $sth = $conn->prepare("SELECT * FROM users WHERE id = {$user_id}");
    $sth->execute();

    $user = $sth->fetch(PDO::FETCH_ASSOC); ?>
<table class="table">
    <tbody>
        <tr>
            <th scope="col">Username</th>
            <td scope="col"><?php echo $user['username']; ?>
            </td>
        </tr>
        <tr>
            <th scope="col">phone</th>
            <td scope="col"><?php echo $user['phone']; ?>
            </td>
        </tr>
        <tr>
            <th scope="col">Email</th>
            <td scope="col"><?php echo $user['email']; ?>
            </td>
        </tr>
    </tbody>
</table>
<?php
}
// FONCTION D'AFFICHAGE DE LA LISTE DES PRODUITS
function affichageProduits()
{
    global $conn;
    // Requête SQL
    $sth = $conn->prepare('SELECT p.*,c.categories_name,u.username FROM products AS p LEFT JOIN categories AS c ON p.category_id = c.categories_id LEFT JOIN users AS u ON p.user_id = u.id');
    $sth->execute(); //Exécution de requête

    $products = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as $product) {
        //Pour chaque produit '$produit' de la table '$products'...
        // on crée les éléments HTML suivant :?>
<tr>
    <th scope="row"><?php echo $product['products_id']; ?>
    </th>
    <td><?php echo $product['products_name']; ?>
    </td>
    <td><?php echo $product['description']; ?>
    </td>
    <td><?php echo $product['price']; ?>
    </td>
    <td><?php echo $product['city']; ?>
    </td>
    <td><?php echo $product['categories_name']; ?>
    </td>
    <td><?php echo $product['username']; ?>
    </td>
    <td> <a
            href="product.php?id=<?php echo $product['products_id']; ?>">Afficher
            article</a>
    </td>
</tr>
<?php
    }
}
// FONCTION AFFICHAGE D'UN PRODUIT
function affichageProduit($id)
{
    global $conn;
    $sth = $conn->prepare("SELECT p.*,c.categories_name,u.username FROM products AS p LEFT JOIN categories AS c ON p.category_id = c.categories_id LEFT JOIN users AS u ON p.user_id = u.id WHERE p.products_id = {$id}");
    $sth->execute();

    $product = $sth->fetch(PDO::FETCH_ASSOC); ?>
<div class="row">
    <div class="col-12">
        <h1><?php echo $product['products_name']; ?>
        </h1>
        <p><?php echo $product['description']; ?>
        </p>
        <p><?php echo $product['city']; ?>
        </p>
        <button class="btn btn-info"><?php echo $product['price']; ?> € </button>
    </div>
</div>
<?php
}
// AJOUT DE PRODUITS
function ajoutProduits($name, $description, $price, $city, $category, $user_id)
{
    global $conn;
    // Est-ce que le prix ($price) est un Nombre ET supérieur à 0 ET inférieur à 1000000?
    if (is_int($price) && $price > 0 && $price < 1000000) {
        // Si oui -> Try / Catch pour capter erreurs PDO/SQL
        try {
            // Création de la requête avec tous les champs du formulaire
            $sth = $conn->prepare('INSERT INTO products (products_name,description,price,city,category_id,user_id) VALUES (:products_name, :description, :price, :city, :category_id, :user_id)');
            // Requête créée, on lie les valeurs (bindValue)
            //PARAM_STR -> String //PARAL_INT -> Integer
            $sth->bindValue(':products_name', $name, PDO::PARAM_STR);
            $sth->bindValue(':description', $description, PDO::PARAM_STR);
            $sth->bindValue(':price', $price, PDO::PARAM_INT);
            $sth->bindValue(':city', $city, PDO::PARAM_STR);
            $sth->bindValue(':category_id', $category, PDO::PARAM_INT);
            $sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            // Si le try est bon -> on execute
            if ($sth->execute()) {
                echo "<div class='alert alert-success'> Votre article a été ajouté à la base de données </div>";
                header('Location: product.php?id='.$conn->lastInsertId()); //redirection sur la page du produit avec le dernier id enregistré
            }
        } catch (PDOException $e) { //Là c'est quand c'est la mouise
            echo 'Error: '.$e->getMessage();
        }
    }
}
// MODIFICATION DE PRODUITS
function modifProduits($name, $description, $price, $city, $category, $id, $user_id)
{
    global $conn;
    // Est-ce que le prix ($price) est un Nombre ET supérieur à 0 ET inférieur à 1000000?
    if (is_int($price) && $price > 0 && $price < 1000000) {
        // Si oui -> Try / Catch pour capter erreurs PDO/SQL
        try {
            $sth = $conn->prepare('UPDATE products SET products_name = :products_name, description=:description, price=:price, city=:city, category_id=:category_id WHERE products_id=:products_id AND user_id=:user_id');
            $sth->bindValue(':products_name', $name);
            $sth->bindValue(':description', $description);
            $sth->bindValue(':price', $price);
            $sth->bindValue(':city', $city);
            $sth->bindValue(':category_id', $category);
            $sth->bindValue(':products_id', $id);
            $sth->bindValue(':user_id', $user_id);
            if ($sth->execute()) {
                echo '<div class="alert alert-success">Votre modification a bien été prise en compte</div>';
                header("Location: product.php?id={$id}");
            }
        } catch (PDOException $e) {
            echo 'Error : '.$e->getMessage();
        }
    }
}
// FONCTION D'AFFICHAGE DE LA LISTE DES PRODUITS PAR USER
function affichageProduitsByUser($user_id)
{
    global $conn;
    // Requête SQL
    // Ajout d'un WHERE par rapport à l'affichage global de la liste des produits
    $sth = $conn->prepare("SELECT p.*,c.categories_name FROM products AS p LEFT JOIN categories AS c ON p.category_id = c.categories_id WHERE p.user_id = {$user_id}");
    $sth->execute(); //Exécution de requête

    $products = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as $product) {
        //Pour chaque produit '$produit' de la table '$products'...
        // on crée les éléments HTML suivant :?>
<tr>
    <th scope="row"><?php echo $product['products_id']; ?>
    </th>
    <td><?php echo $product['products_name']; ?>
    </td>
    <td><?php echo $product['description']; ?>
    </td>
    <td><?php echo $product['price']; ?>
    </td>
    <td><?php echo $product['city']; ?>
    </td>
    <td><?php echo $product['categories_name']; ?>
    </td>

    <td> <a class="btn btn-outline-info"
            href="product.php?id=<?php echo $product['products_id']; ?>">Afficher</a>
    </td>
    <td> <a class="btn btn-outline-warning"
            href="editproducts.php?id=<?php echo $product['products_id']; ?>">Editer</a>
    </td>

    <td>
        <form action="process.php" method="POST">
            <input type="hidden" name="product_id"
                value="<?php echo $product['products_id']; ?>" />
            <input type="submit" name="product_delete" class="btn btn-outline-danger" value="Supprimer" />

        </form>
    </td>
</tr>
<?php
    }
}
