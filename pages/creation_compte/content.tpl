<div id="content-client">
    <form action="enregistrement.do" method="POST">
	<fieldset>
            <legend>identité</legend>
            nom *: <input                           type="text"     name="nom" required value="DAUDET"/><br>
            prenom *: <input                        type="text"     name="prenom" required value="Alphonse"/><br>
            <!--date de naissance : <input              type="date"     name="date_naissance" value="12/03/1945"/-->
            date de naissance :
            
jour
<select name="jour">
  <option value="01">01</option>
  <option value="09">09</option>
  <option value="12">12</option>
  <option value="31">31</option>
</select>
mois
<select name="mois">
  <option value="01">janvier</option>
  <option value="02">février</option>
  <option value="03">mars</option>
  <option value="04">avril</option>
</select>
année
<select name="annee">
  <option value="1981">1981</option>
  <option value="1982">1982</option>
  <option value="1983">1983</option>
  <option value="1984">1984</option>
</select>
<br>         
            
            
            
	</fieldset>
	<p>
	<fieldset>
            <legend>wam</legend>
            identifiant *: <input                   type="text"     name="identifiant" required value="alph"/><br>
            mot de passe *: <input                  type="password" name="password" required value="daud"><br>
            confirmation mot de passe *: <input     type="password" name="password2" required value="daud"><br>
            avatar: <input                          type="file"     name="avatar" accept="image/*"><br>
	</fieldset>
	<p>
	<fieldset>
            <legend>contacts</legend>
            tel: <input                             type="tel"      name="tel" value="0645710215"/><br>
            mail: <input                            type="mail"     name="email" required value="alph@mon.moulin.fr"><br>
	</fieldset>
	<p>
	<fieldset>
            <legend>adresse</legend>
            ligne 1*: <input                        type="text"     name="adresse1" required value="3 rue de la Cité"/><br>
            ligne 2: <input                         type="text"     name="adresse2" value="Escalier B"/><br>
            ligne 3:  <input                        type="text"     name="adr1_li3" value="porte 415"/><br>
            supplement: <input                      type="text"     name="adr1_supp" value="Chemin des Airelles"/><br>
            code postal*: <input                    type="text"     name="code_postal" required value="12874"/><br>
            ville*: <input                          type="text"     name="ville" required value="LOIN VILLE"/><br>
	</fieldset>
	<p>
        <label for="rattachement">rattachement a une societe existante</label> 
	<input type="checkbox" id="rattachement" />
	<p>
	<div id="rattachementDIV">
            <fieldset>
                <legend>société</legend>
                raison sociale*: <input             type="text"     name="raison_sociale" required value="Les Livres de Ma Jeunesse"/><br>
                siret*: <input                      type="text"     name="siret" required value="12547-AB"/><br>
                dirigeant*: <input                  type="text"     name="nom_dirigeant" required value="Alf"/><br>
                ligne 1*: <input                    type="text"     name="adr2_li1" required value="45 champs de Fleurs en mousson"/><br>
                ligne 2: <input                     type="text"     name="adr2_li2" value="Batiment C"/><br>
                ligne 3: <input                     type="text"     name="adr2_li3" value="Aile Droite"/><br>
                supplement: <input                  type="text"     name="adr2_supp" value="etage 47"/><br>
                code postal*: <input                type="text"     name="adr2_cp" required value="37000"/><br>
                ville*: <input                      type="text"     name="adr2_ville" required value="TOURS EN BRESSE"/><br>
            </fieldset>
	</div>
	<p>
	<input type="submit" value=".:: GO ::." />
    </form>
</div>