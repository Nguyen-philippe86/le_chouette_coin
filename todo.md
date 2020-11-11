1. Créer une page d'accueil avec un lien vers la page de connexion.
2. Créer une connexion à la base de données (avec PDO) dans un config.php dans le dossier includes, qui contient tous fichiers qui seront inclus sur des pages.
3. Créer une base de données qui représente la structure de notre projet [le_chouette_coin>users,products,categories].
4. Créer un formulaire pour l'inscription / la connexion des utilisateurs qui reprend les informations de connexion :
    -> Ne pas oublier l'action et la méthode POST du formulaire,
    -> ne pas oublier les name sur les input (pour les retrouver lors du $_POST),
    -> ** Rajouter des vérifications en front ** (optionnel).
5. Récupérer les données du formulaire en prenant soin de les sécuriser :
    -> htmlspecialchars sur nos variables $_POST,
    -> ** On peut aussi utiliser strip_tags **
6. Créer une logique pour l'ajout d'utilisateur dans la base de données :
    -> Un utilisateur doit forcément posséder un email, un mot de passe et un username et avoir cliqué sur le bouton d'inscription (1er if : avec !empty et isset),
    -> Un utilisateur ne peut pas avoir la même adresse email qu'un autre. Pour cela, nous comptons le nombre de fois que l'email est dans la base de données (2ème if). ,
    -> Un utilisateur ne peut pas avoir le même username qu'un autre. Pour cela, nous comptons le nombre de fois que ce username est dans la base de données (3ème if),
    -> Un utilisateur doit être sûr de son mot de passe (4ème if avec la vérification de la concordance des mots de passe entrés : "pass1=== $pass2"),
    -> LES MOTS DE PASSE SONT TOUJOURS CRYPTES DANS LA BASE DE DONNEES (RGPD 2018) - Le mot de passe doit être crypté avec la fonction password_hash (la clé PASSWORD_DEFAULT suffit, mais vous pouvez explorer les autres ! A savoir, les clés de hashage md5 et sha1 sont faciles à décrypter - NE PAS UTILISER)
    -> Créer une requête d'insertion avec la préparation de requête en PDO et des marqueurs nommés. (prepare(), :value et bindValue(:value))
7. Factoriser le code en créant une fonction qui réalise l'ajout d'utilisateurs à partir des variables nécessaires pour chaque utilisateur.
8. Ajuster le formulaire pour la connexion :
    -> Uniquement 2 champs, email et mot de passenger
    -> changer les names
9. Créer une fonction de connexion et l'implémenter :
    -> Vérification de l'existence de l'email dans la base de données (1er if, avec une requête SELECT et un fetch())
    -> vérification du mot de passe hashed (2ème if avec password_verify())
    -> Lancement d'une session (avec $_SESSION).
10. Ajouter la variable $conn en GLOBAL à CHAQUE FONCTION plutôt que comme argument
11. Création d'une (2) fonction(s) d'affichage des données depuis la BDO.
    -> Faire une requête SELECT à la base de données avec les paramètres de notre choix (une requête globale et une requête par id de produit),
    -> Faire un array qui contient le fetchALL sur les données récupérées (ou un fetch s'il n'y a qu'une seule ligne récupérée),
    -> Créer une boucle foreach qui passe chaque ligne des données récupérées depuis la base de données dans un tableau HTML (ou tout simplement dans les balises HTML)
12. Création d'une page process.php qui contiendra la logique de tous les formulaires.
    -> Bloquer l'accès de cette page aux méthodes autres que POST,
    -> Ajout d'une condition pour le formulaire d'ajout de produits.
13. Création d'une fonction d'ajout de produits dans la BDD
    -> Création d'un formulaire contenant toutes les informations nécessaires à l'ajout de produits dans la base de données.(le cjhamp category_id est récupéré dynamiquement depuis la base de données, par un fetchAll de la table categories)
    -> Les champs id et user_id se remplissent différemment. L'id est en auto-increment mais le user_id est récupéré depuis le token de $_SESSION,
    -> Vérification de la variable $price qui doit être un entier strictement positive et strictement inférieur à 1 million,
    -> Créer une requête SQL en PDO pour l'ajout de données dans la base de données, avec des marqueurs nommés et des bindValues,
    -> Après validation du formulaire, création d'une redirection vers le produit fraîchement créé à l'aide d'un lastInsertID() sur le lien de redirection.
14. Création d'un formulaire d'édition de produits.
    -> Création du formulaire à partir des données récupérées dans la base de données (requête SELECT pour récupérer les données du produit à éditer, puis insertion dans le formulaire avec les values),
    -> Création de la logique d'édition dans le fichier process
    -> Factorisation de l'édition grâce à une fonction modifProduit.
15. Création d'un bouton de suppresion.
    -> Création d'un mini formulaire dans le tableau (pour passer le blocage de méthode POST du fichier process.php),
    -> Création de la requête dans le fichier process qui inclut une vérification de l'user_id,
    -? Factoriser la suppression --
16. Création d'un formulaire d'édition du numéro de téléphone.
    -> Création du formulaire à partir des données récupérées dans la base de données (requête SELECT pour récupérer le numéro de téléphone à éditer, puis insertion dans le formulaire avec les values),
    -> Création de la logique d'édition dans le fichier process
    -? Factorisation de l'édition. --