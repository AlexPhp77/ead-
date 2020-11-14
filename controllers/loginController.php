<?php
class loginController extends controller {

	public function __construct() {
		parent::__construct();	

		$alunos = new Alunos(); 

		if($alunos->isLogged()){
			header("Location: ".BASE);
		}		
	}
	
	public function index() {
		$dados = array(); 

		if(isset($_POST['email']) && !empty($_POST['email'])){
			$email = addslashes($_POST['email']);
			$senha = md5(addslashes($_POST['senha']));

			$alunos = new Alunos();

			if($alunos->fazerLogin($email, $senha)){
				header("Location: ".BASE);				
			}

		}
	
		$this->loadView('login', $dados);
	}

	public function logout(){
		unset($_SESSION['lgaluno']);
		header("Location: ".BASE."login");
		exit;
	}

}