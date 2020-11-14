<div class="cursoinfo">
	<img src="<?=BASE;?>assets/images/cursos/<?=$curso->getImagem();?>" border="0" height="60">	
	<h3><?=$curso->getNome();?></h3>
	<p>
		<?=$curso->getDescricao();?><br/>
		<?php if($total_aulas >= 1): ?>
		<?php $porc = ($aulas_assistidas / $total_aulas) * 100;  ?>
		<?php echo $aulas_assistidas." / ".$total_aulas." (".ceil($porc)."%) "; ?>
		<?php endif; ?>		
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
	...	
</div>

