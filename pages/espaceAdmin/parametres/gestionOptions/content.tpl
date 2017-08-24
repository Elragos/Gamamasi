<div id="admin-typeTva">
    <table>
        <thead>
            <tr>
                <th>
                    Nom
                </th>
                <th>
                    Prix
                </th>
                <th>
                    TVA
                </th>
                <th>
                    En vente ?
                </th>
                <th>
                    Stock
                </th>
                <th>
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$options item=option}
                <tr data-option-id="{$option->id}" data-option-nom="{$option->nom}"
                    data-option-prix="{$option->prixHT|string_format:"%.3f"}"
                    data-option-tvaId="{$option->tva->id}" data-option-stockMax="{$option->stockMax}"
                    data-option-enVente="{if $option->enVente}1{else}0{/if}"
                    >
                    <td>
                        {$option->nom}
                    </td>
                    <td>
                        {$option->prixHT|string_format:"%.3f"} &euro; HT <br />
                        {$option->prixTTC()|string_format:"%.2f"} &euro; TTC
                    </td>
                    <td>
                        {$option->tva->nom} ({$option->tva->taux|number_format:2}%)
                    </td>
                    <td>
                        {if $option->enVente}
                            Oui
                        {else}
                            Non
                        {/if}
                    </td>
                    <td>
                        {$option->stockMax}
                    </td>
                    <td>
                        <button class="admin-options-modifier">
                            Modifier
                        </button>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
        
    <button type="button" id="AjouterOption">
        Ajouter une option
    </button>
</div>

<div class="popin" id="admin-options-popin">
    <div class="popin-toolbar">
        <div class="popin-toolbar-close">
            X
        </div>
    </div>
    
    <form action="{absoluteURL page="espaceAdmin/parametres/gestionOptions" action=true}" method="POST">
        <input type="hidden" id="IdOption" name="IdOption" value="0" />
        
        <div class="content-form-input">
            <label for="NomOption">
                Nom
            </label>
            <input type="text" id="NomOption" name="NomOption" />
        </div>
      
        <div class="content-form-input">
            <label for="IdTvaOption">
                TVA applicable
            </label>
            <select id="IdTvaOption" name="IdTvaOption">
                {foreach from=$typesTva item=typeTva}
                    <option value="{$typeTva->id}" data-taux="{$typeTva->taux}">
                        {$typeTva->nom} ({$typeTva->taux|number_format:2}%)
                    </option>
                {/foreach}
            </select>
        </div>
            
        <div class="content-form-input">
            <label for="PrixHtOption">
                Prix HT
            </label>
            <input type="number" id="PrixHtOption" name="PrixHtOption" step=".001" />
            
        </div>            
            <div class="content-form-input">
            <label for="PrixTtcOption">
                Prix TTC
            </label>
            <input type="number" id="PrixTtcOption" name="PrixTtcOption" step=".01" />
            
        </div>



        <div class="content-form-input">
            <label for="EnVenteOption">
                En vente
            </label>
            <input type="checkbox" id="EnVenteOption" name="EnVenteOption" />
        </div>
            
        <div class="content-form-input">
            <label for="StockMaxOption">
                Stock de départ
            </label>
            <input type="number" id="StockMaxOption" name="StockMaxOption" min="0" />
        </div>
        
        <div class="content-form-input">
            <button type="submit">
                Valider
            </button>
        </div>
    </form>
</div>