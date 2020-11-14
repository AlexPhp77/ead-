<?php
class Alunos extends Model {

	public function getAlunos(){
		$dados = array();

		$sql = $this->db->query("SELECT *, 
			(select count(*) from aluno_curso where aluno_curso.id_aluno = alunos.id) as qtcursos FROM alunos");

		if($sql->rowCount() > 0){
			$dados = $sql->fetchAll();
		}

		return $dados;
	}

	public function getAluno($id){
		$dados = array();

		$sql = $this->db->prepare("SELECT id, nome, email FROM alunos WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0){
			$dados = $sql->fetch();
		}

		return $dados;
	}

	public function editarAluno($nome, $email, $cursos, $id){

		if(intval($id)){
			$this->db->query("DELETE FROM aluno_curso WHERE id_aluno = '$id'");
		}

		foreach($cursos as $curso){
			filter_var($curso);
			$this->db->query("INSERT INTO aluno_curso SET id_aluno = '$id', id_curso = '$curso'");
		}

		$sql = $this->db->prepare("UPDATE alunos SET nome = :nome, email = :email WHERE id = :id");
		$sql->bindValue(':nome', $nome);
		$sql->bindValue(':email', $email);
		$sql->bindValue(':id', $id);
		$sql->execute();

		return true; 
	}

	public function editarSenhaAluno($id, $senha){
		$sql = $this->db->prepare("UPDATE alunos SET senha = md5(:senha) WHERE id = :id");
		$sql->bindValue(':senha', $senha);		
		$sql->bindValue(':id', $id);
		$sql->execute();

		return true; 
	}

	public function excluirAluno($id){
		$sql = $this->db->prepare("DELETE FROM aluno_curso WHERE id_aluno = :id");
		$sql->bindValue(':id', $id);
		$sql->execute(); 

		$sql = $this->db->prepare("DELETE FROM alunos WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();		 

		header("Location: ".BASE."alunos");
	}

	public function addAluno($nome, $email, $senha){
	    $sql = $this->db->prepare("INSERT INTO alunos SET nome = :nome, email = :email, senha = md5(:senha)");
		$sql->bindValue(':nome', $nome);
		$sql->bindValue(':email', $email);
		$sql->bindValue(':senha', $senha);
		$sql->execute();

		return true; 
	}
}