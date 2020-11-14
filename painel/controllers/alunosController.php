<?php
class alunosController extends controller {

	public function __construct() {
		parent::__construct();	

		$usuarios = new Usuarios(); 

		if(!$usuarios->isLogged()){
			header("Location: ".BASE."login");
		}
	}

	public function index(){
		$dados = array();

		$alunos = new Alunos();
		$dados['alunos'] = $alunos->getAlunos();

		$this->loadTemplate('alunos', $dados);
	}

	public function excluir($id){
		$aluno = new Alunos();
		$aluno->excluirAluno($id);
	}

	public function adicionar(){	
	    $dados = array(); 	

		if(isset($_POST['nome']) && !empty($_POST['nome'])){
			
			$nome = addslashes($_POST['nome']);
			$email = addslashes($_POST['email']);
			$senha = addslashes($_POST['senha']);
            
            $aluno = new Alunos();
			$aluno->addAluno($nome, $email, $senha); 

			header("Location: ".BASE."alunos");
		}

		$this->loadTemplate("alunos_add", $dados);
	}

	public function editar($id){
	    $dados = array(
	    	'alunos' => array()
	    ); 	

		$alunos = new Alunos();
		$cursos = new Cursos();
		$dados['aluno'] = $alunos->getAluno($id);
		$dados['cursos'] = $cursos->getCursos();
		$dados['inscrito'] = $cursos->getCursosInscritos($id);

		if(isset($_POST['nome']) && !empty($_POST['nome'])){
			$nome = addslashes($_POST['nome']);
			$email = addslashes($_POST['email']);
			$cursos = $_POST['cursos'];			

			$alunos->editarAluno($nome, $email, $cursos, $id);
			header("Location: ".BASE."alunos/editar/".$id);
		}


		if(isset($_POST['senha1']) && !empty($_POST['senha1'])){
			$senha1 = addslashes($_POST['senha1']);
			$senha2 = addslashes($_POST['senha2']);
			
			if($senha1 == $senha2){
				$alunos->editarSenhaAluno($id, $senha1);
				$dados['flash'] = "Senha Editada com Sucesso!<br/><br/>";
			    //header("Location: ".BASE."alunos/editar/".$id);
			} else {
				$dados['flash'] = "Senhas não conferem!<br/><br/>";
			}
		}

		$this->loadTemplate('editar_aluno', $dados);
	}
}