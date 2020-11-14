<?php
class Aulas extends model{

	public function marcarAssistido($id){
		$sql = $this->db->prepare("INSERT INTO historico SET data_viewed = NOW(), id_aluno = :id_aluno, id_aula = :id_aula");
		$sql->bindValue(':id_aluno', $_SESSION['lgaluno']);
		$sql->bindValue(':id_aula', $id);
		$sql->execute(); 
	}

	public function getAulasDoModulo($id){
		$dados = array();
		$aluno = $_SESSION['lgaluno'];

		$sql = $this->db->prepare("SELECT * FROM aulas WHERE id_modulo = :id ORDER BY ordem");
		$sql->bindValue(':id', $id);
		$sql->execute(); 

		if($sql->rowCount() > 0){
			$dados = $sql->fetchAll(); 

			foreach($dados as $chave => $aula){
				$dados[$chave]['assistido'] = $this->isAssistido($aula['id'], $aluno); 
				if($aula['tipo'] == 'video'){
					$sql = $this->db->query("SELECT nome FROM videos WHERE id_aula = '".($aula['id'])."'");
					$sql = $sql->fetch(); 

					$dados[$chave]['nome'] = $sql['nome'];
				} elseif($aula['tipo'] == 'poll'){	
					$dados[$chave]['nome'] = "Questionário";
				}
			}
		}

		return $dados; 
	}

	private function isAssistido($id_aula, $id_aluno){
		$sql = $this->db->prepare("SELECT id FROM historico WHERE id_aula = :id_aula AND id_aluno = :id_aluno");
		$sql->bindValue(':id_aula', $id_aula);
		$sql->bindValue(':id_aluno', $id_aluno);		
		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		} else{
			return false;
		}
	}

	public function getCursoDeaula($id_aula){
		$sql = $this->db->prepare("SELECT * FROM aulas WHERE id = :id_aula");
		$sql->bindValue(':id_aula', $id_aula);
		$sql->execute(); 

		if($sql->rowCount() > 0){
			$dado = $sql->fetch();
			return $dado['id_curso'];

		} else{
			return 0;
		}
	}

	public function getAula($id_aula){
		$dados = array();		

		$sql = $this->db->prepare("SELECT tipo, (select count(*) from historico where historico.id_aula = aulas.id and historico.id_aluno = :id_aluno) as assistido FROM aulas WHERE id = :id_aula");
		$sql->bindValue(':id_aula', $id_aula);
		$sql->bindValue(':id_aluno', $_SESSION['lgaluno']);
		$sql->execute(); 

		if($sql->rowCount() > 0){
			$dado = $sql->fetch();			

			if($dado['tipo'] == 'video'){
				$sql = $this->db->query("SELECT * FROM videos WHERE  id_aula = '$id_aula'");
				$dados = $sql->fetch();
				$dados['tipo'] = 'video';

			} elseif($dado['tipo'] == 'poll'){
				$sql = $this->db->query("SELECT * FROM questionarios WHERE  id_aula = '$id_aula'");
				$dados = $sql->fetch();
				$dados['tipo'] = 'poll';

			}

			$dados['assistido'] = $dado['assistido'];

		}

		return $dados; 
	}

	public function setDuvida($duvida, $aluno){
		$sql = $this->db->prepare("INSERT INTO duvidas SET data_duvida = NOW(), duvida = :duvida, id_aluno = :id_aluno");
		$sql->bindValue(':duvida', $duvida);
		$sql->bindValue(':id_aluno', $aluno);
		$sql->execute(); 

		return true; 
	}
	
}