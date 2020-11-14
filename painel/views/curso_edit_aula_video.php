<h1>Editar Aula</h1>


<form method="POST">

	Título:<br/>
	<input type="text" value="<?=$aula['nome'];?>" name="nome"><br/><br/>

	Descrição da aula:<br/>
	<textarea name="descricao">
		<?=$aula['descricao'];?>
	</textarea><br/><br/>

	URL do vídeo:<br/>
	<input type="text" value="<?=$aula['url'];?>" name="url"><br/><br/>

	<input type="submit" value="Editar">
	
</form>