<!DOCTYPE html>
<html>
    <head>
        <title>{$titre}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="{$rootURL}css/test.css" />
        <script type="text/javascript" src="{$rootURL}js/jquery-3.1.1.min.js"></script>
    </head>
    <body>
        {if isset($menuContent)}
        {include file=$menuContent}
        {/if}
        
        {include file=$bodyContent caching}
        
        <script type="text/javascript">
            {$js}
        </script>
        
        <div id="overlay">

        </div>
    </body>    
</html>
