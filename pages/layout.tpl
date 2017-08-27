<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>{$titre}</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="stylesheet" href="{$rootURL}ressources/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="{$rootURL}ressources/bootstrap/css/bootstrap-theme.css" />
        <link rel="stylesheet" href="{$rootURL}css/test.css" />   
        

        <script type="text/javascript" src="{$rootURL}js/tools.js"></script>        
        <script type="text/javascript" src="{$rootURL}js/interact.js"></script>
        <script type="text/javascript" src="{$rootURL}js/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="{$rootURL}js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{$rootURL}js/bootstrap.min.js"></script>        
        <script type="text/javascript" src="{$rootURL}js/interact-div-modele.js"></script>
        <script type="text/javascript" src="{$rootURL}js/interact-div-piece.js"></script>
        <script type="text/javascript" src="{$rootURL}js/interact-div-table.js"></script>
        <script type="text/javascript" src="{$rootURL}js/jquery-my-functions.js"></script>
        
        {*
            HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
            WARNING: Respond.js doesn't work if you view the page via file://
        *}
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        {if isset($menuContent)}
        {include file=$menuContent}
        {/if}
        
        {include file=$bodyContent caching}
        
        <script type="text/javascript">
            
            /**
             *  Récupérer le format de date
             * @param bool affichage Est-ce que c'est le format d'affichage ?
             * @returns string Le format de date à utiliser.
             */
            function formatDate(affichage = true){
                if (affichage){
                    return "{Config::get("formatDateAffichageJS")}";
                }
                return "{Config::get("formatDateTechiqueJS")}";
            }
            
            {$js}
        </script>
        
        <div id="overlay">
            <div id="loader">
                <img src="{$rootURL}ressources/images/ajax-loader.gif" />
            </div>
        </div>
    </body>    
</html>
