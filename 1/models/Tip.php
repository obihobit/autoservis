<?php 

class Tip extends Model{

	public $id = 0;
	public $naziv = '';
	public $opis = '';

	public function getAll()
	{
		$result = $this->connection
			->query('SELECT * FROM Tipovi');

		$tipovi = array();

		while($row = $result->fetch_assoc()) {

			$tip = new Tip;
			$tip->id = $row['id'];
			$tip->naziv = $row['naziv'];
			$tip->opis = $row['opis'];

			array_push($tipovi, $tip);
    	}

    	return $tipovi;
	}

	public static function findById($connection, $id)
	{
		$result = $connection->query(
			"SELECT * FROM Tipovi WHERE id = $id");

		$tip = new Tip;

		if($row = $result->fetch_assoc()) {

			$tip->id = $row['id'];
			$tip->naziv = $row['naziv'];
			$tip->opis = $row['opis'];
    	}

    	return $tip;
	}

	public function find($naziv)
	{
		$result = $this->connection->query(
			"SELECT * FROM Tipovi WHERE naziv LIKE '%$naziv%'");

		$tipovi = array();

		while($row = $result->fetch_assoc()) {

			$tip = new Tip;
			$tip->id = $row['id'];
			$tip->naziv = $row['naziv'];
			$tip->opis = $row['opis'];

			array_push($tipovi, $tip);
    	}

    	return $tipovi;
	}

	public function create()
	{
		$result = $this->connection->query("INSERT INTO Tipovi (naziv, opis) 
			VALUES ('$this->naziv', '$this->opis')");
		
		if ($result > 0) return true; else return false;
	}

	public function update()
	{
		$result = $this->connection->query("UPDATE Tipovi 
			SET naziv='$this->naziv', opis='$this->opis' WHERE id=$this->id");

		if ($result > 0) return true; else return false;
	}

	public function delete()
	{
		$result = $this->connection->query('DELETE FROM Tipovi WHERE id='.$this->id);

		if ($result > 0) return true; else return false;
	}
} ?>