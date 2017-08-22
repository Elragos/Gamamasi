<div id="admin-listeClients">
    <table>
        <thead>
            <tr>
                <th>
                    Identité
                </th>
                <th>
                    Infos complémentaires
                </th>
                <th>
                    Secteur
                </th>
                <th>
                    Adresse
                </th>
                <th>
                    Contact
                </th>
                <th>
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$clients item=client}
                <tr data-client-id="{$client->id}">
                    <td>
                        {if $client->estSociete}
                            {$client->raisonSociale}
                        {else}
                            {$client->nom} {$client->prenom}
                        {/if}
                            

                    </td>
                    <td>
                        {if $client->estSociete}
                            SIRET : {$client->SIRET} <br />
                            Responsable : {$client->nom} {$client->prenom}
                        {else}
                            Date de naissance : {$client->dateNaissance|date_format:$config::get("formatDateAffichage")}
                        {/if}
                    </td>
                    <td>
                        {$client->secteurActivite->nom}
                    </td>
                    <td>
                        {$client->adresse->ligne1} <br />
                        {$client->adresse->ligne2} {$client->adresse->ligne3} <br />
                        {$client->adresse->codePostal} {$client->adresse->ville}
                    </td>
                    <td>
                        Téléphone : {$client->telephone}
                        <br />
                        Mail : {$client->mail}
                    </td>
                    <td>
                        <button type="button" class="admin-listeClients-voirCommandes">
                            Voir les commandes
                        </button>
                        <br />
                        <button type="button" class="admin-listeClients-voirMembres">
                            Voir les Membres
                        </button>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>
