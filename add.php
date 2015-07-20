<table width=450 border=0>
<tr>
<td colspan=2><form action=" <?php echo $_SERVER['PHP_SELF'] . '?add=1'; ?> " method="POST">
		<label><b>Dodaj wykonawce:</b><br></label></td></tr>

<tr><td colspan=2><input class="input" type="text" name="wykonawca"></td></tr>

<tr><td width=104>Liczba albumow:</td><td><input class="input" type="Text" name="ilealb"></td>

<tr><td width=104>Link:</td><td><input class="input" type="Text" name="link"></td>

<tr><td colspan=2><input class="submit" type="submit" value="Dodaj"></td></tr>
	</form>
</td></tr></table>

<?php
if (isset($_POST['wykonawca'], $_POST['ilealb'])) {
$link = $_POST['link'];
$wyk = ucwords(strtolower($_POST['wykonawca']));
$ileabl = $_POST['ilealb'];
	$addwyk = "INSERT INTO wykonawcy SET autor = '$wyk', albumy = '$ilealb', link = '$link', dodany ='" . date('Y-m-d') . ' ' . date('H:i') . "'";
	if (@mysql_query($addwyk)) {
	echo '<hr> Dodano ' . $wyk . '.';
	} else {
	echo 'Blad podczas dodawania ' . $wyk . ' - ' . mysql_error();
	}
}
?>

<hr>

<table width=450 border=0>
<tr><td colspan=2><form action=" <?php echo $_SERVER['PHP_SELF'] . '?add=1'; ?> " method="POST">
		<label><b>Dodaj album:</b><br></label></td></tr>

<tr><td colspan=2>
<select class="input" name="id">
		<option value="">Wybierz wykonawce!</option>
		<option value="">-------------------------</option>' .
	<? $list = @mysql_query("SELECT * FROM wykonawcy ORDER BY autor");
	if (!$list) {
		exit ('Blad podczas wykonywania zapytania: ' . mysql_error() . '<br><br>');
	}
	while ($authors = @mysql_fetch_array($list)) {
		$autor = $authors['autor'];
		$id = $authors['id'];
	echo '<option value=' . $id . '>' . $autor . '</option>';
	}
?>
	</select></td></tr>
<tr><td width=50>Album:</td>
<td><input class="input" type="text" name="album"></td></tr>

<tr><td width=50>Rok:</td>
<td><input class="input" type="text" name="rok"></td></tr>

<tr><td width=50>Rozmiar:</td>
<td><input class="input" type="text" name="rozmiar"></td></tr>

<tr><td colspan=2><input class="submit" type="submit" value="Dodaj">

</form></td></tr></table>

<?php
if (isset($_POST['id'], $_POST['album'])) {
$id = $_POST['id'];
$alb = ucwords(strtolower($_POST['album']));
$rok = $_POST['rok'];
$rozmiar = $_POST['rozmiar'];
	$addalb = "INSERT INTO albumy SET nazwa = '$alb', rok = '$rok', idautora = '$id', rozmiar = '$rozmiar', dodany ='" . date('Y-m-d') . ' ' . date('H:i') . "'";
	if (@mysql_query($addalb)) {
	echo '<hr>Dodano album ' . $alb . '.';
	} else {
	echo 'B³¹d podczas dodawania ' . $alb . ' - ' . mysql_error();
	}
}
?>
