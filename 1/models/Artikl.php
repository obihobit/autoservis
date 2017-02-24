<?php 

class Artikl extends Model{

	public $id = 0;
	public $tip = 0;
	public $cena = '';
	public $opis = '';
	public $marka = '';
	public $model = '';
	public $naziv = '';
	public $stanje = '';
	public $dodat = '';

	private function toObjectArray($result)
	{
		$artikli = array();

		while($row = $result->fetch_assoc()) {

			$artikl = new Artikl;
			$artikl->id = $row['id'];
			$artikl->cena = $row['cena'];
			$artikl->naziv = $row['naziv'];
			$artikl->model = $row['model'];
			$artikl->tip = Tip::findById(
				$this->connection, $row['tip']);
			$artikl->marka = Marka::findById(
				$this->connection, $row['marka']);
			$artikl->stanje = $row['stanje'];
			$artikl->opis = $row['opis'];

			array_push($artikli, $artikl);
    	}

    	return $artikli;
	}

	public function getAll()
	{
		$result = $this->connection
			->query('SELECT * FROM Artikli');

		return $this->toObjectArray($result);
	}

	public function findById($id)
	{
		$result = $this->connection->query(
			"SELECT * FROM Artikli WHERE id = $id");

		$artikl = new Artikl;

		if($row = $result->fetch_assoc()) {

			$artikl = new Artikl;
			$artikl->id = $row['id'];
			$artikl->tip = Tip::findById(
				$this->connection, $row['tip']);
			$artikl->marka = Marka::findById(
				$this->connection, $row['marka']);
			$artikl->stanje = $row['stanje'];
			$artikl->model = $row['model'];
			$artikl->naziv = $row['naziv'];
			$artikl->opis = $row['opis'];
			$artikl->cena = $row['cena'];
    	}

    	return $artikl;
	}

	public function findByType($tip)
	{
		$result = $this->connection->query(
			"SELECT * FROM Artikli WHERE tip = $tip");

		return $this->toObjectArray($result);
	}

	public function findByMark($marka)
	{
		$result = $this->connection->query(
			"SELECT * FROM Artikli WHERE marka = $marka");

		return $this->toObjectArray($result);
	}

	public function findByModel($model)
	{
		$result = $this->connection->query(
			"SELECT * FROM Artikli WHERE model LIKE '%$model%'");

		return $this->toObjectArray($result);
	}

	public function find($naziv)
	{
		$result = $this->connection->query(
			"SELECT * FROM Artikli WHERE naziv LIKE '%$naziv%'");

		return $this->toObjectArray($result);
	}

	public function create()
	{
		$result = $this->connection->query("INSERT INTO Artikli (tip, marka, model, naziv, opis, cena, stanje, dodat) 
			VALUES ('$this->tip', '$this->marka', '$this->model', '$this->naziv', '$this->opis', 
				'$this->cena', '$this->stanje', '$this->dodat')");
		
		if ($result > 0) return true; else return false;
	}

	public function update()
	{
		$result = $this->connection->query("UPDATE Artikli SET tip='$this->tip', marka='$this->marka', model='$this->model', 
			naziv='$this->naziv', opis='$this->opis', cena='$this->cena', stanje='$this->stanje', dodat='$this->dodat' 
			WHERE id=$this->id");

		if ($result > 0) return true; else return false;
	}

	public function delete()
	{
		$result = $this->connection->query('DELETE FROM Artikli WHERE id='.$this->id);

		if ($result > 0) return true; else return false;
	}
} ?>