<form action="<?php echo $_SERVER['PHP_SELF'] . '?del=1'; ?>" method="get">
<b>Usun wykonawce <br> oraz wszystkie jego albumy:</b><br />
<input type="hidden" name="del" value="1">
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
		$id = $authors['id'];
		echo '<option value=' . $id . '>' . $autor . '</option>';
	}
?>
</select>
<input class="submit" type="submit" value="Usun">
</form>



<?php
if (isset($_GET['wykid'])) {
	$id = $_GET['wykid'];
	$delete1 = @mysql_query("DELETE FROM wykonawcy WHERE id = '$id' ");
	$delete2 = @mysql_query("DELETE FROM albumy WHERE idautora = '$id' ");

	if ($delete1 && $delete2) {
		echo '<hr>Usunieto wykonawce oraz wszystkie jego albumy!';
	} else {
		echo 'Blad podczas usuwania: ' . mysql_error();
	}

}
?>


<hr>



<form action="<?php echo $_SERVER['PHP_SELF'] . '?del=1'; ?>" method="get">
<b>Usun album:</b><br />
<input type="hidden" name="del" value="1">
<select class="input" name="albid">
		<option value="">Wybierz album!</option>
		<option value="">---------------</option>
	<?php
	$list = @mysql_query("SELECT * FROM albumy ORDER BY nazwa");
	if (!$list) {
		exit ('Blad podczas wykonywania zapytania: ' . mysql_error() . '<br><br>');
	}
	while ($albums = @mysql_fetch_array($list)) {
		$album = $albums['nazwa'];
		$id = $albums['id'];
	echo '<option value=' . $id . '>' . $album . '</option>';
	}
?>
</select>
<input class="submit" type="submit" value="Usun">
</form>



<?php
if (isset($_GET['albid'])) {
$id = $_GET['albid'];
	$delete3 = @mysql_query("DELETE FROM albumy WHERE id = '$id' ");
if ($delete3) {
	echo '<hr>Usunieto';
} else {
	echo 'Blad podczas usuwania: ' . mysql_error();
}
}

?>