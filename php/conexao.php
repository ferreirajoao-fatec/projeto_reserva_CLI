<?php

//Parametros de conexão
$servidor = "localhost";
$usuario = "root";
$senha = "";
$bd = "agnd_labmovel";

//Conexao com o BD
$conexao = mysqli_connect($servidor, $usuario, $senha, $bd);

if (!$conexao) {
	die("Falha na conexao com o BD. " . mysqli_connect_error($conexao));
}
?>