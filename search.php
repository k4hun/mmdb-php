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
	<a href="search.php"><img border=0 src="images/top_over_03.gif"></a>
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
  			<a href="wyk.php?ida=' . $lastwyk['id'] . '">' . $lastwyk['autor'] . '</a>
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

<?php
	if (!isset($_SESSION['zalogowany'])) {
	echo '<div id="lista">

			<div id="search">
			<br><div align="center">Aby korzystac z wyszukiwarki musisz sie zalogowac</div><br>
			</div>

			</div>
			<div id="search_bott"></div>';
	} else {
?>

<div id="lista">

<div id="search">
	<div id="search_form_l"><br>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<b>Szukaj wykonawcy:</b><br>
		<input class="input" type="text" name="szukwyk">
		<input class="submit" type="submit" value="Szukaj">
		</form>
	</div>

	<div id="search_form_r"><br>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<b>Szukaj album:</b><br>
		<input class="input" type="text" name="szukalb">
		<input class="submit" type="submit" value="Szukaj">
	</form>
	</div>

	<div id="search_result_l">
<?php

	if(isset($_POST['szukwyk'])) {
		if ($_POST['szukwyk'] == '') {
			echo('Nie znalazlem 풹dnego wykonawcy');
		} else {
			$szukwyk = ucwords(strtolower($_POST['szukwyk']));
			$list = @mysql_query("SELECT * FROM wykonawcy WHERE autor LIKE '%$szukwyk%'");
			$countwyk = @mysql_fetch_array(@mysql_query("SELECT COUNT(*) AS ile FROM wykonawcy WHERE autor LIKE '%$szukwyk%'"));
			if (!$list) {
				echo ('Nie znalazlem 풹dnego wykonawcy');
			} else {
				echo 'Znalezieni wykonawcy (' . $countwyk['ile'] . ')<br>-------------------------------------------------------------------';
				while ($authors = @mysql_fetch_array($list)) {
					$autor = htmlspecialchars($authors['autor']);
					$albumy = $authors['albumy'];
					$autorid = $authors['id'];
					$link = $authors['link'];
					echo '<center>
						<a href="wyk.php?ida=' . $autorid . '"><b>' . $autor . '</b></a><br>
			    		Albumy: ' . $albumy . '<br>

					</center><br>';
				}
			}
		}
	}
?>
</div>

<div id="search_result_r">
<?php
	if (isset($_POST['szukalb'])) {
		if ($_POST['szukalb'] == '') {
			echo('Nie znalazlem 풹dnego albumu');
		} else {
		$szukalb = ucwords(strtolower($_POST['szukalb']));
		$albums = @mysql_query("SELECT * FROM albumy, wykonawcy WHERE wykonawcy.id = albumy.idautora AND nazwa LIKE '%$szukalb%'");
		$countalb = @mysql_fetch_array(@mysql_query("SELECT COUNT(*) AS ile FROM albumy WHERE nazwa LIKE '%$szukalb%' "));
		if (!$albums) {
				echo ('Nie znalazlem 풹dnego albumu');
			} else {
				echo 'Znalezione albumy (' . $countalb['ile'] . ')<br>-------------------------------------------------------------------';
				while ($album = @mysql_fetch_array($albums)) {
					$albumname = htmlspecialchars($album['nazwa']);
					$albumauthor = $album['autor'];
				echo '<center><b>' . $albumname . ' - ' . $albumauthor . '</b></center><br>';
				}
			}
		}
	}


?>
</div>

</div>
<div id="search_bott"></div>

<?php } ?>
</div>

</div>

</div>


</body>