<div id="content-index">
    Je suis la page principale
    <br />
    <a href="test.html">
        Tester la redirection de page
    </a>
    <br />
    <a href="pageinexistante.html">
        Tester la redirection 404
    </a>
    <br />
    <a href="testErreur500.html">
        Tester l'erreur 500
    </a>
    <br />
    <a href="testLectureDB.html">
        Tester la connexion à la DB
    </a>
    <form method="GET" action="index.do" id="testAjax">
        <input type="hidden" name="maVariable" value="existe" />
        <input id="sendAjax" type="submit" value="Tester formulaire GET" />
    </form>
    <form method="POST" action="index.do">
        <input type="hidden" name="maVariable" value="existe"  />
        <input type="submit" value="Tester formulaire POST" />
    </form>
</div>