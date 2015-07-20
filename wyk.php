<?php
session_start();
ob_start();
include 'config.php';

function cut($txt,$x)
{
$tlen = strlen($txt);
if($x < 1) return '';
if($x >= $tlen -1) return $txt;
while ($txt{$x} != ' ' && ++$x < $tlen);
$new = substr($txt, 0, $x);
return $new.'...';
}

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
	<a href="index.php"><img border=0 src="images/top_over_02.png"></a>
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
			<br><div align="center">Aby przegladac liste musisz sie zalogowac</div><br>
			</div>

			</div>
			<div id="search_bott"></div>';
	} else {
?>

<div id="lista">
	<div id="lista_top">
		<?php
			$authorid = $_GET['ida'];
			$info = @mysql_fetch_array(@mysql_query("SELECT * FROM albumy, wykonawcy WHERE idautora=wykonawcy.id AND idautora=$authorid ORDER BY albumy.nazwa"));
			$autorr = $info['autor'];
			$albumyy = $info['albumy'];
				echo '<div id="panel">
				<div id="info">' . $autorr . ' - albumy: ' . $albumyy . '</div>';
		?>
	</div>
	<div id="tab_alb_top"></div>
	<div id="tab_bg">

<div id="tab"><center>

<?php
	$authorid = $_GET['ida'];
		$listaalbumow = @mysql_query("SELECT * FROM albumy, wykonawcy WHERE idautora=wykonawcy.id AND idautora=$authorid ORDER BY albumy.nazwa");
		if (!$listaalbumow) {
		exit ('B³¹d podczas wykonywania zapytania!' . mysql_error());
		}

	$i = 1;
	while ($album = @mysql_fetch_array($listaalbumow)) {
		$nazwa = $album['nazwa'];
		$rok = $album['rok'];
		//$cena = $album['cena'];
		$albumid = $album['id'];
	echo '<center>
			<div id="id">' . $i . '</div>
			<div id="autor">' . cut($nazwa, 40) . '</div>
    		<div id="album">' . $rok . '</div>
    		<div id="link"> - </div>
		</center>';
		$i++;
	}
    }
?>

</div>

</div>

<div id="tab_bott">

</div>

</div>

</div>

</div>



</body>