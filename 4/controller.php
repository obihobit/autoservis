<?php 

	require 'config.php';

	include 'models/Model.php';
	include 'models/Artikl.php';
	include 'models/Kupon.php';
	include 'models/Marka.php';
	include 'models/Tip.php';

	$konekcija = new MySqli($mysql_server, $mysql_user, 
		$mysql_password, $mysql_db);

	if (isset($_GET['podaci'])) {
		
		switch ($_GET['podaci']) {

			case 'tipovi':

				error_reporting(0); # gasimo upozorenja
				$tip = new Tip($konekcija);
				echo json_encode($tip->getAll());
				break;

			case 'marke':

				error_reporting(0); # gasimo upozorenja
				$tip = new Marka($konekcija);
				echo json_encode($tip->getAll());
				break;

			case 'artikli':

				error_reporting(0); # gasimo upozorenja
				$artikl = new Artikl($konekcija);

				if (isset($_GET['kljuc']))
					echo json_encode($artikl->findById($_GET['kljuc']));

				else if (isset($_GET['model']))
					echo json_encode($artikl->findByModel($_GET['model']));

				else if (isset($_GET['marka']))
					echo json_encode($artikl->findByMark($_GET['marka']));

				else if (isset($_GET['tip']))
					echo json_encode($artikl->findByType($_GET['tip']));

				else if (isset($_GET['naziv']))
					echo json_encode($artikl->find($_GET['naziv']));

				else
					echo json_encode($artikl->getAll());
				break;

			case 'kuponi':

				error_reporting(0); # gasimo upozorenja
				$kupon = new Kupon($konekcija);
				echo json_encode($kupon->getAll());
				break;
			
			default:
				echo '<h1>Error 404</h1><p>Action not found...</p>';
				break;
		}
	}

	if (isset($_POST['podaci'])) {
		
		switch ($_POST['podaci']) {
			case 'tip':

				$tip = new Tip($konekcija);
				$tip->naziv = $_POST['naziv'];
				$tip->opis = $_POST['opis'];

				if ($tip->create()) 

					header('Location: setup/index.php');
				else
					echo 'Greska pri upisu tipa u bazu! '.
						mysqli_error($konekcija);
				break;

			case 'marka':

				$marka = new Marka($konekcija);
				$marka->naziv = $_POST['naziv'];
				$marka->opis = $_POST['opis'];

				if ($marka->create()) 

					header('Location: setup/index.php');
				else
					echo 'Greska pri upisu marke u bazu! '.
						mysqli_error($konekcija);
				break;

			case 'artikl':

				$artikl = new Artikl($konekcija);

				if (isset($_POST['akcija']) && 
					$_POST['akcija'] == 'ukloni') {

					if (isset($_POST['kljuc'])) {

						$artikl->id = $_POST['kljuc'];

						if ($artikl->delete())  echo 'OK'; 
						
						else echo 'Greska pri brisanju iz baze! '.
								mysqli_error($konekcija);
					}

				} elseif (isset($_POST['akcija']) && 
					$_POST['akcija'] == 'izmeni') {

					$artikl->id = $_POST['artId'];
					$artikl->tip = $_POST['tip'];
					$artikl->marka = $_POST['marka'];
					$artikl->model = $_POST['model'];
					$artikl->naziv = $_POST['naziv'];
					$artikl->stanje = $_POST['stanje'];
					$artikl->opis = $_POST['opis'];
					$artikl->cena = $_POST['cena'];
					$artikl->dodat = date('Y-m-d H:i:s');

					if ($artikl->update()) 

						header('Location: setup/index.php');
					else
						echo 'Greska pri azuriranju! '.
							mysqli_error($konekcija);

				} else {

					$artikl->tip = $_POST['tip'];
					$artikl->marka = $_POST['marka'];
					$artikl->model = $_POST['model'];
					$artikl->naziv = $_POST['naziv'];
					$artikl->stanje = $_POST['stanje'];
					$artikl->opis = $_POST['opis'];
					$artikl->cena = $_POST['cena'];
					$artikl->dodat = date('Y-m-d H:i:s'); 

					if ($artikl->create()) 

						header('Location: setup/index.php');
					else
						echo 'Greska pri upisu u bazu! '.
							mysqli_error($konekcija);

				}
				break;

			case 'kupon':

				$kupon = new Kupon($konekcija);

				$kupon->ime = $_POST['ime'];
				$kupon->email = $_POST['email'];
				$kupon->artikl = $_POST['artikl'];
				$kupon->adresa = $_POST['adresa'];
				$kupon->telefon = $_POST['telefon'];
				$kupon->kreiran = date('Y-m-d H:i:s');

				if ($kupon->create()) 

					header('Location: setup/index.php');
				else
					echo 'Greska pri upisu kupona u bazu! '.
						mysqli_error($konekcija);
				break;
			
			default:
				echo '<h1>Error 404</h1><p>Action not found...</p>';
				break;
		}
	}
 ?>