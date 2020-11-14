<?php
class Modulos extends model {

        public function getModulo($id){
                $dados = array();
                $sql = $this->db->prepare("SELECT * FROM modulos WHERE id = :id");
                $sql->bindValue(':id', $id);
                $sql->execute(); 

                if($sql->rowCount() > 0){
                        $dados = $sql->fetch(); 
                }

                return $dados; 
        }

	public function getModulos($id){
		$dados = array();

		$sql = $this->db->prepare("SELECT * FROM modulos WHERE id_curso = :id_curso");
        $sql->bindValue(':id_curso', $id);
        $sql->execute(); 

        if($sql->rowCount() > 0){
        	$dados = $sql->fetchAll(); 

        	$aulas = new Aulas(); 

        	foreach($dados as $mChave => $mitem){

        		$dados[$mChave]['aulas'] = $aulas->getAulasDoModulo($mitem['id']);
        	}
        } 

		return $dados; 
	}

        public function add($modulo, $id_curso){
                
                $sql = $this->db->prepare("INSERT INTO modulos SET nome = :nome, id_curso = :id_curso");
                $sql->bindValue(':nome', $modulo);
                $sql->bindValue(':id_curso', $id_curso);
                $sql->execute(); 

                return true; 
        }

        public function remover($id){
                $sql = $this->db->prepare("DELETE FROM modulos WHERE id = :id");
                $sql->bindValue(':id', $id);
                $sql->execute();                

                return true;
        }

        public function editar($modulo, $id){

                $sql = $this->db->prepare("UPDATE modulos SET nome = :modulo WHERE id = :id");
                $sql->bindValue(':modulo', $modulo);
                $sql->bindValue(':id', $id);
                $sql->execute();

                return true; 
        }
}