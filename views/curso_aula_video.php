<div class="cursoinfo">
	<img src="<?=BASE;?>assets/images/cursos/<?=$curso->getImagem();?>" border="0" height="60">	
	<h3><?=$curso->getNome();?></h3>
	<p>
		<?=$curso->getDescricao();?><br/>
		<?php $porc = ($aulas_assistidas / $total_aulas) * 100;  ?>
		<?php echo $aulas_assistidas." / ".$total_aulas." (".ceil($porc)."%) "; ?>		
	</p>
</div>
<div class="curso_left">
	<?php foreach($modulos as $modulo): ?>
		<div class="modulo"><?=$modulo['nome'];?></div>
		<?php foreach($modulo['aulas'] as $aula): ?>
            <a href="<?=BASE;?>cursos/aula/<?=$aula['id'];?>">
           	    <div class="aula"><?=$aula['nome'];?>
           	    	<span style="float: right; padding: 5px;">
           	    		<?php if($aula['assistido'] === true): ?>
           	    			<img border="0" width="22px" src="<?=BASE;?>assets/images/v.png">
           	    		<?php endif; ?>	
           	    	</span>
           	    </div>
            </a>
	    <?php endforeach; ?>
	<?php endforeach; ?>		
</div>
<div class="curso_right">
	<h3>Vídeo - <?php echo $aula_info['nome']; ?></h3>

	<iframe id="video" frameborder="0" src="//player.vimeo.com/video/<?=$aula_info['url'];?>"></iframe>

	<p>
		<?=$aula_info['descricao'];?>	

		<?php if($aula_info['assistido'] >= '1'): ?>
			<?php echo "Essa aula já foi assistida!" ?>
		<?php else: ?>
			<button onclick="marcarAssistido(this)" data-id="<?=$aula_info['id'];?>" >
			Marcar como assistido
		    </button>
	    <?php endif; ?>
	</p>

	<hr/>
	<h3>Dúvidas? Envie sua pergunta!</h3>
	<form method="POST" class="form_duvida">
		<textarea name="duvida"></textarea>
		<br/><br/>
		<input type="submit" value="Enviar">		
	</form>
</div>
