<?php
	function checkPass($login, $pass)
  {

	$userNameLength = strlen($login);
	$userPassLength = strlen($pass);

	if($userNameLength < 3 || $userNameLength > 20 ||
	   $userPassLength < 6 || $userPassLength >40)
	   {
	   	return 2;
	   }

	if(!@mysql_connect('localhost', 'root'))
	{
		echo 'Wystapil blad podczxas proby polaczenia z serwerem MySQL...';
		return 1;
	}

	if(!@mysql_select_db('mmdb'))
	{
		echo ' Wystapil blad podczas proby wybrania bazy danych....';
		mysql_close();
		return 1;
	}

	$query = "select count(*) from Users where Nazwa='$login' and Haslo='$pass'";

	if(!$result = mysql_query($query))
	{
		echo 'Wystapil blad: nieprawidlowe zapytanie';
		mysql_close();
		return 1;
	}

	if(!$row = mysql_fetch_row($result))
	{
		echo 'Wystapil blad: nieprawidlowe zapytanie';
		mysql_close();
		return 1;
	} else {
		if($row[0] <> 1)
		{
			@mysql_close();
			return 2;
		} else {
			@mysql_close();
			return 0;
		}
	}

}

	if(isset($_SESSION['zalogowany']))
	{
		header("Location: index.php");
		} elseif(!isset($_POST['login']) || !isset($_POST['pass'])) {
		echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">
					<label>Login:<br>
					<input type="text" name="login" class="input"></label><br>
					<label>Pass:<br>
					<input type="password" name="pass" class="input"></label><br>
					<input type="submit" value="Zaloguj" class="submit" name="zaloguj">
				</form>';

	} else {
		$val = checkPass($_POST['login'], $_POST['pass']);
		$login = $_POST['login'];

		if($val == 0) {
			$_SESSION['zalogowany'] = $_POST['login'];
			header("Location: index.php");

        } elseif($val == 1) {
			echo $_SESSION['komunikat'] = "Blad serwera. Zalogowanie nie bylo mozliwe.";

		} elseif($val == 2) {
			echo $_SESSION['komunikat'] = "Nieprawidlowa nazwa lub haslo uzytkownika.";

		} else {
			echo $_SESSION['komunikat'] = "Blad serwera. Zalogowanie nie bylo mozliwe.";
		}
	}


ob_end_flush();

?>
