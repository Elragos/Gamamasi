<div id="admin-gestionAdmin">
    <table>
        <thead>
            <tr>
                <th>
                    Nom
                </th>
                <th>
                    Prénom
                </th>
                <th>
                    Email
                </th>
                <th>
                    Identifiant
                </th>
                <th>
                    SuperAdmin ?
                </th>
                <th>
                    Créé le
                </th>
                <th>
                    Dernière modification le
                </th>
                <th>
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$listeAdmins item=adminCourant}
                <tr data-admin-id="{$adminCourant->id}" data-admin-nom="{$adminCourant->nom}" data-admin-prenom="{$adminCourant->prenom}"
                    data-admin-mail="{$adminCourant->mail}" data-admin-login="{$adminCourant->login}"
                    data-admin-superAdmin="{if $adminCourant->superAdmin()}1{else}0{/if}"  >
                    <td>
                        {$adminCourant->nom}
                    </td>
                    <td>
                        {$adminCourant->prenom}
                    </td>
                    <td>
                        {$adminCourant->mail}
                    </td>
                    <td>
                        {$adminCourant->login}
                    </td>
                    <td>
                        {if $adminCourant->superAdmin()}
                            Oui
                        {else}
                            Non
                        {/if}
                    </td>
                    <td>
                        {$adminCourant->dateCreation|date_format:$config::get("formatDateAffichage")}
                    </td>
                    <td>
                       {$adminCourant->dateModification|date_format:$config::get("formatDateAffichage")}
                    </td>
                    <td>
                        <button class="admin-gestionAdmin-modifier">
                            Modifier
                        </button>
                        <button class="admin-gestionAdmin-supprimer">
                            Supprimer
                        </button>
                    </td>
                </tr>
            </option>
            {/foreach}
        </tbody>
    </table>
        
    <button type="button" id="AjouterAdmin">
        Ajouter un administrateur
    </button>
</div>

<div class="popin" id="admin-gestionAdmin-popin">
    <div class="popin-toolbar">
        <div class="popin-toolbar-close">
            X
        </div>
    </div>
    
    <form action="{absoluteURL page="espaceAdmin/parametres/gestionAdmins" action=true}" method="POST">       
        <input type="hidden" id="IdSuperAdmin" name="IdSuperAdmin" value="0" />
        
        <div class="content-form-input">
            <label for="NomSuperAdmin">
                Nom
            </label>
            <input type="text" id="NomSuperAdmin" name="NomSuperAdmin" />
        </div>
      
        <div class="content-form-input">
            <label for="PrenomAdmin">
                Prénom
            </label>
            <input type="text" id="PrenomSuperAdmin" name="PrenomSuperAdmin" />
        </div>
        
        <div class="content-form-input">
            <label for="MailSuperAdmin">
                Mail
            </label>
            <input type="text" id="MailSuperAdmin" name="MailSuperAdmin" />
        </div>
      
        <div class="content-form-input">
            <label for="LoginSuperAdmin">
                Identifiant
            </label>
            <input type="text" id="LoginSuperAdmin" name="LoginSuperAdmin" />
        </div>
        
        <div class="content-form-input">
            <label for="DroitSuperAdmin">
                Est SuperAdministrateur
            </label>
            <input type="checkbox" id="DroitSuperAdmin" name="DroitSuperAdmin" />
        </div>
        
        <div class="content-form-input">
            <button type="submit">
                Valider
            </button>
        </div>
    </form>
</div>