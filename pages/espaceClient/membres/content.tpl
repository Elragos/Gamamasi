<div id="client-membre">
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
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$membres item=membre}
                <tr data-membre-id="{$membre->id}" data-membre-nom="{$membre->nom}"
                    data-membre-prenom="{$membre->prenom}" data-membre-mail="{$membre->mail}"
                    data-membre-type="{$membre->typeMembre->id}" data-membre-secteur="{($membre->secteurActivite == null) ? '0' : $membre->secteurActivite->id}" >
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
                        <button class="client-membre-modifier btn btn-info btn-sm" data-toggle="modal" data-target="#client-membre-modal">
                            Modifier
                        </button>
                        <button class="client-membre-supprimer btn btn-danger btn-sm">
                            Supprimer
                        </button>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
        
    <button id="AjouterMembre" type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#client-membre-modal">
        Ajouter un membre
    </button>
</div>

<div  class="modal fade" role="dialog" id="client-membre-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ajouter/Modifier un membre</h4>
            </div>

            <div class="modal-body">
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
                        <button type="submit">
                            Valider
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>