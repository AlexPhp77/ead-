<?php
class Modulos extends model {

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
}