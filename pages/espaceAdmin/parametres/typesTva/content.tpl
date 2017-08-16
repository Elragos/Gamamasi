<div id="admin-typeTva">
    <table>
        <thead>
            <tr>
                <th>
                    Nom
                </th>
                <th>
                    Taux
                </th>
                <th>
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$typesTva item=typeTva}
                <tr data-typeTva-id="{$typeTva->id}" data-typeTva-nom="{$typeTva->nom}"
                    data-typeTva-taux="{$typeTva->taux}">
                    <td>
                        {$typeTva->nom}
                    </td>
                    <td>
                        {$typeTva->taux|number_format:2}%
                    </td>
                    <td>
                        <button class="admin-typeTva-modifier">
                            Modifier
                        </button>
                    </td>
                </tr>
            </option>
            {/foreach}
        </tbody>
    </table>
        
    <button type="button" id="AjouterTypeTva">
        Ajouter un type de Tva
    </button>
</div>

<div class="popin" id="admin-typeTva-popin">
    <div class="popin-toolbar">
        <div class="popin-toolbar-close">
            X
        </div>
    </div>
    
    <form action="{absoluteURL page="espaceAdmin/parametres/typesTva" action=true}" method="POST">
        <input type="hidden" id="IdTypeTva" name="IdTypeTva" value="0" />
        
        <div class="content-form-input">
            <label for="NomTypeTva">
                Nom
            </label>
            <input type="text" id="NomTypeTva" name="NomTypeTva" />
        </div>
      
        <div class="content-form-input">
            <label for="TauxTypeTva">
                Taux
            </label>
            <input type="number" id="TauxTypeTva" name="TauxTypeTva" step=".01" />
        </div>
        
        <div class="content-form-input">
            <button type="submit">
                Valider
            </button>
        </div>
    </form>
</div>