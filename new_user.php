<?php

	define("OK", 0);
	define("SERVER_ERROR", 1);
	define("BAD_USER_NAME_LENGTH", 2);
 	define("BAD_USER_PASS_LENGTH", 3);
 	define("USER_NAME_ALREADY_EXISTS", 4);
 	define("EMPTY_FIELDS", 5);
 	define("WRONG_PASS", 6);
 	define("EMAIL_ALREADY_EXISTS", 7);

 	function rejestruj($nazwa, $pass, $email)
 	{
 		$userNameLength = strlen($nazwa);
 		$userPassLength = strlen($pass);

 		if($userNameLength < 3 || $userNameLength > 20)
 			return BAD_USER_NAME_LENGTH;

 		if($userPassLength < 6 || $userPassLength > 40)
 			return BAD_USER_PASS_LENGTH;

 		if($nazwa == '' || $pass == '' || $email == '')
 			return EMPTY_FIELDS;

 		if(!@mysql_connect('localhost', 'root'))
			{
			echo 'Wystapil blad podczxas proby polaczenia z serwerem MySQL...';
			}

		if(!@mysql_select_db('mmdb'))
			{
			echo ' Wystapil blad podczas proby wybrania bazy danych....';
			mysql_close();
			}

 		$query = "SELECT COUNT(*) FROM Users WHERE Nazwa = '$nazwa'";
 		if(!$result = @mysql_query($query)) {
 			echo 'Wystapil blad: Instrukcja SELECT...';
 			@mysql_close();
 			return SERVER_ERROR;
 			}

 		if(!$row = @mysql_fetch_row($result)) {
 			echo 'Wystapil blad: nieprawidlowe wyniki zapytania...';
 			@mysql_close();
 			return SERVER_ERROR;
 			} else {
 				if($row[0] > 0) {
 					@mysql_close();
 					return USER_NAME_ALREADY_EXISTS;
 				}
 			}

 			$query2 = "SELECT COUNT(*) FROM Users WHERE Email = '$email'";
 		if(!$result = @mysql_query($query2)) {
 			echo 'Wystapil blad: Instrukcja SELECT...';
 			@mysql_close();
 			return SERVER_ERROR;
 			}

 		if(!$row = @mysql_fetch_row($result)) {
 			echo 'Wystapil blad: nieprawidlowe wyniki zapytania...';
 			@mysql_close();
 			return SERVER_ERROR;
 			} else {
 				if($row[0] > 0) {
 					@mysql_close();
 					return EMAIL_ALREADY_EXISTS;
 				}
 			}
        $data = date('Y-m-d') . ' ' . date('H:i');
 		$query = "INSERT INTO `Users` ( `id` , `Nazwa` , `Haslo` , `Email`, `typ`, `data` )
					VALUES (NULL , '$nazwa', '$pass', '$email', 0, '$data')";

 		if(!$result = @mysql_query($query)) {
 			echo 'Wystapil blad: Instrukcja INSERT...' . mysql_error();
			@mysql_close();
 			return SERVER_ERROR;
 			}

 		$count = @mysql_affected_rows();

 		if(!$count <> 1) {
 			@mysql_close();
 			return SERVER_ERROR;
 			} else {
 				@mysql_close();
 				return OK;
 			}

 		}

 		session_start();
 			if(isset($_SESSION['zalogowany'])) {
 				header("Location: index.php");
 			} else if(!isset($_POST['nazwa']) || !isset($_POST['pass']) ||
 					  !isset($_POST['email'])) {
 				include "new_user.php";
 			} else {
 				?>

<?php
session_start();
ob_start();
include 'config.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<title>My Music</title>
</head>

<center>
<body bgcolor="#1c1d21">

<div id="top">
	<div id="tc">
<div id="top1"></div>

<div id="top2">
	<a href="index.php"><img border=0 src="images/top_02.png" onmouseover="src='images/top_over_02.png'" onmouseout="src='images/top_02.png'"></a>
</div>

<div id="top3">
	<a href="search.php"><img border=0 src="images/top_03.gif"onmouseover="src='images/top_over_03.gif'" onmouseout="src='images/top_03.gif'"></a>
</div>

<div id="top4">
	<a href="log_form.php"><img border=0 src="images/top_04.gif"onmouseover="src='images/top_over_04.gif'" onmouseout="src='images/top_04.gif'"></a>
</div>
	</div>
</div>

<div id="main">


<div id="stats">
		<?php include 'stats.php'; ?>
</div>

<div id="logo"></div>


<div id="sep"><?php include 'checklogin.php'; ?></div>
<div id="sep2"></div>


<div id="news">
	<div id="news_top"></div>
	<div id="news_last">
		<?php
		$lastwyk = @mysql_fetch_array(@mysql_query("SELECT * FROM wykonawcy ORDER BY dodany DESC LIMIT 1"));
  			echo '<div id="lastwyk">-->
  			<a href="' . $_SERVER['PHP_SELF'] . '?author=' . $lastwyk['id'] . '">' . $lastwyk['autor'] . '</a>
  			</div>';

  		$lastalb = @mysql_fetch_array(@mysql_query("SELECT nazwa FROM albumy ORDER BY dodany DESC LIMIT 1"));
  			echo '<div id="lastalb">--> ' . $lastalb['nazwa'] . '</div>';
		?>
	</div>
	<div id="news_sep"></div>
	<div id="news_new"></div>
	<div id="news_new_bg">
		<?php
		if (file_exists('info.txt')){
    		echo '<div id="news_txt">';
			include 'info.txt';
			echo '</div>';
		}
		?>
	</div>
	<div id="news_bott"></div>
</div>


<div id="lista">

<div align="center" id="search">
<br>
<?php

	$nazwa = $_POST['nazwa'];
	$pass = $_POST['pass'];
	$email = $_POST['email'];

	$val = rejestruj($nazwa, $pass, $email);

	if($val == OK) {
		echo "Rejestracja zakonczona mozesz sie zalogowac.";
		} else if($val == BAD_USER_NAME_LENGTH) {
			echo "Nazwa uzytkownika musi miec od 3 do 20 znakow!";

		} else if($val == BAD_USER_PASS_LENGTH) {
			echo "Haslo musi miec od 6 do 40 znakow!";

		} else if($val == USER_NAME_ALREADY_EXISTS) {
			echo "Uzytkownik " . $_POST['nazwa'] . " juz istnieje!";
		} else if($val == EMAIL_ALREADY_EXISTS) {
			echo "Adres Email:" . $email . " jest juz uzywany";
		} else if($val == EMPTY_FIELDS) {
			echo "Uzupelnij wszystkie pola";
		} else {
			echo "Blad servera... Rejestracja nie powiodla sie";
		}
	}

?>
<br><br>
</div>

</div>
<div id="search_bott"></div>

</div>

</div>

</div>

</div>

</body>