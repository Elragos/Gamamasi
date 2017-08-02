<div id="admin-secteur">
    <table>
        <thead>
            <tr>
                <th>
                    Nom
                </th>
                <th>
                    Visible par les clients ?
                </th>
                <th>
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$secteurs item=secteur}
                <tr data-secteur-id="{$secteur->id}" data-secteur-nom="{$secteur->nom}"
                    data-secteur-visible="{if $secteur->visible}1{else}0{/if}">
                    <td>
                        {$secteur->nom}
                    </td>
                    <td>
                        {if $secteur->visible}
                            Oui
                        {else}
                            Non
                        {/if}
                    </td>
                    <td>
                        <button class="admin-secteur-modifier">
                            Modifier
                        </button>
                    </td>
                </tr>
            </option>
            {/foreach}
        </tbody>
    </table>
        
    <button type="button" id="AjouterSecteur">
        Ajouter un secteur
    </button>
</div>

<div class="popin" id="admin-secteur-popin">
    <div class="popin-toolbar">
        <div class="popin-toolbar-close">
            X
        </div>
    </div>
    
    <form action="{absoluteURL page="espaceAdmin/secteursActivites" action=true}" method="POST">
        <input type="hidden" id="IdSecteur" name="IdSecteur" value="0" />
        
        <div class="content-form-input">
            <label for="NomSecteur">
                Nom
            </label>
            <input type="text" id="NomSecteur" name="NomSecteur" />
        </div>
      
        <div class="content-form-input">
            <label for="VisibiliteSecteur">
                Visible par les clients ?
            </label>
            <input type="checkbox" id="VisibiliteSecteur" name="VisibiliteSecteur" />
        </div>
        
        <div class="content-form-input">
            <button type="submit">
                Valider
            </button>
        </div>
    </form>
</div>