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

		$sql = $this->db->prepare("SELECT * FROM aulas WHERE id_modulo = :id ORDER BY ordem");
		$sql->bindValue(':id', $id);
		$sql->execute(); 

		if($sql->rowCount() > 0){
			$dados = $sql->fetchAll(); 

			foreach($dados as $chave => $aula){
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

		$sql = $this->db->prepare("SELECT tipo FROM aulas WHERE id = :id_aula");
		$sql->bindValue(':id_aula', $id_aula);		
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

	public function remover($id){
		$sql = $this->db->query("SELECT id_curso FROM aulas WHERE id = $id");	

		if($sql->rowCount() > 0){	
			$dados = $sql->fetch();		

			$sql = $this->db->prepare("DELETE FROM aulas WHERE id = :id");
			$sql->bindValue(':id', $id);
			$sql->execute(); 

			$sql = $this->db->prepare("DELETE FROM questionarios WHERE id_aula = :id");
			$sql->bindValue(':id', $id);
			$sql->execute();

			$sql = $this->db->prepare("DELETE FROM videos WHERE id_aula = :id");
			$sql->bindValue(':id', $id);
			$sql->execute(); 	

			return $dados['id_curso'];	
		}	
	}

	public function addAula($titulo, $modulo, $tipoaula, $id_aula){
		$sql = $this->db->query("SELECT ordem FROM aulas WHERE id_modulo = '$modulo' ORDER BY ordem DESC LIMIT 1");
		$ordem = 1;

		if($sql->rowCount() > 0){
			$sql = $sql->fetch();
			$ordem = intval($sql['ordem']);
			$ordem++;			
		}

		$sql = $this->db->prepare("INSERT INTO aulas SET id_modulo = :id_modulo, id_curso = :id_curso, ordem = :ordem, tipo = :tipo");
			$sql->bindValue(':id_modulo', $modulo);
			$sql->bindValue(':id_curso', $id_aula);
			$sql->bindValue(':ordem', $ordem);
			$sql->bindValue(':tipo', $tipoaula);
			$sql->execute();

			$id_aula = $this->db->lastInsertId();

			if($tipoaula == 'video'){
				$this->db->query("INSERT INTO videos SET id_aula = '$id_aula', nome = '$titulo'");
			} else{				
				$this->db->query("INSERT INTO questionarios SET id_aula = '$id_aula'");
			}

			return true; 

	}

	public function updateAula($id, $nome, $desc, $url){
		$sql = $this->db->prepare("SELECT id_curso FROM aulas WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0){
			$dado = $sql->fetch();				
		}		

		$sql = $this->db->prepare("UPDATE videos SET nome = :nome, descricao = :descricao, url = :url WHERE id_aula = :id");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':nome', $nome);
		$sql->bindValue(':descricao', $desc);
		$sql->bindValue(':url', $url);
		$sql->execute();

		return $dado['id_curso'];
	}

	public function updateQuestaoAula($id, $pergunta, $opcao1, $opcao2, $opcao3, $opcao4, $resposta){
		
		$sql = $this->db->prepare("SELECT id_curso FROM aulas WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0){
			$dado = $sql->fetch();				
		}		

		$sql = $this->db->prepare("UPDATE questionarios SET pergunta = :pergunta, opcao1 = :opcao1, opcao2  = :opcao2, opcao3  = :opcao3, opcao4  = :opcao4, resposta = :resposta WHERE id_aula = :id");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':pergunta', $pergunta);
		$sql->bindValue(':opcao1', $opcao1);
		$sql->bindValue(':opcao2', $opcao2);
		$sql->bindValue(':opcao3', $opcao3);
		$sql->bindValue(':opcao4', $opcao4);
		$sql->bindValue(':resposta', $resposta);
		$sql->execute();
         
		return $dado['id_curso'];
	}
}