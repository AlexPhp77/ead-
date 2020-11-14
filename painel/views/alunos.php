<h1>Alunos</h1>

<a href="<?=BASE;?>alunos/adicionar">
	<button>Adicionar Alunos</button>
</a>

<br/><br/>

<table border="0" width="100%">
	<tr>
		<!--<th>Imagem</th>-->
		<th>Nome</th>
		<th>E-mail</th>
		<th>Qt. de Cursos</th>
		<th>Ações</th>
	</tr>	
	<?php foreach($alunos as $aluno): ?>		
		<tr class="linha" style="text-align: center;">			
			<!--<td><img border="0" height="60px" src="<?=BASE;?>../assets/images/cursos/<?=$aluno['imagem']?>"></td> area para avatar-->
			<td><?=$aluno['nome'];?></td>	
			<td><?=$aluno['email'];?></td>	
			<td><?=$aluno['qtcursos'];?></td>
			<td>
				<a href="<?=BASE;?>alunos/editar/<?=$aluno['id'];?>">
					<button>Editar</button>
				</a>
				<a href="<?=BASE;?>alunos/excluir/<?=$aluno['id'];?>">
					<button>Excluir</button>
				</a>
			</td>			
		</tr>
	<?php endforeach; ?>	
</table>

