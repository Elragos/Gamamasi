<div id="client-membres">
    <table>
        <thead>
            <tr>
                <th>
                    Nom
                </th>
                <th>
                    Prénom
                </th>
                <th>
                    Email
                </th>
                <th>
                    Rôle
                </th>
                <th>
                    Secteur d'activité
                </th>
                <th>
                    Actions (en cours de construction)
                </th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$membres item=membre}
                <tr>
                    <td>
                        {$membre->nom}
                    </td>
                    <td>
                        {$membre->prenom}
                    </td>
                    <td>
                        {$membre->mail}
                    </td>
                    <td>
                        {$membre->typeMembre->nom}
                    </td>
                    <td>
                        {if $membre->secteurActivite == null}
                            Non précisé
                        {else}
                            {$membre->secteurActivite->nom}
                        {/if}
                    </td>
                    <td>
                        <button class="client-membres-modifier" data-membre-id="{$membre->id}">
                            Modifier
                        </button>
                        <button class="client-membres-supprimer" data-membre-id="{$membre->id}">
                            Supprimer
                        </button>
                    </td>
                </tr>
            </option>
            {/foreach}
        </tbody>
    </table>
        
    <button type="button" id="AjouterMembre">
        Ajouter un membre
    </button>
</div>

<div id="client-membre-popin">
    <div class="client-membre-popin-toolbar">
        <div class="client-membre-popin-toolbar-close">
            X
        </div>
    </div>
    <form action="{absoluteURL page="espaceClient/membres" action=true}" method="POST">
        <input type="hidden" id="IdMembre" name="IdMembre" value="0" />
        
        <div class="content-form-input">
            <label for="NomMembre">
                Nom
            </label>
            <input type="text" id="NomMembre" name="NomMembre" />
        </div>
        
        <div class="content-form-input">
            <label for="PrenomMembre">
                Prénom
            </label>
            <input type="text" id="PrenomMembre" name="PrenomMembre" />
        </div>
        
        <div class="content-form-input">
            <label for="MailMembre">
                Mail
            </label>
            <input type="text" id="MailMembre" name="MailMembre" />
        </div>
        
        <div class="content-form-input">
            <label for="IdTypeMembre">
                Type de membre
            </label>
            <select id="IdTypeMembre" name="IdTypeMembre">
                {foreach from=$typesMembres item=typeMembre}
                <option value="{$typeMembre->id}">
                    {$typeMembre->nom}
                </option>
                {/foreach}
            </select>
        </div>
            
        <div class="content-form-input">
            <label for="IdSecteurActivite">
                Secteur d'activité
            </label>
            <select id="IdSecteurActivite" name="IdSecteurActivite">
                <option value="0"> -- Non précisé -- </option>
                {foreach from=$secteursActivite item=secteur}
                <option value="{$secteur->id}">
                    {$secteur->nom}
                </option>
                {/foreach}
            </select>
        </div>
        <div class="content-form-input">
            <input type="submit" value="Créer" />
        </div>
    </form>
</div>