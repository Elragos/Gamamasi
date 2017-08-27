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
                    Tarif horaire
                </th>
                <th>
                    TVA applicable
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
                    data-salle-tva="{$salle->tva->id}"
                    data-salle-type="{$salle->type}"
                    data-salle-posX="{$salle->position->x}"
                    data-salle-posY="{$salle->position->y}"
                    data-salle-longueur="{$salle->longueur}"
                    data-salle-largeur="{$salle->largeur}"
                    data-salle-enVente="{if $salle->enVente}1{else}0{/if}">
                    <td>
                        {$salle->nom}
                    </td>
                    <td>
                        {$salle->capaciteMax}
                    </td>
                    <td>
                        {$salle->tarifHT|string_format:"%.3f"} &euro; HT <br />
                        {$salle->tarifTTC()|string_format:"%.2f"} &euro; TTC
                    </td>
                    <td>
                        {$salle->tva->nom} ({$salle->tva->taux} %)
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
                        {if $salle->type == 1}
                        <button class="admin-gestionSalle-modifier">
                            Gérer les bureaux
                        </button>
                        {/if}
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
        <input type="hidden" id="PosXSalle" name="PosXSalle" value="0" />
        <input type="hidden" id="PosYSalle" name="PosYSalle" value="0" />
        <input type="hidden" id="LongueurSalle" name="LongueurSalle" value="0" />
        <input type="hidden" id="LargeurSalle" name="LargeurSalle" value="0" />
        
        <div class="content-form-input">
            <label for="NomSalle">
                Nom
            </label>
            <input type="text" id="NomSalle" name="NomSalle" />
        </div>
        
        <div class="content-form-input">
            <label for="IdTvaSalle">
                TVA applicable
            </label>
            <select id="IdTvaSalle" name="IdTvaSalle">
                {foreach from=$typesTva item=typeTva}
                    <option value="{$typeTva->id}" data-taux="{$typeTva->taux}">
                        {$typeTva->nom} ({$typeTva->taux|number_format:2}%)
                    </option>
                {/foreach}
            </select>
        </div>
            
        <div class="content-form-input">
            <label for="TarifHtSalle">
                Tarif horaire HT
            </label>
            <input type="number" id="TarifHtSalle" name="TarifHtSalle" step = ".001" />
        </div>
            
        <div class="content-form-input">
            <label for="TarifTtcSalle">
                Tarif horaire TTC
            </label>
            <input type="number" id="TarifTtcSalle" name="TarifTtcSalle" step=".01" />
            
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