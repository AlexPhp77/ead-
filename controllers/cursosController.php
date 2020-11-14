<?php
class cursosController extends controller {

	public function __construct() {
		parent::__construct();	

		$alunos = new Alunos(); 

		if(!$alunos->isLogged()){
			header("Location: ".BASE."login");
		}
	}
	
	public function index() {
		header("Location: ".BASE);
	}

	public function entrar($id){
		$dados = array(
			'info' => array(),
			'curso' => array(),
			'modulos' => array()
		);

		$alunos = new Alunos();
		$alunos->setAluno($_SESSION['lgaluno']);
		$dados['info'] = $alunos; 
		$dados['aulas_assistidas'] = $alunos->getQtAulasVistas($id); 
		$dados['total_aulas'] = $alunos->getTotalAulas($id);

		if($alunos->isInscrito($id)){
			$curso = new Cursos();
			$curso->setCurso($id);
			$dados['curso'] = $curso;

			$modulos = new Modulos(); 
			$dados['modulos'] = $modulos->getModulos($id);

			$this->loadTemplate('cursos_entrar', $dados);
		} else{
			header("Location: ".BASE);
		}
	}

	public function aula($id_aula){
		$dados = array(
			'info' => array(),
			'curso' => array(),
			'modulos' => array(),
			'aula' => array()
		);

		$alunos = new Alunos();
		$alunos->setAluno($_SESSION['lgaluno']);
		$dados['info'] = $alunos; 

		$aula = new Aulas();
		$id = $aula->getCursoDeaula($id_aula);

		if($alunos->isInscrito($id)){
			$curso = new Cursos();
			$curso->setCurso($id);
			$dados['curso'] = $curso; 

			$modulos = new Modulos(); 
			$dados['modulos'] = $modulos->getModulos($id);

			$dados['aula_info'] = $aula->getAula($id_aula);

			if($dados['aula_info']['tipo'] == 'video'){
				$view = 'curso_aula_video';
			} else{
				$view = 'curso_aula_poll';
				if(!isset($_SESSION['poll'.$id_aula])){
				    $_SESSION['poll'.$id_aula] = 1;
				} 
			}

			$dados['aulas_assistidas'] = $alunos->getQtAulasVistas($id); 
			$dados['total_aulas'] = $alunos->getTotalAulas($id);

			if(isset($_POST['duvida']) && !empty($_POST['duvida'])){
				$duvida = addslashes($_POST['duvida']);
				$aula->setDuvida($duvida, $alunos->getId()); 
			}

			if(isset($_POST['opcao']) && !empty($_POST['opcao'])){
				$resposta = addslashes($_POST['opcao']);

				if($resposta === $dados['aula_info']['resposta']){
					$dados['resposta'] = true;

				} else{
					$dados['resposta'] = false; 
				}

				$aula->marcarAssistido($id_aula);

				$_SESSION['poll'.$id_aula]++; 
			} 

			$this->loadTemplate($view, $dados);
		} else{
			header("Location: ".BASE);
		}
	}

}