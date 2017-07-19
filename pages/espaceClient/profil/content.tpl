<div id="content-profil">
    <h1>Profil Client</h1><br>
    <a href="accueil.html">accueil</a> | 
    <a href="{absoluteURL page="espaceClient/index"}">espace client</a> | 
    <a href="espace_reservation.html">espace reservation</a> |
    <a href="synthese_client.html">synthèse</a> |
    profil |
    <a href="factures.html">factures</a>
    {if $client->id != 0}
        <a href="{absoluteURL page="espaceClient/deconnexion"}">Déconnexion</a>
    {/if}
    
    
    <form action="{absoluteURL page="espaceClient/profil" action=true}" method="POST">
        <fieldset>
            <legend>identité</legend>
            <label for="Nom">
                Nom *
            </label>
            <input type="text" id="Nom" name="Nom" value="{$client->nom}" required />
            <br />
            <label for="Prenom">
                Prénom *
            </label>
            <input type="text" id="Prenom" name="Prenom" value="{$client->prenom}" required />
            <br />
            <label for="DateNaissance">
                Date de naissance
            </label>
            <input type="date" id="DateNaissance" name="DateNaissance"  value="{$client->dateNaissance|date_format:"%Y-%m-%d"}" />
            
            <br />
            <label for="IdSecteurActivite">
                Secteur d'activité
            </label>
            <select id="IdSecteurActivite" name="IdSecteurActivite">
                <option value="0"> -- Non précisé -- </option>
                {foreach from=$secteursActivite item=secteur}
                    <option value="{$secteur->id}" {if $client->secteurActivite != null && $client->secteurActivite == $secteur->id}selected{/if} >
                        {$secteur->nom}
                    </option>
                {/foreach}
            </select>
        </fieldset>
        <p>
        <fieldset>
            <legend>wam</legend>
            <label for="Password">
                Mot de passe
                {if $client->id != 0}
                    (Laisser vide pour ne pas modifier)
                {else}
                    *
                {/if}
                
            </label>
            <input type="password" id="Password" name="Password" {if $client->id == 0}required{/if}  />
        </fieldset>
        <p>
        <fieldset>
            <legend>contacts</legend>
            <label for="Telephone">
                Téléphone
            </label>
            <input type="text" id="Telephone" name="Telephone" value="{$client->telephone}" />
            <br />
            <label for="Mail">
                Mail *
            </label>
            <input type="text" id="Mail" name="Mail" value="{$client->mail}" required />
        </fieldset>
        <p>
        <fieldset>
            <legend>adresse</legend>
            <label for="Adresse1">
                Addresse *
            </label>
            <input type="text" id="Adresse1" name="Adresse1" value="{$client->adresse->ligne1}" required />
            <br />
            <label for="Adresse2">
                Complément d'adresse 
            </label>
            <input type="text" id="Adresse2" name="Adresse2" value="{$client->adresse->ligne2}" />
            <input type="text" id="Adresse3" name="Adresse3" value="{$client->adresse->ligne3}" />
            <br />
            <label for="CodePostal">
                Code Postal *
            </label>
            <input type="text" id="CodePostal" name="CodePostal" value="{$client->adresse->codePostal}" required />
            <br />
            <label for="Ville">
                Ville *
            </label>
            <input type="text" id="Ville" name="Ville" value="{$client->adresse->ville}" required />
            <br />
        </fieldset>

        <fieldset>
            <legend>société</legend>
             <label for="SIRET">
                SIRET
            </label>
            <input type="text" id="SIRET" name="SIRET" value="{$client->SIRET}" />
             <label for="RaisonSociale">
                Raison sociale
            </label>
            <input type="text" id="RaisonSociale" name="RaisonSociale" value="{$client->adresse->codePostal}" />
        </fieldset>

        <input type="submit" value="Valider" />
    </form>
</div>
