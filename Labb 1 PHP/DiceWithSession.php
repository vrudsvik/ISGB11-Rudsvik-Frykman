<!doctype html>
<html lang="en" >

	<head>
		<meta charset="utf-8" />
		<title>Roll the dice...</title>
		<link href="style/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>

	<body>
	
		<div>
			<?php

	session_start();
	session_regenerate_id(true);

function deleteSession() {

		session_unset();	
	if( ini_get("session.use_cookies")){ 		// funktion som tar bort kakorna

		$sessionCookieData = session_get_cookie_params();
		$path = $sessionCookieData["path"];
		$domain = $sessionCookieData["domain"];
		$secure = $sessionCookieData["secure"];
		$httponly = $sessionCookieData["httponly"];

		$name = session_name();

		setcookie($name, "", time() - 3600, $path, $domain, $secure, $httponly);
	
	}
	session_destroy();
}			

			
				include("include/OneDice.php"); //länkar in de färdiga php filerna vi gjort
				include("include/SixDices.php");
				$oSixDices = new SixDices(); //skapar ett objekt för tärningarna
				$disabled = true; 
 
 //uppg 1
			  if (isset($_GET["linkNewGame"])){
				$sumOfAllRounds = 0; // sätter värderna till 0 vid nytt spel
				$nbrOfRounds = 0; 
				$_SESSION["sumOfAllRounds"] = $sumOfAllRounds; // tillderar våra sessions med en value från våra variablar
				$_SESSION["nbrOfRounds"] = $nbrOfRounds;
				echo "New Game!" . "<br>";

				$disabled=false;
			  }
			  if (isset($_GET["linkExit"]) && isset($_SESSION["sumOfAllRounds"]) && isset($_SESSION["nbrOfRounds"])|| //uppg 2 och 3
			  !isset($_GET["linkNewGame"]) && !isset($_GET["linkRoll"]) && !isset($_GET["linkExit"]) && !isset($_SESSION["sumOfAllRounds"]) &&!isset($_SESSION["nbrOfRounds"]) ){
				deleteSession(); // tar bort kakorna med funktionen deletesession på rad 19
			  }
//uppg 4
			  if (!isset($_GET["linkRoll"]) && !isset($_GET["linkNewGame"]) && !isset($_GET["linkExit"]) && isset($_SESSION["sumOfAllRounds"]) && isset($_SESSION["nbrOfRounds"])){
				  echo "Medelvärde:" . $_SESSION["sumOfAllRounds"] . "<br>"; //visar värderna för spelaren
				  echo "Antal rundor:" . $_SESSION["nbrOfRounds"];
			  }

//uppg 5
			  if (isset($_GET["linkRoll"]) && isset($_SESSION["sumOfAllRounds"]) && isset($_SESSION["nbrOfRounds"])){
				
				$oSixDices->rollDices();

				echo($oSixDices->svgDices());

				$nbrOfRounds = $_SESSION["nbrOfRounds"];//räknar upp antal rundor varje gång man trycker Roll Dice
				$nbrOfRounds++;
				$_SESSION["nbrOfRounds"] = $nbrOfRounds;
				$sumOfAllRounds = $_SESSION["sumOfAllRounds"];
				$sumOfAllRounds += $oSixDices->sumDices();	//räknar ihop summan av tärningarna och plussar på det
				$_SESSION["sumOfAllRounds"] = $sumOfAllRounds;
				$snitt = $sumOfAllRounds / $nbrOfRounds; //räknar ut snittvärde

				echo ("Antal rundor: " . $_SESSION["nbrOfRounds"] . "<br>");
				echo ("Summan: ". $_SESSION["sumOfAllRounds"] . "<br>");
				echo ("Medelvärde: ". $snitt);
				$disabled = false;
			  }
//uppg 6
			  	if (!isset($_SESSION["sumOfAllRounds"]) && !isset($_SESSION["nbrOfRounds"])){
					  $disabled=true;
				  }
				  	
				//Var uppmärksam på att PHP-tolken används på ett flertal ställen i filen!
			?>
		</div>
		
		<a href="<?php ?>?linkRoll=true" class="btn btn-primary<?php if($disabled){ echo(" disabled");} ?>">Roll six dices</a>
		<a href="<?php ?>?linkNewGame=true" class="btn btn-primary">New game</a>
		<a href="<?php ?>?linkExit=true" class="btn btn-primary<?php if($disabled){ echo(" disabled");} ?>">Exit</a>
		
		<script src="script/animation.js"></script>
		
	</body>

</html>