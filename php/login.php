<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: php/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Reservas</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    
    <form method="post" action="verificar_login.php">
        <label>Usuário:</label>
        <input type="text" name="usuario" required><br><br>

        <label>Senha:</label>
        <input type="password" name="senha" required><br><br>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>
