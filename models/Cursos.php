<?php
class Cursos extends Model{

	private $info; 

	public function getCursosDoAluno($id){
		$dados = array(); 

		$sql = $this->db->prepare("SELECT aluno_curso.id_curso, cursos.nome, cursos.imagem, cursos.descricao FROM aluno_curso LEFT JOIN cursos ON aluno_curso.id_curso = cursos.id WHERE id_aluno = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0){
			$dados = $sql->fetchAll();
		}

		return $dados; 
	}

	public function setCurso($id){	
		$sql = $this->db->prepare("SELECT * FROM cursos WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute(); 

		if($sql->rowCount() > 0){
			$this->info = $sql->fetch();
		}		
	}

	public function getNome(){
		return $this->info['nome'];
	}

	public function getImagem(){
		return $this->info['imagem'];
	}

	public function getDescricao(){
		return $this->info['descricao'];
	}
}