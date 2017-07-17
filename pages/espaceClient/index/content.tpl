<div id="content-espace_client">
    <h1>Espace Client</h1><br>
    <a href="/accueil.html">accueil</a> | espace client | <a href="/espace_reservation.html">espace reservation</a><p>
    <form action="{absoluteURL page="espaceClient/index" action=true}" method="POST">
        <fieldset>
            <h2>Connexion</h2><br>
            <label for="login">identifiant</label>
            <input type="text" id="login" name="login" /><br>
            <label for="pwd">mot de passe</label>
            <input type="password" id="pwd" name="pwd" /><br><br>
            <input type="submit" value=".:: GO ::."/>
        </fieldset>
        {if $error}
            <div class="form-error">
                &Eacute;chec de l'authentification
            </div>
        {/if}
    </form>
    <form action="{absoluteURL page="espaceClient/creation"}" method="POST">
        <fieldset>
            <h2>Creation d'un Wam space</h2><br>
            <input type="submit" value=".:: Creer ::."/>
        </fieldset>
    </form>
</div>
