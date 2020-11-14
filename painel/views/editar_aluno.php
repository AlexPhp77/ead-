<h1>Editar informações aluno</h1>

<form method="POST">
	Nome:<br/>
	<input type="text" value="<?=$aluno['nome'];?>" name="nome"><br/><br/>
	E-mail<br/>	
	<input type="text" value="<?=$aluno['email'];?>" name="email"><br/><br/>	
	
	Cursos inscritos:<br/> <span style="font-size: 11px">(Segure CTRL para selecionar vários cursos ao mesmo tempo)</span><br/><br/>
	<select name="cursos[]" multiple>		
		<?php foreach($cursos as $curso): ?>
            <option value="<?=$curso['id'];?>" <?=(in_array($curso['id'], $inscrito))?'selected="selected"':''?>> 
        		<?=$curso['nome'];?>
        	</option>
		<?php endforeach; ?> 	
	</select><br/><br/>

	<input type="submit" value="Editar">
	
</form>

<form method="POST">
	<?=(!empty($flash))?$flash:'';?>
	Nova Senha:<br/>
	<input type="password" placeholder="Nova senha" name="senha1"><br/><br/>
	<input type="password" placeholder="Confirme sua senha" name="senha2"><br/><br/>
	<input type="submit" value="Alterar Senha">
</form>