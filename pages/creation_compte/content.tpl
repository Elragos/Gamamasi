<div id="content-client">
    <form action="enregistrement.html" method="POST">
	<fieldset>
            <legend>identité</legend>
            nom *: <input type="text" name="nom" required value="test"/><br>
            prenom *: <input type="text" required value="test"/><br>
            date de naissance : <input type="date"/>
	</fieldset>
	<p>
	<fieldset>
            <legend>wam</legend>
            identifiant *: <input type="text" required value="test"/><br>
            mot de passe *: <input type="password" required value="test"><br>
            cinformation mot de passe *: <input type="password" required value="test"><br>
            avatar: <br>
	</fieldset>
	<p>
	<fieldset>
            <legend>contacts</legend>
            tel: <input type="tel" /><br>
            mail: <input type="mail" ><br>
	</fieldset>
	<p>
	<fieldset>
            <legend>adresse</legend>
            ligne 1*: <input type="text" required value="test"/><br>
            ligne 2: <input type="text"/><br>
            ligne 3:  <input type="text"/><br>
            supplement: <input type="text"/><br>
            code postal*: <input type="text" required value="test"/><br>
            ville*: <input type="text" required value="test"/><br>
	</fieldset>
	<p>
        <label for="rattachement">rattachement a une societe existante</label> 
	<input type="checkbox" id="rattachement" />
	<p>
	<div id="rattachementDIV">
            <fieldset>
                <legend>société</legend>
                raison sociale*: <input type="text" required value="test"/><br>
                siret*: <input type="text" required value="test"/><br>
                dirigeant*: <input type="text" required value="test"/><br>
                ligne 1*: <input type="text" required value="test"/><br>
                ligne 2: <input type="text"/><br>
                ligne 3: <input type="text"/><br>
                supplement: <input type="text"/><br>
                code postal*: <input type="text" required value="test"/><br>
                ville*: <input type="text" required value="test"/><br>
            </fieldset>
	</div>
	<p>
	<input type="submit" value=".:: GO ::." />
    </form>
</div>