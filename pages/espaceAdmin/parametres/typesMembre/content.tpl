<div id="admin-typeMembre">
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
            {foreach from=$typesMembre item=typeMembre}
                <tr data-typeMembre-id="{$typeMembre->id}" data-typeMembre-nom="{$typeMembre->nom}"
                    data-typeMembre-visible="{if $typeMembre->visible}1{else}0{/if}">
                    <td>
                        {$typeMembre->nom}
                    </td>
                    <td>
                        {if $typeMembre->visible}
                            Oui
                        {else}
                            Non
                        {/if}
                    </td>
                    <td>
                        <button class="admin-typeMembre-modifier">
                            Modifier
                        </button>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
        
    <button type="button" id="AjouterTypeMembre">
        Ajouter un type de Membre
    </button>
</div>

<div class="popin" id="admin-typeMembre-popin">
    <div class="popin-toolbar">
        <div class="popin-toolbar-close">
            X
        </div>
    </div>
    
    <form action="{absoluteURL page="espaceAdmin/parametres/typesMembre" action=true}" method="POST">
        <input type="hidden" id="IdTypeMembre" name="IdTypeMembre" value="0" />
        
        <div class="content-form-input">
            <label for="NomTypeMembre">
                Nom
            </label>
            <input type="text" id="NomTypeMembre" name="NomTypeMembre" />
        </div>
      
        <div class="content-form-input">
            <label for="VisibiliteTypeMembre">
                Visible par les clients ?
            </label>
            <input type="checkbox" id="VisibiliteTypeMembre" name="VisibiliteTypeMembre" />
        </div>
        
        <div class="content-form-input">
            <button type="submit">
                Valider
            </button>
        </div>
    </form>
</div>