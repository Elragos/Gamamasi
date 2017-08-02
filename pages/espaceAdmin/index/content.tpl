<div id="client-connexion">
    <form action="{absoluteURL page="espaceAdmin/index" action=true}" method="POST">
        <fieldset>
            <h2>Connexion</h2><br>
            <label for="mail">Identifiant</label>
            <input type="text" id="login" name="login" /><br>
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
</div>
