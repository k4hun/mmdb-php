
<form action=" <?php echo $_SERVER['PHP_SELF'] . '?edit=1'; ?> " method="post">
<b>Edytuj wykonawce:</b><br />
<select class="input" name="wykid">
		<option value="">Wybierz wykonawce!</option>
		<option value="">---------------</option>
	<?php
	$list = @mysql_query("SELECT * FROM wykonawcy ORDER BY autor");
	if (!$list) {
		exit ('Blad podczas wykonywania zapytania: ' . mysql_error() . '<br><br>');
	}
	while ($authors = @mysql_fetch_array($list)) {
		$autor = $authors['autor'];
		$wykid = $authors['id'];
	echo '<option value="' . $wykid . '">' . $autor . '</option>';
	}
?>
</select>
Zmien na: <input class="input" type="text" name="newname"><br>
<input class="submit" type="submit" value="Akceptuj">
</form>



<?php
if (isset($_POST['wykid'], $_POST['newname'])) {
	$newname = ucwords(strtolower($_POST['newname']));
	$wykid = $_POST['wykid'];
	$editwyk = @mysql_query("UPDATE wykonawcy SET autor = '$newname' WHERE id='$wykid'");
	if ($editwyk) {
		echo '<hr>Nazwa wykonawcy zmieniona pomyslnie';
	} else {
		echo '<hr>Blad podczas edytowania wykonawcy: ' . mysql_error();
	}
}
?>

<hr>


<form action=" <?php echo $_SERVER['PHP_SELF'] . '?edit=1'; ?> " method="post">
Ilosc albuow <select class="input" name="albid">
		<option value="">Wybierz wykonawce!</option>
		<option value="">---------------</option>
	<?php
	$list = @mysql_query("SELECT * FROM wykonawcy ORDER BY autor");
	if (!$list) {
		exit ('Blad podczas wykonywania zapytania: ' . mysql_error() . '<br><br>');
	}
	while ($authors = @mysql_fetch_array($list)) {
		$autor = $authors['autor'];
		$albid = $authors['id'];
	echo '<option value="' . $albid . '">' . $autor . '</option>';
	$i++;
	}
?>

</select> zmien na: <input class="input" type="text" name="ilealb"><br>
<input class="submit" type="submit" value="Akceptuj">
</form>

<?php
if (isset($_POST['albid'], $_POST['ilealb'])) {
	$ilealb = $_POST['ilealb'];
	$albid = $_POST['albid'];
	$editile = "UPDATE wykonawcy SET albumy = '$ilealb' WHERE id='$albid' ";
	if (@mysql_query($editile)) {
		echo '<hr>Ilosc albumow zmieniona pomyslnie';
	} else {
		echo '<hr>Blad podczas edytowania wykonawcy: ' . mysql_error();
	}
}
?>


<hr><br><hr>


<form action=" <?php echo $_SERVER['PHP_SELF'] . '?edit=1'; ?> " method="POST">
<b>Szukaj album aby go edytowac:</b><br>
<input class="input" class="text" type="text" name="szukalb">
<input class="submit" type="submit" value="Szukaj">
</form><br>

<?php
if (isset($_POST['szukalb'])) {
$szukalb = ucwords(strtolower($_POST['szukalb']));
$albums = @mysql_query("SELECT DISTINCT * FROM albumy WHERE nazwa LIKE '%$szukalb%'");
if (!$albums) {
	exit ('Nie znalazlem podanego albumu: ' . mysql_error() );
} else {
	while ($album = @mysql_fetch_array($albums)) {
		$albumname = htmlspecialchars($album['nazwa']);
		$albumrok = $album['rok'];
		// $autor = $album['autor'];
		$rozmiar = $album['rozmiar'];
		$idaut = $album['idautora'];
		$id = $album['id'];
	echo 'Znaleziony album to: <b>' . $autor . ' - ' . $albumname . '</b><br>--------------------------------------------
<form action="' . $_SERVER['PHP_SELF'] . '?edit=1" method="POST">
Wykonawce <b>' . $autor . '</b> zmien na:<br>
<select class="input" name="idwyk">
		<option value="">Wybierz wykonawce!</option>
		<option value="">---------------</option>' .
	$list = @mysql_query("SELECT * FROM wykonawcy ORDER BY autor");
	if (!$list) {
		exit ('Blad podczas wykonywania zapytania: ' . mysql_error() . '<br><br>');
	}
	while ($authors = @mysql_fetch_array($list)) {
		$autor = $authors['autor'];
		$idwyk = $authors['id'];
	echo '<option value="' . $idwyk . '">' . $autor . '</option>';
	}
echo '
</select><br>
			Album: <b>' . $albumname . '</b> zmien na:<br>
<input class="input" class="text" type="text" name="newname"><br>
			Rok: <b>' . $albumrok . '</b> zmien na:<br>
<input class="input" type="text" name="newyear"><br>
			Rozmiar: <b>' . $rozmiar . ' Mb</b> zmien na:<br>
<input class="input" type="text" name="rozmiar"><br>

<input type="hidden" name="id" value="' . $id . '">
<input class="submit" type="submit" value="Zmien">
</form><hr>';
	}
}
}

if (isset($_POST['idwyk'], $_POST['id'])) {
	$idwyk = $_POST['idwyk'];
	$id = $_POST['id'];
	$editalb = ("UPDATE albumy SET idautora = '$idwyk' WHERE albumy.id = '$id'");
	if (@mysql_query($editalb)) {
		echo 'Wykonawca zmieniony pomyslnie!<br>';
	} else {
		echo 'Nie udalo sie zmienic danych!';
	}
}

if (isset($_POST['newname'], $_POST['id'])) {
	$newname = ucwords(strtolower($_POST['newname']));
	if ($newname != '') {
	$id = $_POST['id'];
	$editalb1 = ("UPDATE albumy SET nazwa = '$newname' WHERE id = '$id'");
	if (@mysql_query($editalb1)) {
		echo 'Nazwa zmieniona pomyslnie!<br>';
	} else {
		echo 'Nie udalo sie zmienic danych!';
	}
}
}

if (isset($_POST['newyear'], $_POST['id'])) {
	$newyear = $_POST['newyear'];
	if ($newyear != '') {
	$id = $_POST['id'];
	$editalb2 = ("UPDATE albumy SET rok = '$newyear' WHERE id = '$id'");
	if (@mysql_query($editalb2)) {
		echo 'Rok zmieniony pomyslnie!';
	} else {
		echo 'Nie udalo sie zmienic danych!';
	}
}
}

if (isset($_POST['rozmiar'], $_POST['id'])) {
	$nsize = $_POST['rozmiar'];
	if ($nsize != '') {
	$id = $_POST['id'];
	$editalb3 = ("UPDATE albumy SET rozmiar = '$nsize' WHERE id = '$id'");
	if (@mysql_query($editalb3)) {
		echo 'Rozmiar zmieniony pomyslnie!<br>';
	} else {
		echo 'Nie udalo sie zmienic danych!';
	}
}
}
?>