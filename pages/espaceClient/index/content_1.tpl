<div id="client-connexion">
    <form action="{absoluteURL page="espaceClient/index" action=true}" method="POST">
        <fieldset>
            <h2>Connexion</h2><br>
            <label for="mail">Adresse Mail</label>
            <input type="text" id="login" name="mail" /><br>
            <label for="pwd">Mot de passe</label>
            <input type="password" id="pwd" name="pwd" /><br><br>
            <input type="submit" value=".:: GO ::."/>
        </fieldset>
        {if $error}
            <div class="form-error">
                &Eacute;chec de l'authentification
            </div>
        {/if}
    </form>
    <form action="{absoluteURL page="espaceClient/profil"}" method="POST">
        <fieldset>
            <h2>Creation d'un Wam space</h2><br>
            <input type="submit" value=".:: Creer ::."/>
        </fieldset>
    </form>
</div>
