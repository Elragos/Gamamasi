<header id="client-menu">
    <h1 class="client-menu-title">
        Espace Client
    </h1>
    
    <ul id="client-menu-list">
        
        
        {if isset($client) && $client->id != 0}
        <li class="client-menu-list-item {if isset($activeMenu) && $activeMenu == "profil"}client-menu-list-item-active{/if}">
            <a href="{absoluteURL page="espaceClient/profil"} ">
                Mon Profil Client
            </a>
        </li>
        {if isset($client) && $client->estSociete}
        <li class="client-menu-list-item {if isset($activeMenu) && $activeMenu == "pofil"}client-menu-list-item-active{/if}">
            <a href="{absoluteURL page="espaceClient/membres"} ">
                Mes Membres
            </a>
        </li>
        {/if}
        <li class="client-menu-list-item {if isset($activeMenu) && $activeMenu == "pofil"}client-menu-list-item-active{/if}">
            <a href="{absoluteURL page="espaceClient/profil"} ">
                Mes factures
            </a>
        </li>
        
        <li class="client-menu-list-item">
            <a href="{absoluteURL page="espaceClient/deconnexion"}">
                Déconnexion
            </a>
        </li>
        {/if}
    </ul>
</header>