<header id="admin-menu">
    <h1 class="admin-menu-title">
        Espace Administration
    </h1>
    
    <ul id="admin-menu-list">        
        {if isset($admin) && $admin->id != 0}
        <li class="admin-menu-list-item {if isset($activeMenu) && $activeMenu == "profil"}admin-menu-list-item-active{/if}">
            <a href="{absoluteURL page="espaceAdmin/profil"} ">
                Mon Profil Administrateur
            </a>
        </li>
        
        <li class="admin-menu-list-item {if isset($activeMenu) && $activeMenu == "secteursActivites"}admin-menu-list-item-active{/if}">
            <a href="{absoluteURL page="espaceAdmin/secteursActivites"}">
                Secteurs d'activités
            </a>
        </li>

        {if $admin->superAdmin()}
        <li class="admin-menu-list-item {if isset($activeMenu) && $activeMenu == "parameteres"}admin-menu-list-item-active{/if}">
            <a href="{absoluteURL page="espaceAdmin/parametres/index"}">
                Paramètres généraux
            </a>
            <ul class="admin-submenu-list">
                <li class="admin-submenu-list-item {if isset($activeSubMenu) && $activeSubMenu == "typesMembre"}admin-submenu-list-item-active{/if}">
                    <a href="{absoluteURL page="espaceAdmin/parametres/typesMembre"}">
                        Types de membres
                    </a>
                </li>
                <li class="admin-submenu-list-item {if isset($activeSubMenu) && $activeSubMenu == "typesTVA"}admin-submenu-list-item-active{/if}">
                    <a href="{absoluteURL page="espaceAdmin/parametres/typesTva"}">
                       Taux de TVA
                    </a>
                </li>
                <li class="admin-submenu-list-item {if isset($activeSubMenu) && $activeSubMenu == "gestionOptions"}admin-submenu-list-item-active{/if}">
                    <a href="#">
                       Gestion des options 
                    </a>
                </li>
                <li class="admin-submenu-list-item {if isset($activeSubMenu) && $activeSubMenu == "gestionAdmins"}admin-submenu-list-item-active{/if}">
                    <a href="#">
                        Gestion des administrateurs
                    </a>
                </li>
            </ul>
        </li>        
        {/if}
        
        <li class="admin-menu-list-item">
            <a href="{absoluteURL page="espaceAdmin/deconnexion"}">
                Déconnexion
            </a>
        </li>
        {/if}
    </ul>
</header>