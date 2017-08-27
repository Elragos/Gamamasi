<tr>
    <td>
        <input type="number" value="{$bureau->tarifHT|string_format:"%.3f"}" step=".010" /> &euro; HT <br />
        <input type="number" value="{$bureau->tarifTTC()|string_format:"%.2f"}" step=".01" /> &euro; TTC
    </td>
     <td>
        {$bureau->tva->nom} ({$bureau->tva->taux} %)

        <select>
            {foreach from=$typesTva item=typeTva}
                <option value="{$typeTva->id}" data-taux="{$typeTva->taux}" 
                        {if $bureau->tva->id == $typeTva->id}selected{/if}>
                    {$typeTva->nom} ({$typeTva->taux|number_format:2}%)
                </option>
            {/foreach}
        </select>
    </td>
    <td>
        <select>
            <option {if $bureau->enVente}selected{/if}>
                Oui
            </option>
            <option {if !$bureau->enVente}selected{/if}>
                Non
            </option>
        </select>
    </td>
</tr>
