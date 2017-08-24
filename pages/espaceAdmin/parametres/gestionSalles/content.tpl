<div id="admin-gestionSalles">
    <table>
        <thead>
            <tr>
                <th>
                    Nom
                </th>
                <th>
                    Capacité maximale
                </th>
                <th>
                    Tarif horaire HT
                </th>
                <th>
                    Type de salle
                </th>
                <th>
                    En Vente ?
                </th>
                <th>
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$listeSalles item=salle}
                <tr data-salle-id="{$salle->id}" data-salle-nom="{$salle->nom}"
                    data-salle-capacite="{$salle->capaciteMax}"
                    data-salle-tarif="{$salle->tarifHT|string_format:"%.3f"}"
                    data-salle-type="{$salle->type}"
                    data-salle-enVente="{if $salle->enVente}1{else}0{/if}">
                    <td>
                        {$salle->nom}
                    </td>
                    <td>
                        {$salle->capaciteMax}
                    </td>
                    <td>
                        {$salle->tarifHT|string_format:"%.3f"} &euro; HT <br />
                    </td>
                    <td>
                        {if $salle->type == 0}
                            Salle de réunion
                        {elseif $salle->type ==1}
                            Salle de bureau
                        {/if}
                    </td>
                    <td>
                        {if $salle->enVente}
                            Oui
                        {else}
                            Non
                        {/if}
                    </td>
                    <td>
                        <button class="admin-gestionSalle-modifier">
                            Modifier
                        </button>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
        
    <button type="button" id="AjouterSalle">
        Ajouter une salle
    </button>
</div>
        
<div class="popin" id="admin-gestionSalle-popin">
    <div class="popin-toolbar">
        <div class="popin-toolbar-close">
            X
        </div>
    </div>
    
    <form action="{absoluteURL page="espaceAdmin/parametres/gestionSalles" action=true}" method="POST">       
        <input type="hidden" id="IdSalle" name="IdSalle" value="0" />
        
        <div class="content-form-input">
            <label for="NomSalle">
                Nom
            </label>
            <input type="text" id="NomSalle" name="NomSalle" />
        </div>
      
        <div class="content-form-input">
            <label for="TarifHtSalle">
                Tarif horaire HT
            </label>
            <input type="number" id="TarifHtSalle" name="TarifHtSalle" step = ".001" />
        </div>
        
      
        <div class="content-form-input">
            <label for="CapaciteSalle">
                Capacité de la salle
            </label>
            <input type="number" id="CapaciteSalle" name="CapaciteSalle" min="0" />
        </div>
        
        <div class="content-form-input">
            <label for="TypeSalle">
                Type de salle
            </label>
            <select name="TypeSalle" id="TypeSalle">
                {foreach from=$typesSalle item=nomTypeSalle key=idTypeSalle}
                    <option value="{$idTypeSalle}">
                        {$nomTypeSalle}
                    </option>
                {/foreach}
            </select>
        </div>
      
        <div class="content-form-input">
            <label for="EnVenteSalle">
                En vente
            </label>
            <input type="checkbox" id="EnVenteSalle" name="EnVenteSalle" />
        </div>
        
        <div class="content-form-input">
            <button type="submit">
                Valider
            </button>
        </div>
    </form>
</div>