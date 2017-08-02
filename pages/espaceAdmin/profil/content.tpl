<div id="admin-profil">
    <form action="{absoluteURL page="espaceAdmin/profil" action=true}" method="POST">
        <fieldset>
            <legend>identité</legend>

            <div class="content-form-input">
                <label for="Nom">
                    Nom *
                </label>
                <input type="text" id="Nom" name="Nom" value="{$admin->nom}" required />
            </div>

            <div class="content-form-input">
                <label for="Prenom">
                    Prénom *
                </label>
                <input type="text" id="Prenom" name="Prenom" value="{$admin->prenom}" required />
            </div>

            <div class="content-form-input">
                <label for="Mail">
                    Mail *
                </label>
                <input type="text" id="Mail" name="Mail" value="{$admin->mail}" required />
            </div>
            
            <div class="content-form-input">
                <label for="Login">
                    Mail *
                </label>
                <input type="text" id="Login" name="Login" value="{$admin->login}" required />
            </div>
            
            <div class="content-form-input">
                <label for="Password">
                    Mot de passe
                    {if $admin->id != 0}
                        (Laisser vide pour ne pas modifier)
                    {else}
                        *
                    {/if}
                </label>
                <input type="password" id="Password" name="Password" {if $admin->id == 0}required{/if}  />
            </div>            
        </fieldset>            
        <input type="submit" value="Valider" />
    </form>
</div>
