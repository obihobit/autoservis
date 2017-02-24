<?php 

class Kupon extends Model{

	public $id = 0;
	public $ime = '';
	public $email = '';
	public $artikl = 0;
	public $adresa = '';
	public $telefon = 0;
	public $kreiran = '';

	private function toObjectArray($result)
	{
		$kuponi = array();

		while($row = $result->fetch_assoc()) {

			$kupon = new Kupon;
			$kupon->id = $row['id'];
			$kupon->ime = $row['ime'];
			$kupon->email = $row['email'];
			$kupon->adresa = $row['adresa'];
			$kupon->telefon = $row['telefon'];
			$kupon->kreiran = $row['kreiran'];
			$kupon->artikl = $row['artikl'];

			array_push($kuponi, $kupon);
    	}

    	return $kuponi;
	}

	public function getAll()
	{
		$result = $this->connection
			->query('SELECT * FROM Kuponi');

		return $this->toObjectArray($result);
	}

	public function findById($id)
	{
		$result = $this->connection->query(
			"SELECT * FROM Kuponi WHERE id = $id");

		$kupon = new Kupon;

		if($row = $result->fetch_assoc()) {

			$kupon = new Kupon;
			$kupon->id = $row['id'];
			$kupon->artikl = $row['artikl'];
			$kupon->ime = $row['ime'];
			$kupon->email = $row['email'];
			$kupon->adresa = $row['adresa'];
			$kupon->telefon = $row['telefon'];
			$kupon->kreiran = $row['kreiran'];
    	}

    	return $kupon;
	}

	public function find($ime)
	{
		$result = $this->connection->query(
			"SELECT * FROM Kuponi WHERE ime LIKE '%$ime%'");

		return $this->toObjectArray($result);
	}

	public function create()
	{
		$result = $this->connection->query("INSERT INTO Kuponi (artikl, ime, email, adresa, telefon, kreiran) 
			VALUES ('$this->artikl', '$this->ime', '$this->email', '$this->adresa', '$this->telefon', '$this->kreiran')");
		
		if ($result > 0) return true; else return false;
	}

	public function update()
	{
		$result = $this->connection->query("UPDATE Kuponi SET artikl='$this->artikl', ime='$this->ime', 
			email='$this->email', adresa='$this->adresa', telefon='$this->telefon', kreiran='$this->kreiran' WHERE id=$this->id");

		if ($result > 0) return true; else return false;
	}

	public function delete()
	{
		$result = $this->connection->query('DELETE FROM Kuponi WHERE id='.$this->id);

		if ($result > 0) return true; else return false;
	}
} ?>