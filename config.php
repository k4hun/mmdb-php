<?php
	if(!$db_link = @mysql_connect('localhost', 'root'))
	{
		echo 'Wystapil blad podczxas proby polaczenia z serwerem MySQL...';
	}

	if(!@mysql_select_db('mmdb'))
	{
		echo ' Wystapil blad podczas proby wybrania bazy danych....';
		mysql_close();
	}
?>