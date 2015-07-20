<?php
		$staty = @mysql_query("SELECT COUNT(*) AS ileautorow FROM wykonawcy");
		$staty2 = @mysql_query("SELECT COUNT(*) AS ilealbumow FROM albumy");
		$staty3 = @mysql_query("SELECT SUM( rozmiar ) AS size FROM albumy");
		$row = @mysql_fetch_array($staty);
		$ile = $row['ileautorow'];
		$row2 = @mysql_fetch_array($staty2);
		$ile2 = $row2['ilealbumow'];
		$row3 = @mysql_fetch_array($staty3);
		$ile3 = $row3['size'];

		echo '<div id="ilealb">' . $ile2 . '</div>
			<div id="ilewyk">' . $ile . '</div>
			<div id="size">' . round($ile3, 2) . ' Mb <br> ' . round($ile3/1024, 2) . ' Gb</div>';
	?>