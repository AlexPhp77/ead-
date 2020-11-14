<?php
class Cursos extends Model{

	private $info; 

	public function getCursos(){
		$dados = array();

		$sql = $this->db->query("
			SELECT *,
        (select count(*) from aluno_curso where aluno_curso.id_curso = cursos.id) as qtalunos      
		FROM cursos");

		if($sql->rowCount() > 0){
			$dados = $sql->fetchAll();
		}

		return $dados; 
	}

	public function getCurso($id){
		$dados = array();

		$sql = $this->db->prepare("SELECT * FROM cursos WHERE id = :id ");
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0){
			$dados = $sql->fetch(); 
		}

		return $dados;
	}	

	public function update($id){		

		if(isset($_POST['nome']) && !empty($_POST['nome'])){
			
			$nome = addslashes($_POST['nome']);
			$desc = addslashes($_POST['descricao']);
			$img = $_FILES['imagem'];

			$sql = $this->db->prepare("UPDATE cursos SET nome = :nome, descricao = :descricao WHERE id = :id");
					$sql->bindValue(':nome', $nome);
					$sql->bindValue(':descricao', $desc);					
					$sql->bindValue(':id', $id);
					$sql->execute();

			if(!empty($img['tmp_name'])){				

				$imgName = md5(time().rand(0,9999)).'.jpg';
				$types = array('image/jpeg', 'image/jpg', 'image/png');

				if(in_array($img['type'], $types)){
					move_uploaded_file($img['tmp_name'], "../assets/images/cursos/".$imgName);

					$sql = $this->db->prepare("UPDATE cursos SET imagem = :imgName WHERE id = :id");	
					$sql->bindValue(':imgName', $imgName);
					$sql->bindValue(':id', $id);
					$sql->execute();					
				}
			}

			header("Location: ".BASE);
		}

		//
		
	}

	public function getCursosInscritos($id_aluno){
		$dados = array();

		$sql = $this->db->prepare('SELECT id_curso FROM aluno_curso WHERE id_aluno = :id_aluno');
		$sql->bindValue(':id_aluno', $id_aluno);
		$sql->execute();

		if($sql->rowCount() > 0){
			$rows = $sql->fetchAll();

			foreach($rows as $row){
				$dados[] = $row['id_curso'];
			}
		}

		return $dados;
	}
}