<?php
class homeController extends controller {

	public function __construct() {
		parent::__construct();	

		$usuarios = new Usuarios(); 

		if(!$usuarios->isLogged()){
			header("Location: ".BASE."login");
		}
	}
	
	public function index() {
		$dados = array(
			'cursos' => array()
		); 	

		$cursos = new Cursos();
		$dados['cursos'] = $cursos->getCursos();
	
		$this->loadTemplate('home', $dados);
	}

	public function excluir($id){

		$sql = $this->db->prepare("SELECT id FROM aulas WHERE id_curso = :id");
		$sql->bindValue(':id', $id);
		$sql->execute(); 

		if($sql->rowCount() > 0){
			$aulas = $sql->fetchAll();

			foreach($aulas as $aula){
				$sqlaula = "DELETE FROM historico WHERE id_aula = '".($aula['id_aula'])."'";
				$this->db->query($sqlaula);

				$sqlaula = "DELETE FROM questionarios WHERE id_aula = '".($aula['id_aula'])."'";
				$this->db->query($sqlaula);

				$sqlaula = "DELETE FROM videos WHERE id_aula = '".($aula['id_aula'])."'";
				$this->db->query($sqlaula);
			}
		}

		$sql = $this->db->prepare("DELETE FROM aluno_curso WHERE id_curso = :id");
		$sql->bindValue(':id', $id);
		$sql->execute(); 

		$sql = $this->db->prepare("DELETE FROM aulas WHERE id_curso = :id");
		$sql->bindValue(':id', $id);
		$sql->execute(); 

		$sql = $this->db->prepare("DELETE FROM modulos WHERE id_curso = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		//OBS: preciso deletar a imagem do curso com unlink

		$sql = $this->db->prepare("DELETE FROM cursos WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();		 

		header("Location: ".BASE);
	}

	public function adicionar(){	
	    $dados = array(); 	

		if(isset($_POST['nome']) && !empty($_POST['nome'])){
			
			$nome = addslashes($_POST['nome']);
			$desc = addslashes($_POST['descricao']);
			$img = $_FILES['imagem'];

			if(!empty($img['tmp_name'])){				

				$imgName = md5(time().rand(0,9999)).'.jpg';
				$types = array('image/jpeg', 'image/jpg', 'image/png');

				if(in_array($img['type'], $types)){
					move_uploaded_file($img['tmp_name'], "../assets/images/cursos/".$imgName);

					$sql = $this->db->prepare("INSERT INTO cursos SET nome = :nome, descricao = :descricao, imagem = :imgName");
					$sql->bindValue(':nome', $nome);
					$sql->bindValue(':descricao', $desc);
					$sql->bindValue(':imgName', $imgName);
					$sql->execute(); 

					header("Location: ".BASE);

				}

			}
		}

		$this->loadTemplate("curso_add", $dados);
	}

	public function editar($id){
	    $dados = array(); 	

		$cursos = new Cursos();
		$dados['curso'] = $cursos->getCurso($id);

		$modulos = new Modulos();
		$dados['modulos'] = $modulos->getModulos($id);

		// add modulo
		if(isset($_POST['modulo']) && !empty($_POST['modulo'])){

			$modulo = addslashes($_POST['modulo']);
           
			$modulos->add($modulo, $id); 

			header('Location: '.BASE.'home/editar/'.$id);
		}

		// add aula
		if(isset($_POST['aula']) && !empty($_POST['aula'])){
			
			$titulo = addslashes($_POST['aula']);
			$modulo = addslashes($_POST['moduloaula']);
			$tipoaula = addslashes($_POST['tipoaula']);	
			
			$aulas = new Aulas();
			$aulas->addAula($titulo, $modulo, $tipoaula, $id);

			//header('Location: '.BASE.'home/editar/'.$id);
		}

		$cursos->update($id);		

		$this->loadTemplate('curso_edit', $dados);
	}

	public function remover($id){
		$modulos = new Modulos();

		$sql = $this->db->query("SELECT id_curso FROM aulas WHERE id = $id");
		$id_curso = $sql->fetch();

		if(intval($id)){
			$id_curso = $modulos->remover($id);
			header('Location: '.BASE.'home/editar/'.$id_curso);
		} else{
			header('Location: '.BASE);
		}		
	}

	public function editar_modulo($id){
		$dados = array();
		$modulos = new Modulos();	
       
		if(isset($_POST['modulo']) && !empty($_POST['modulo'])){
			$modulo = addslashes($_POST['modulo']);			 
			
			$modulos->editar($modulo, $id);

			header('Location: '.BASE.'home/editar/'.$id);
		}		
		
		$dados['modulo'] = $modulos->getModulo($id);		

		$this->loadTemplate('curso_editar_modulo', $dados);
	}

	public function remover_aula($id){
		$id = addslashes($id);		
		
		$aulas = new Aulas();
		$id_curso = $aulas->remover($id);		
        
        if($id_curso){
        	header('Location: '.BASE.'home/editar/'.$id_curso['id_curso']);
        }
		
	}

	public function editar_aula($id){
		$dados = array();
		$view = 'curso_edit_aula_video';

		$aulas = new Aulas();

		if(isset($_POST['nome']) && !empty($_POST['nome'])){
			$nome = addslashes($_POST['nome']);
			$desc = addslashes($_POST['descricao']);
			$url = addslashes($_POST['url']);

			$id_curso = $aulas->updateAula($id, $nome, $desc, $url);

			header("Location: ".BASE."home/editar/".$id_curso);
		}

		if(isset($_POST['pergunta']) && !empty($_POST['pergunta'])){

			$pergunta = addslashes($_POST['pergunta']);
			$opcao1 = addslashes($_POST['opcao1']);
			$opcao2 = addslashes($_POST['opcao2']);
			$opcao3 = addslashes($_POST['opcao3']);
			$opcao4 = addslashes($_POST['opcao4']);
			$resposta = addslashes($_POST['resposta']);

	        $id_curso = $aulas->updateQuestaoAula($id, $pergunta, $opcao1, $opcao2, $opcao3, $opcao4, $resposta);
             
			header("Location: ".BASE."home/editar/".$id_curso);
		}
	    
	    $dados['aula'] = array();
		$dados['aula'] = $aulas->getAula($id);

		if($dados['aula']['tipo'] == 'video'){
			$view = 'curso_edit_aula_video';
        } else{
        	$view = 'curso_edit_aula_poll';
        }

		$this->loadTemplate($view, $dados);
	}
}