<?php 

	require 'config.php';

	include 'models/Model.php';
	include 'models/Artikl.php';
	include 'models/Kupon.php';
	include 'models/Marka.php';
	include 'models/Tip.php';

	$konekcija = new MySqli($mysql_server, $mysql_user, 
		$mysql_password, $mysql_db);

	error_reporting(0); # gasimo greske
	$artikl = new Artikl($konekcija);

	if (isset($_GET['type'])) {

		if ($_GET['type'] == 'json') {
			echo json_encode($artikl->getAll());
		} 

		if ($_GET['type'] == 'xml') {

			header('Content-Type:text/xml', 200);

			$data = '<rss>';
			$data .= '<title> Auto Delovi </title>';
			$data .= '<items>';

			$artikl = new Artikl($konekcija);
			foreach ($artikl->getAll() as $proizvod) {
				
				$data .= '<item>';
				$data .= '<name>'.$proizvod->naziv.'</name>';
				$data .= '<type>'.$proizvod->tip->naziv.'</type>';
				$data .= '<mark>'.$proizvod->marka->naziv.'</mark>';
				$data .= '<descript>'.$proizvod->opis.'</descript>';
				$data .= '<price>'.$proizvod->cena.'</price>';
				$data .= '<amount>'.$proizvod->stanje.'</amount>';
				$data .= '</item>';
			}

			$data .= '</items>';
			$data .= '</rss>';

			$xml = new SimpleXMLElement($data);
			print $xml->asXML();
		} 

		if ($_GET['type'] == 'stats') {

			$result = $konekcija->query(
				"SELECT t.naziv, COUNT(*) as br_art, a.cena FROM Artikli a 
				JOIN Tipovi t ON a.tip = t.id GROUP BY a.tip");

			$stats = array(array('Naziv tipa', 'Broj artikala', 'Cena artikla' ));

			while($row = $result->fetch_assoc()) {

				array_push($stats, array(
					$row['naziv'],  $row['br_art'],  $row['cena']));
		    }

			echo json_encode($stats);	
		}
			
	} else echo json_encode($artikl->getAll());
?>
