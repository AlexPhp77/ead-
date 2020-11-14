<?php
class Usuarios extends Model {

	private $info;

	public function isLogged(){
		if(isset($_SESSION['lgadmin']) && !empty($_SESSION['lgadmin'])){
			return true;
		} else{
			return false; 
		}
	}

	public function fazerLogin($email, $senha){
		$sql = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
		$sql->bindValue(':email', $email);
		$sql->bindValue(':senha', $senha);
		$sql->execute(); 

		if($sql->rowCount() > 0){
			$user = $sql->fetch();
			$_SESSION['lgadmin'] = $user['id'];
			return true;
		} else{
			return false; 
		}
	}
}