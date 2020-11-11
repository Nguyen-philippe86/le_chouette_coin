<?php
    $title = 'Identification - Le Chouette Coin';
    require 'includes/header.php';

    if (isset($_POST['submit_signup']) && !empty($_POST['email_signup']) && !empty($_POST['password1_signup']) && !empty($_POST['username_signup'])) { //Est-ce que les champs d'INSCRIPTION ont été renseignés ? (bouton d'inscription, email, mot de passe 1 et username)
        $email = htmlspecialchars($_POST['email_signup']); //variable du mail avec sécurité htmlspecialchars
        $password1 = htmlspecialchars($_POST['password1_signup']); //variable du mot de passe 1 avec sécurité htmlspecialchars
        $password2 = htmlspecialchars($_POST['password2_signup']); //variable du mot de passe 2 avec sécurité htmlspecialchars
        $username = htmlspecialchars($_POST['username_signup']); //variable du username avec sécurité htmlspecialchars

        inscription($email, $username, $password1, $password2); //Si oui -> Lance la fonction INSCRIPTION
    } elseif (isset($_POST['submit_login']) && !empty($_POST['email_login']) && !empty($_POST['password_login'])) { //Si les champs d'INSCRIPTION n'ont pas été renseignés -> Est-ce que les champs de CONNEXION ont été renseignés ?( bouton de connexion, mot de passe et email)
        $email = htmlspecialchars($_POST['email_login']); //variable du mail avec sécurité htmlspecialchars
        $password = htmlspecialchars($_POST['password_login']); //variable du mot de passe avec sécurité htmlspecialchars
        connexion($email, $password); // Si oui -> Lance la fonction de CONNEXION
    } else { //Si ni tous les champs d'inscription ni tous les champs de connexion n'ont été renseignés
        if (isset($_POST)) { //si il y a au moins quelque chose
            unset($_POST); //supprime la données entrée
        }
    }

?>
<!-- FORMULAIRE -->
<div class="container">
    <div class="row">
        <!-- FORMULAIRE GAUCHE - INSCRIPTION -->
        <div class="col-6">
            <h3>Inscription</h3>
            <form
                action="<?php $_SERVER['REQUEST_URI']; ?>"
                method="POST">
                <div class="form-group">
                    <label for="InputEmail1">Adresse email</label>
                    <input type="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp"
                        name="email_signup" required>
                    <small id="emailHelp" class="form-text text-muted">Nous ne partagerons jamais votre email.</small>
                </div>
                <!-- USERNAME -->
                <div class="form-group">
                    <label for="InputUsername1">Pseudo</label>
                    <input type="text" class="form-control" id="InputUsername1" aria-describedby="userHelp"
                        name="username_signup" required>
                    <small id="userHelp" class="form-text text-muted">Votre pseudo est unique.</small>
                </div>
                <!-- MOT DE PASSE 1-->
                <div class="form-group">
                    <label for="InputPassword1">Mot de passe</label>
                    <input type="password" class="form-control" id="InputPassword1" name="password1_signup" required>
                </div>
                <!-- MOT DE PASSE 2 -->
                <div class="form-group">
                    <label for="InputPassword2">Confirmez votre mot de passe</label>
                    <input type="password" class="form-control" id="InputPassword2" name="password2_signup" required>
                </div>
                <!-- BOUTON INSCRIPTION -->
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="Check1" required>
                    <label class="form-check-label" for="Check1">J'accepte les <a href="#" target="_blank">conditions
                            d'utilisation</a></label>
                </div>
                <!-- BOUTON INSCRIPTION -->
                <button type="submit" class="btn btn-primary" name="submit_signup"
                    value="inscription">S'inscrire</button>
            </form>
        </div>
        <!-- FORMULAIRE DROITE - CONNEXION -->
        <div class="col-6">
            <h3>Connexion</h3>
            <form
                action="<?php $_SERVER['REQUEST_URI']; ?>"
                method="POST">
                <!-- EMAIL -->
                <div class="form-group">
                    <label for="InputEmail">Adresse email</label>
                    <input type="email" class="form-control" id="InputEmail" name="email_login" required>
                </div>
                <!-- MOT DE PASSE -->
                <div class="form-group">
                    <label for="InputPassword">Mot de passe</label>
                    <input type="password" class="form-control" id="InputPassword" name="password_login" required>
                </div>
                <!-- BOUTON CONNEXION -->
                <button type="submit" class="btn btn-primary" name="submit_login" value="connexion">Se
                    connecter</button>
            </form>
        </div>
    </div>
</div>

<?php
    require 'includes/footer.php';
