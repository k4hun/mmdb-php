<?php
if(isset($_GET['logout'])) {
	unset($_SESSION['zalogowany']);
	session_destroy();
}
if(isset($_SESSION['zalogowany'])) {
	$qu = @mysql_fetch_array(@mysql_query("select typ from Users where Nazwa = '" . $_SESSION['zalogowany'] . "'"));
	$admin = $qu['typ'];
	$_SESSION['admin'] = $admin;

	echo '<div id="logstat">Zalogowany jako: <u>' . $_SESSION['zalogowany'] . '</u>';
	echo '<a href="index.php?logout=1">(Logout)</a>';

	if($_SESSION['admin'] == '1') { 
		echo '<br><a href="admin.php">Panel Admina</a></div>'; 
	} else { 
		echo '<br><br><br>';
	}
} else {
   	echo '<div id="logstat">Nie jestes zalogowany</div>';
}

?>