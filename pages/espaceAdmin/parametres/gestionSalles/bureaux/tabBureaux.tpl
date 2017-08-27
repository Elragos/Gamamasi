<table>
    <thead>
        <tr>
            <th>
                Tarif
            </th>
            <th>
                TVA applicable
            </th>
            <th>
                En vente ?
            </th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$listeBureaux item=bureau}
            {include file="ligneBureau" bureau=$bureau}
        {/foreach}
    </tbody>
</table>
<div style="display:none" id="ligneBureau">
    {$ligneVide = new Bureau()}
    {include file="ligneBureau" bureau=$ligneVide}
</div>