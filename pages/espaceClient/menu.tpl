<header id="client-menu">    
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a href="{absoluteURL page="espaceClient/index"}" class="navbar-brand">
                    <img src="{$rootURL}ressources/images/logo.png" alt="Wam & Co" width="40px" />
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    {if isset($client) && $client->id != 0}
                    <li {if isset($activeMenu) && $activeMenu == "profil"}class="active"{/if}>
                        <a href="{absoluteURL page="espaceClient/profil"} ">
                            Mon Profil Client
                        </a>
                    </li>
                    {if isset($client) && $client->estSociete}
                    <li {if isset($activeMenu) && $activeMenu == "membres"}class="active"{/if}>
                        <a href="{absoluteURL page="espaceClient/membres"} ">
                            Mes Membres
                        </a>
                    </li>
                    {/if}
                    
                    <!--
                    <li {if isset($activeMenu) && $activeMenu == "factures"}class="active"{/if}>
                        <a href="{absoluteURL page="espaceClient/factures"} ">
                            Mes factures
                        </a>
                    </li>
                    -->

                    <li {if isset($activeMenu) && $activeMenu == "reservation"}class="active"{/if}>
                        <a href="{absoluteURL page="espaceClient/reservation"} ">
                            Réserver un espace
                        </a>
                    </li>

                    <li class="client-menu-list-item">
                        <a href="{absoluteURL page="espaceClient/deconnexion"}">
                            Déconnexion
                        </a>
                    </li>
                    {/if}
                </ul>
            </div>
        </div>
    </nav>
</header>