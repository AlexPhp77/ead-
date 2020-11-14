<h1>Editar Aula</h1>


<form method="POST">

	Questão:<br/>
	<input type="text" value="<?=(!empty($aula['pergunta']))?$aula['pergunta']:'';?>" name="pergunta"><br/><br/>

	Opção 1:<br/>
	<input type="text" value="<?=(!empty($aula['opcao1']))?$aula['opcao1']:'';?>" name="opcao1"><br/><br/>
	Opção 2:<br/>
	<input type="text" value="<?=(!empty($aula['opcao2']))?$aula['opcao2']:'';?>" name="opcao2"><br/><br/>
	Opção 3:<br/>
	<input type="text" value="<?=(!empty($aula['opcao3']))?$aula['opcao3']:'';?>" name="opcao3"><br/><br/>
	Opção 4:<br/>
	<input type="text" value="<?=(!empty($aula['opcao4']))?$aula['opcao4']:'';?>" name="opcao4"><br/><br/>

	Resposta:<br/>
	<select name="resposta">
		<option value="1" <?=(!empty($aula['resposta'])=='1')?'selected="selected"':'';?>>Opção 1</option>
		<option value="2" <?=(!empty($aula['resposta'])=='2')?'selected="selected"':'';?>>Opção 2</option>
		<option value="3" <?=(!empty($aula['resposta'])=='3')?'selected="selected"':'';?>>Opção 3</option>
		<option value="4" <?=(!empty($aula['resposta'])=='4')?'selected="selected"':'';?>>Opção 4</option>
	</select><br/><br/>

	<input type="submit" value="Editar">
	
</form>