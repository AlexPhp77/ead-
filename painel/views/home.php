<h1>Cursos</h1>

<a href="<?=BASE;?>home/adicionar">
	<button>Adicionar Curso</button>
</a>

<br/><br/>

<table border="0" width="100%">
	<tr>
		<th>Imagem</th>
		<th>Nome</th>
		<th>Qt. de Alunos</th>
		<th>Ações</th>
	</tr>	
	<?php foreach($cursos as $curso): ?>		
		<tr class="linha" style="text-align: center;">			
			<td><img border="0" height="60px" src="<?=BASE;?>../assets/images/cursos/<?=$curso['imagem']?>"></td>
			<td><?=$curso['nome'];?></td>	
			<td><?=$curso['qtalunos'];?></td>
			<td>
				<a href="<?=BASE;?>home/editar/<?=$curso['id'];?>">
					<button>Editar</button>
				</a>
				<a href="<?=BASE;?>home/excluir/<?=$curso['id'];?>">
					<button>Excluir</button>
				</a>
			</td>			
		</tr>
	<?php endforeach; ?>	
</table>

