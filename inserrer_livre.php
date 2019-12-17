<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>Accueil du site</title>
	  <link rel="stylesheet" type="text/css" href="Monstyle.css"> 
	</head>
	<body>
		<?php
			/*************************************************************************
				nom du script : inserrer_livre.php
				Description   : Ce script propose un formulaire pour ajouter les
				     données sur un livre.
					 Lorsque le formulaire est soumis, il recupere les  données,
					 se connecte au serveur de base de données et envoie une 
					 requête d'insertion des données, puis appelle le script
					 qui affiche les livres 
				Version : 1.0
				Date	: 22/11/2019
				Auteur	: prof
			*************************************************************************/
			
			// on determine si on doit afficher ou traiter le formulaire
			if (isset($_POST["Valider"]))
			{
				// traitement des données envoyées par le formulaire
				
				/* on recupere les données du formulaire et on les "aseptise" avant de les utiliser pour cela on va créer
                une fonction de nettoyage qu'on va utiliser */
				
				
				$titre_Lue = $_POST['zoneTitre'];
				$auteur_Lue = utf8_decode($_POST['zoneAuteur']);
				$genre_Lue = utf8_decode($_POST['zoneGenre']);
				$prix_Lue = $_POST['zonePrix'];
				
				$titre_Lue = sanitizeString($titre_Lue);
				$auteur_Lue = sanitizeString($auteur_Lue);
				$genre_Lue = sanitizeString($genre_Lue);
				$prix_Lue = sanitizeString($prix_Lue);
				
				// on se connecte au SGBD
				
				// paramètres de connexion
				$host 	= 'localhost';
				$user 	= 'user2' ;   
				$passwd = 'snir@snir2019';
				$mabase = 'biblio2';
			
				//tentative de connexion au SGBD MySQL  
				if ($conn = mysqli_connect($host,$user,$passwd,$mabase))
				{
					// connexion OK, on prepare la requete et on l'envoie
						
					// préparation de la requête
					$reqInsert = " INSERT INTO livre (titre, auteur, genre, prix )
						           VALUES ('$titre_Lue','$auteur_Lue','$genre_Lue',$prix_Lue)";
								   
					
					// on tente d'envoyer la requête
					if($result = mysqli_query($conn, $reqInsert, MYSQLI_USE_RESULT))
					{
						// requete on appelle le script "affiche_livre.php"
						require_once 'affiche_livre.php';
						
					}
					else
					{
						// erreur de requête
						die ("erreur de requête");
					}
				}	
				else
				{
					// echec de la connexion à la BD 
					die("problême de connexion au serveur de base de données");	
				}
				
			}

			function sanitizeString($var)	
			{	
				if (get_magic_quotes_gpc())
				{	
					//supprimer les slashes
					$var = stripslashes($var);
				}	
				// suppression des tags
				$var = Strip_tags($var);
				// convertir la chaine en HTML
				$var = htmlentities($var);
				return $var;
			}	
			// afficher le formulaire
			?>
			<h1>Ajouter livre  </h1>
			<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
				<div>
					<!-- zone du titre -->
					<label for="zoneTitre">Titre : </label>
					<input type="text" id="zoneTitre" placeholder="Entrez le titre du livre"
					  name = "zoneTitre" required>
				</div>
				<div>
					<!-- zone de l'auteur -->
					<label for="zoneAuteur">Auteur : </label>
					<input type="text" id="zoneAuteur" placeholder="Entrez l'auteur"	
					name = "zoneAuteur" required>
				</div>
				<div>
					<!-- Menu déroulant pour le genre-->
					<label for="zoneGenre">Genre : </label>
					<select id= "zoneGenre" name = "zoneGenre" size = "1">
						<option value = "Roman">Roman </option>
						<option value ="Poèsie">Poèsie  </option>
						<option value ="Nouvelles">Nouvelles  </option>
						<option value ="Autres">Autres  </option>
					</select>
				</div>
				<div>
					<!-- Zone du prix -->
					<label for="zonePrix">Prix : </label>
					<input type="number" id="zonePrix" placeholder="Entrez le prix"
					  name = "zonePrix" required>
					
				</div>
				<div class="button">
					<!-- Zone du bouton valider -->
					<button type="submit" name= "Valider"> Valider </button>
				</div>
			</form>	
		
	
	</body>
</html>