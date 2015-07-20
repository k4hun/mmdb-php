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
	if(!$_SESSION['admin'] == '1') {
		echo '<div id="lista">

			<div id="search">
			<br><div align="center">Dostep do tej strony ma wylacznie administrator</div><br>
			</div>

			</div>
			<div id="search_bott"></div>';
		} else {
?>
<div id="lista">

<div id="search">

<br><div id="admmenu">
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?add=1">Dodaj</a> |
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?del=1">Usun</a> |
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?edit=1">Edytuj</a>
</div><br>

<div id="oper">
<?php

	if (isset($_GET['add'])) {		include 'add.php';
	} else {		if (isset($_GET['del'])) {				include 'delete.php';
		} else {			if (isset($_GET['edit'])) {				include 'edit.php';
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


</body>