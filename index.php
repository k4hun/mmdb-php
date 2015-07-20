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
	<div id="lista_top"></div>
	<div id="tab_top"></div>
	<div id="tab_bg">

<div id="tab"><center>
<?php


$query1 = mysql_query('SELECT * FROM wykonawcy');
    $ile = mysql_num_rows($query1);
    $na_strone = 20;
    $stron = ceil ($ile / $na_strone);
    if (!isset($_GET['strona'])) $strona = 1;
    else $strona = (int)$_GET['strona'];

	$list = @mysql_query("SELECT * FROM wykonawcy ORDER BY autor LIMIT ".(($strona-1)*$na_strone).','.$na_strone."");
	if (!$list) {
		exit ('Blad podczas wykonywania zapytania: ' . mysql_error() . '<br><br>');
	}
	$i=1;
	while ($authors = @mysql_fetch_array($list)) {
		$autor = $authors['autor'];
		$albumy = $authors['albumy'];
		$autorid = $authors['id'];
		$link = $authors['link'];
		if ($link != '') {
			echo '
			<div id="id">' . $i . '</div>
			<div id="autor"><a href="wyk.php?ida=' . $autorid . '">' . cut($autor, 40) . '</a></div>
    		<div id="album">' . $albumy . '</div>
			<div id="link"><a href="' . $link . '">' . substr($link, 11, -1) . '</a></div>';
		} else {
			echo '
			<div id="id">' . $i . '</div>
			<div id="autor"><a href="wyk.php?ida=' . $autorid . '">' . cut($autor, 40) . '</a></div>
    		<div id="album">' . $albumy . '</div>
			<div id="link">-</div>';
		}
	$i++;
	}

?>
</div>

</div>

<div id="tab_bott">

<?php

echo '<div id="str">';
	if(isset($_GET['strona']) && $_GET['strona']>1){
         echo '<a href="index.php?strona='.($_GET['strona']-1).'">
		 		<b> < </b>
			</a> ';
  	}
  	for($i = 0;$i<= $stron-1;$i++){
            if($i==$strona-1){ echo '<b><u>'.($strona).'</u></b>';
            }else{
            echo '<a class="str" href="index.php?strona='.($i+1).'"> '.($i+1).' </a> ';
            }
  	}
  	if(isset($_GET['strona']) && $_GET['strona'] < $stron){
        echo ' <a href="index.php?strona='.($_GET['strona']+1).'">
				<b> > </b>
			</a>';
  	}
  	}
ob_end_flush();
?>

</div>

</div>

</div>

</div>


</body>