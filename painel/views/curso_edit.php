<h1>Editar Curso</h1>

<form method="POST" enctype="multipart/form-data">

	Nome do curso:<br/>
	<input type="text" value="<?=$curso['nome'];?>" name="nome"><br/><br/>

	Descrição:<br/>
	<input type="descricao" value="<?=$curso['descricao'];?>" name="descricao"><br/><br/>
  
	Alterar Imagem:<br/>
	<img width="100px" src="<?=BASE;?>../assets/images/cursos/<?=$curso['imagem']?>">
	<br/><br/>
	<input type="file" name="imagem"><br/><br/>	

	<input type="submit" value="Salvar">
	
</form>

<hr/>
<h2>Aulas</h2>

<fieldset>
	<legend>Adicionar novo módulo</legend><br/>
	<form method="POST">
		Nome do módulo:
		<input type="text" name="modulo">
		<input type="submit" value="Adicionar">		
	</form>
</fieldset><br/>

<fieldset>
	<legend>Adicionar nova aula</legend><br/>
	<form method="POST">
		Título da aula:<br/>
		<input type="text" name="aula"><br/><br/>
		
		Módulo:<br/>
		<select name="moduloaula">
			<?php foreach($modulos as $modulo): ?>
				<option value="<?=$modulo['id'];?>"><?php echo $modulo['nome'];?></option>
			<?php endforeach; ?>
		</select><br/><br/>
        
        Tipo da aula:<br/>
        <select name="tipoaula">
        	<option value="video">Vídeo</option>       
        	<option value="poll">Questionário</option>        	
        </select><br/><br/>

		<input type="submit" value="Adicionar">		
	</form>
</fieldset><br/>

<?php foreach($modulos as $modulo): ?>

	<h4><?=$modulo['nome'];?>
	    <a href="<?=BASE;?>home/editar_modulo/<?=$modulo['id'];?>">- editar</a>
		<a style="color: #e20000" href="<?=BASE;?>home/remover/<?=$modulo['id'];?>">- remover</a>
	</h4>
	<?php foreach($modulo['aulas'] as $aula): ?>
		<h5>
			<?php echo $aula['nome']; ?>
			<a href="<?=BASE;?>home/editar_aula/<?=$aula['id'];?>">- editar</a>
		    <a style="color: #e20000" href="<?=BASE;?>home/remover_aula/<?=$aula['id'];?>">- remover</a>
		</h5>
    <?php endforeach; ?>
<?php endforeach; ?>
