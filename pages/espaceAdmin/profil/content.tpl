<div id="admin-profil">
    <form action="{absoluteURL page="espaceAdmin/profil" action=true}" method="POST">
        <fieldset>
            <legend>identité</legend>

            <div class="content-form-input">
                <label for="NomAdmin">
                    Nom *
                </label>
                <input type="text" id="NomAdmin" name="NomAdmin" value="{$admin->nom}" required />
            </div>

            <div class="content-form-input">
                <label for="PrenomAdmin">
                    Prénom *
                </label>
                <input type="text" id="PrenomAdmin" name="PrenomAdmin" value="{$admin->prenom}" required />
            </div>

            <div class="content-form-input">
                <label for="MailAdmin">
                    Mail *
                </label>
                <input type="text" id="MailAdmin" name="MailAdmin" value="{$admin->mail}" required />
            </div>
            
            <div class="content-form-input">
                <label for="LoginAdmin">
                    Login * 
                </label>
                <input type="text" id="LoginAdmin" name="LoginAdmin" value="{$admin->login}" required />
            </div>
            
            <div class="content-form-input">
                <label for="PasswordAdmin">
                    Mot de passe
                    {if $admin->id != 0}
                        (Laisser vide pour ne pas modifier)
                    {else}
                        *
                    {/if}
                </label>
                <input type="password" id="PasswordAdmin" name="PasswordAdmin" {if $admin->id == 0}required{/if}  />
            </div>            
        </fieldset>            
        <input type="submit" value="Valider" />
    </form>
</div>
