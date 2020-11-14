<!DOCTYPE html>
<html>
<head>
	<title>Login - EAD</title>
	<style type="text/css">	

	.formulario {
		margin-top: 50px;
		display: flex;
		justify-content: center;
		color: #fff;
		font-size: 20px;
		font-family: arial;
	}
	.formulario form{		
		background-color:#2c82c9;
		padding: 20px;
		border-radius: 6px;
		width: 300px;
	}
	.formulario input{
		border: 0px;
		border-radius: 2px;
		width: 100%;
		height: 30px;
		line-height: 30px;
	}	
	.formulario input[type="submit"]{
		color:#fff;
		background-color: #ed4a4a;
		display: inline-block;
		width: 100px;
		font-size: 16px;
	}
	.formulario input[type="submit"]:hover{		
		background-color: #ea6262;	
		cursor: pointer;	
	}

	</style>
</head>
<body>

	<h3>Área administrativa</h3>

	<div class="formulario">
		<form method="POST">
			E-mail:<br/>
			<input type="text" name="email" placeholder="E-mail"><br/><br/>
			Senha:<br/>
			<input type="password" name="senha" placeholder="Senha"><br/><br/>
			<input type="submit" value="Entrar">	
        </form>		
	</div>

</body>
</html>