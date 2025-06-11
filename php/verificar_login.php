<?php
session_start();

$usuario = $_POST['usuario'] ?? '';
$senha   = $_POST['senha'] ?? '';

// Configurações do servidor LDAP
$ldap_host = "ldap://SEU_SERVIDOR"; // Ex: ldap://192.168.0.1
$dominio   = "SEU_DOMINIO";         // Ex: FATEC
    
$ldapconn = ldap_connect($ldap_host);

if (!$ldapconn) {
    die("Erro ao conectar no servidor LDAP.");
}

ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

$bind = @ldap_bind($ldapconn, "$dominio\\$usuario", $senha);

if ($bind) {
    $_SESSION['usuario'] = $usuario;
    header("Location: php/index.php");
    exit;
} else {
    echo "Login inválido. <a href='login.php'>Tentar novamente</a>";
}
?>
