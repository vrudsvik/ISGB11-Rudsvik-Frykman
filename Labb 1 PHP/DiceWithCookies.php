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
			include("include/OneDice.php"); //länkar in de färdiga php filerna vi gjort
			include("include/SixDices.php");
			$oSixDices = new SixDices();  //skapar ett objekt för tärningarna
			$disabled = true;
			$snitt = 0;

//uppg 1
			if (isset($_POST["btnNewGame"])){ // ifall man trcker på knappen New Game
				echo ("New Game!" . "<br>");
				$sumOfAllRounds = 0;  //vid nytt spel sätter vi värderna till 0
				$nbrOfRounds = 0;
		
				setcookie("nbrOfRounds", $nbrOfRounds, time()+3600); //skapar kakorna för värderna vid nytt spel
				setcookie("sumOfAllRounds", $sumOfAllRounds, time()+3600);
				$disabled = false;
			}
//uppg 2 
			if (!isset($_POST["btnRoll"]) && !isset($_POST["btnNewGame"]) && !isset($_POST["btnExit"]) && isset($_COOKIE["nbrOfRounds"]) && isset($_COOKIE["sumOfAllRounds"])){
			
				echo ("Antal rundor: " . $_COOKIE["nbrOfRounds"] . "<br>"); // visar värderna för spelaren
				echo ("Summan: ". $_COOKIE["sumOfAllRounds"] . "<br>");
				echo ("Medelvärde: ". $snitt);
			}
//uppg 3
			if (isset($_POST["btnRoll"]) && isset($_COOKIE["nbrOfRounds"]) && isset($_COOKIE["sumOfAllRounds"])){
				$oSixDices->rollDices(); //funktion rolldices från SixDices 

				echo($oSixDices->svgDices());

				$nbrOfRounds = $_COOKIE["nbrOfRounds"];//räknar upp antal rundor varje gång man trycker Roll Dice
				$nbrOfRounds++;
				$_COOKIE["nbrOfRounds"] = $nbrOfRounds;
				$sumOfAllRounds = $_COOKIE["sumOfAllRounds"];
				$sumOfAllRounds += $oSixDices->sumDices();	//räknar ihop summan av tärningarna och plussar på det
				$_COOKIE["sumOfAllRounds"] = $sumOfAllRounds;
				$snitt = $sumOfAllRounds / $nbrOfRounds; //räknar ut snittvärde
				
				setcookie("nbrOfRounds", $nbrOfRounds, time() + 3600); // sparar de nya värderna på kakorna
				setcookie("sumOfAllRounds", $sumOfAllRounds, time() + 3600);
				echo ("Antal rundor: " . $_COOKIE["nbrOfRounds"] . "<br>");
				echo ("Summan: " . $_COOKIE["sumOfAllRounds"] . "<br>"); // skriver ut värderna
				echo ("Medelvärde: " . $snitt);

				$disabled = false;
			}
//uppg 4
			if (isset($_POST["btnExit"]) && isset($_COOKIE["nbrOfRounds"]) && isset($_COOKIE["sumOfAllRounds"])){
				setcookie("nbrOfRounds", '', time() - 3600); // tar bort kakorna, De tomma '' representerar att vi inte kontrollerar något värde, om vi hade variablarna där i fick vi error att värdet inte kunde hittas. 
				setcookie("sumOfAllRounds", '', time() - 3600);
				//uppg 5 har blivit löst av alla $disabled = true/false vi lagt in i de olika if-satserna. 
				$disabled = true;
				
			}
			?>
		</div>

		<form action="<?php echo( $_SERVER["PHP_SELF"] ); ?>" method="post">
			<input type="submit" name="btnRoll" class="btn btn-primary" value="Roll six dices" <?php if($disabled) { echo("disabled"); } ?>/>
			<input type="submit" name="btnNewGame" class="btn btn-primary" value="New Game" />
			<input type="submit" name="btnExit" class="btn btn-primary" value="Exit" <?php if($disabled) { echo("disabled"); } ?>/>
		</form>

		<script src="script/animation.js"></script>
	</body>

</html>