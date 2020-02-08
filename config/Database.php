<?php

	/**
	 *
	 */
	class Database{

		private $hostname = "localhost";

			private $database_name = "tuxshop";

			private $username = "root";

			private $password = "";


		private $pdo;

		function __construct(){
			$this->pdo = null;
		    try {
		      $this->pdo = new PDO("mysql:host=$this->hostname;dbname=$this->database_name;", $this->username, $this->password);
		      $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }catch(PDOException $e) {
		      echo "Error : ". $e->getMessage();
		    }
		}


		public function fetchAll($query) {
			$statement = $this->pdo->prepare($query);
			$statement->execute();
			$rowCount = $statement->rowCount();

			if ($rowCount <= 0) {
				return 0;
			}
			return $statement->fetchAll();
		}

		public function fetchAllByID($query, $id) {
			$statement = $this->pdo->prepare($query);
			$statement->execute(array(':id' => $id));
			$rowCount = $statement->rowCount();

			if ($rowCount <= 0) {
				return 0;
			}
			return $statement->fetchAll();
		}

		public function fetchOne($query, $id) {
			$statement = $this->pdo->prepare($query);
			$statement->execute(array(':id' => $id));

			$rowCount = $statement->rowCount();

			if ($rowCount <= 0) {
				return 0;
			}
			return $statement->fetch();
		}

		public function insert($query, $values) {
		    $statement = $this->pdo->prepare($query);
		    $statement->execute($values);
		}

		public function update($query, $values){
			$statement = $this->pdo->prepare($query);
			$statement->execute($values);
		}

		public function delete($query, $id) {
		    $statement = $this->pdo->prepare($query);
		    $statement->execute(array(':id' => $id ));
  		}
	}

 ?>
