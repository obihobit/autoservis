<?php 

class Marka extends Model{

	public $id = 0;
	public $naziv = '';
	public $opis = '';

	public function getAll()
	{
		$result = $this->connection
			->query('SELECT * FROM Marke');

		$marke = array();

		while($row = $result->fetch_assoc()) {

			$marka = new Marka;
			$marka->id = $row['id'];
			$marka->naziv = $row['naziv'];
			$marka->opis = $row['opis'];

			array_push($marke, $marka);
    	}

    	return $marke;
	}

	public static function findById($connection, $id)
	{
		$result = $connection->query(
			"SELECT * FROM Marke WHERE id = $id");

		$marka = new Marka;

		if($row = $result->fetch_assoc()) {

			$marka->id = $row['id'];
			$marka->naziv = $row['naziv'];
			$marka->opis = $row['opis'];
    	}

    	return $marka;
	}

	public function find($naziv)
	{
		$result = $this->connection->query(
			"SELECT * FROM Marke WHERE naziv LIKE '%$naziv%'");

		$marke = array();

		while($row = $result->fetch_assoc()) {

			$marka = new Marka;
			$marka->id = $row['id'];
			$marka->naziv = $row['naziv'];
			$marka->opis = $row['opis'];

			array_push($marke, $marka);
    	}

    	return $marke;
	}

	public function create()
	{
		$result = $this->connection->query("INSERT INTO Marke (naziv, opis) 
			VALUES ('$this->naziv', '$this->opis')");
		
		if ($result > 0) return true; else return false;
	}

	public function update()
	{
		$result = $this->connection->query("UPDATE Marke 
			SET naziv='$this->naziv', opis='$this->opis' WHERE id=$this->id");

		if ($result > 0) return true; else return false;
	}

	public function delete()
	{
		$result = $this->connection->query('DELETE FROM Marke WHERE id='.$this->id);

		if ($result > 0) return true; else return false;
	}
} ?>