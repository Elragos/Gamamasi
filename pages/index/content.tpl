<div id="content-index">
    Je suis la page principale
    <br />
    <a href="{absoluteURL page="test"}">
        Tester la redirection de page
    </a>
    <br />
    <a href="{absoluteURL page="pageinexistante"}">
        Tester la redirection 404
    </a>
    <br />
    <a href="{absoluteURL page="testErreur500"}">
        Tester l'erreur 500
    </a>
    <br />
    <a href="{absoluteURL page="testLectureDB"}">
        Tester la connexion à la DB
    </a>
    <br />
    <a href="{absoluteURL page="testLectureDBV2"}">
        Tester la connexion à la DB en mode objet
    </a>
    <br />
    <a href="{absoluteURL page="espaceClient/index"}">
        Tester l'espace client
    </a>
    <br />
    <form method="GET" action="{absoluteURL page="index" action=true}" id="testAjax">
        <input type="hidden" name="maVariable" value="existe" />
        <input id="sendAjax" type="submit" value="Tester formulaire GET" />
    </form>
    <form method="POST" action="index.do">
        <input type="hidden" name="maVariable" value="existe"  />
        <input type="submit" value="Tester formulaire POST" />
    </form>
</div>