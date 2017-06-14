<div id="content-test">
    Je suis une page de test pour la lecture en DB !!!
    {foreach $clientResults as $client}
        {* On a des résultats *}
        <div class="client">
            {$client.nom} {$client.prenom} mis à jour le {$client.timestamp_creation_fiche}
            <a class="client-update" data-client-id="{$client.id}" href="#">
                Mise à jour
            </a>
        </div>
    {foreachelse}
        {* On a aucun résultat *}
        <div class="no-result">
            Pas de clients dans la base
        </div>
    {/foreach}
</div>