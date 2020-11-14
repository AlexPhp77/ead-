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
	<h3>Questionário</h3>

	

	<?php if($_SESSION['poll'.$aula_info['id_aula']] > 1): ?>		
        <?php echo "Você só pode enviar uma única vez!" ?>
	<?php else: ?>
	  	
	<h3><?= $aula_info['pergunta']; ?></h3><br/>
	<form method="POST">
		<label>
        <input type="radio" name="opcao" value="1">
		<?=$aula_info['opcao1'];?>		
		</label><br/><br/>
		<label>
	        <input type="radio" name="opcao" value="2">
			<?=$aula_info['opcao2'];?>		
		</label><br/><br/>
		<label>
	        <input type="radio" name="opcao" value="3">
			<?=$aula_info['opcao3'];?>		
		</label><br/><br/>
		<label>
	        <input type="radio" name="opcao" value="4">
			<?=$aula_info['opcao4'];?>		
		</label><br/><br/>
		<input type="submit" value="Enviar Resposta">		
	</form>	
    
    <?php endif; ?>

	<?php 
	if(isset($resposta)){
		if($resposta === true){
			echo "<span style='color: green'>Resposta CORRETA!</span>";
		} else{
			echo "<span style='color: red'>Resposta INCORRETA!</span>";
		}
	}
	?>	
</div>
