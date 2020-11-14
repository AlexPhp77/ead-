<h2 style="margin-left: 10px; color: #333">Meus Cursos</h2>

<?php foreach($cursos as $curso): ?>

<div class="box">
	<a href="<?=BASE;?>cursos/entrar/<?=$curso['id_curso'];?>">
		<div class="cursoitem">
			<img width="100%" border="0px" src="<?=BASE;?>assets/images/cursos/<?=$curso['imagem'];?>">
			<h4><?php echo $curso['nome']; ?></h4>
			<p>
				<?php echo $curso['descricao']; ?>
			</p>
	    </div>
   </a>	
</div>

<?php endforeach; ?>