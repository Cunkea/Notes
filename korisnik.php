<?php
class korisnik{
	private $id = null;
	private $ime = null;
	private $prezime = null;
	private $password = null;
	private $username = null;
	private $email = null;
	
	function __construct($ime,$prezime,$username,$password,$email,$id){
		$this->ime=$ime;
		$this->prezime=$prezime;
		$this->password=$password;
		$this->username=$username;
		$this->email=$email;
		$this->id=$id;
	}

	public function getId(){
		return $this->id;
	}

	public function getIme(){
		return $this->ime;
	}

	public function getPrezime(){
		return $this->prezime;
	}

	public function getPassword(){
		return $this->password;
	}

	public function getUsername(){
		return $this->username;
	}
	
	public function getEmail(){
		return $this->email;
	}
}