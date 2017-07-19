<div id="content-profil">
    <h1>Profil Client</h1><br>
    <a href="accueil.html">accueil</a> | 
    <a href="{absoluteURL page="espaceClient/index"}">espace client</a> | 
    <a href="espace_reservation.html">espace reservation</a> |
    <a href="synthese_client.html">synthèse</a> |
    profil |
    <a href="factures.html">factures</a>
    {if $customer->id != 0}
        <a href="{absoluteURL page="espaceClient/deconnexion"}">Déconnexion</a>
    {/if}
    
    
    <form action="{absoluteURL page="espaceClient/profil" action=true}" method="POST">
        <fieldset>
            <legend>identité</legend>
            <label for="lastname">
                Nom *
            </label>
            <input type="text" id="lastname" name="lastname" value="{$customer->lastname}" required />
            <br />
            <label for="firstname">
                Prénom *
            </label>
            <input type="text" id="firstname" name="firstname" value="{$customer->firstname}" required />
            <br />
            <label for="birthdate">
                Date de naissance
            </label>
            <input type="date" id="birthdate" name="birthdate"  value="{$customer->birthDate|date_format:"%Y-%m-%d"}" />
        </fieldset>
        <p>
        <fieldset>
            <legend>wam</legend>
            <label for="login">
                Identifiant *
            </label>
            <input type="text" id="login" name="login" value="{$customer->login}" required />
            <br />
            <label for="password">
                Mot de passe
                {if $customer->id != 0}
                    (Laisser vide pour ne pas modifier)
                {/if}
            </label>
            <input type="password" id="password" name="password"  />
        </fieldset>
        <p>
        <fieldset>
            <legend>contacts</legend>
            <label for="phone">
                Téléphone
            </label>
            <input type="text" id="phone" name="phone" value="{$customer->phone}" />
            <br />
            <label for="email">
                Mail *
            </label>
            <input type="text" id="email" name="email" value="{$customer->email}" required />
        </fieldset>
        <p>
        <fieldset>
            <legend>adresse</legend>
            <label for="addressLine1">
                Addresse *
            </label>
            <input type="text" id="addressLine1" name="addressLine1" value="{$customer->address->line1}" required />
            <br />
            <label for="addressLine2">
                Complément d'adresse 
            </label>
            <input type="text" id="addressLine2" name="addressLine2" value="{$customer->address->line2}" />
            <input type="text" id="addressLine3" name="addressLine3" value="{$customer->address->line3}" />
            <br />
            <label for="zipcode">
                Code Postal *
            </label>
            <input type="text" id="zipCode" name="zipCode" value="{$customer->address->zipCode}" required />
            <br />
            <label for="town">
                Ville *
            </label>
            <input type="text" id="town" name="town" value="{$customer->address->town}" required />
            <br />
        </fieldset>
            
        <!--
        <p>
        <fieldset>
            <legend>société</legend>
            raison sociale: <input type="text" value="1 rue de l'Or" disabled/><a href=""><img src="{$rootURL}ressources/images/edit.png" style="heigth:16px;width:16px"></img></a><br>
            siret: <input type="text" value="78978897300020" disabled/><a href=""><img src="{$rootURL}ressources/images/edit.png" style="heigth:16px;width:16px"></img></a><br>
            dirigeant: <input type="text" value="E. Ruciak" disabled/><a href=""><img src="{$rootURL}ressources/images/edit.png" style="heigth:16px;width:16px"></img></a><br>
            ligne 1: <input type="text" value="322 rue de Lannoy" disabled/><a href=""><img src="{$rootURL}ressources/images/edit.png" style="heigth:16px;width:16px"></img></a><br>
            ligne 2: <input type="text" value="" disabled/><a href=""><img src="{$rootURL}ressources/images/edit.png" style="heigth:16px;width:16px"></img></a><br>
            ligne 3: <input type="text" value="" disabled/><a href=""><img src="{$rootURL}ressources/images/edit.png" style="heigth:16px;width:16px"></img></a><br>
            supplement: <input type="text" value="" disabled/><a href=""><img src="{$rootURL}ressources/images/edit.png" style="heigth:16px;width:16px"></img></a><br>
            code postal: <input type="text" value="59100" disabled/><a href=""><img src="{$rootURL}ressources/images/edit.png" style="heigth:16px;width:16px"></img></a><br>
            ville: <input type="text" value="ROUBAIX" disabled/><a href=""><img src="{$rootURL}ressources/images/edit.png" style="heigth:16px;width:16px"></img></a><br>
        </fieldset>
        <p>
        rattachement ???
        -->
        <input type="submit" value="Valider" />
    </form>
</div>
