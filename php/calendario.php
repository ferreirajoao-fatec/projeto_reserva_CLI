<?php
require_once("conexao.php");

$mes = isset($_GET['mes']) ? (int)$_GET['mes'] : date('m');
$ano = isset($_GET['ano']) ? (int)$_GET['ano'] : date('Y');

$mes_anterior = $mes - 1;
$ano_anterior = $ano;
if ($mes_anterior < 1) { $mes_anterior = 12; $ano_anterior--; }

$mes_proximo = $mes + 1;
$ano_proximo = $ano;
if ($mes_proximo > 12) { $mes_proximo = 1; $ano_proximo++; }

$primeiro_dia = mktime(0, 0, 0, $mes, 1, $ano);
$dia_semana_inicio = date('w', $primeiro_dia);
$dias_no_mes = date('t', $primeiro_dia);

$reservas_turnos = [];
$query = mysqli_query($conexao, "SELECT data_reserva, turno FROM reserva WHERE MONTH(data_reserva) = $mes AND YEAR(data_reserva) = $ano");
while ($r = mysqli_fetch_assoc($query)) {
    $dia = (int)date('j', strtotime($r['data_reserva']));
    $reservas_turnos[$dia][] = $r['turno'];
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Calendário</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="navbar">
  <div class="menu">
    <a href="index.php">Reservar</a>
    <a href="calendario.php">Calendário</a>
  </div>
 <img src="../img/Fatec Matão Luiz Marchesan (branco).png" alt="Logo">
</div>


  <h1>Calendário de Reservas</h1>
  <div class="navegacao">
    <a href="?mes=<?= $mes_anterior ?>&ano=<?= $ano_anterior ?>">&laquo; Mês Anterior</a> |
    <strong><?= strftime('%B de %Y', $primeiro_dia) ?></strong> 
    <a href="?mes=<?= $mes_proximo ?>&ano=<?= $ano_proximo ?>">Próximo Mês &raquo;</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>Dom</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sáb</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php
        $dia = 1;
        for ($i = 0; $i < $dia_semana_inicio; $i++) echo "<td></td>";
        while ($dia <= $dias_no_mes) {
            $classe = "";
            if (isset($reservas_turnos[$dia])) {
                $turnos = $reservas_turnos[$dia];
                $classe = in_array('manha', $turnos) && in_array('noite', $turnos) ? "ambos"
                        : (in_array('manha', $turnos) ? "manha" : "noite");
            }
            echo "<td class='$classe'>$dia</td>";
            if (($dia + $dia_semana_inicio) % 7 == 0) echo "</tr><tr>";
            $dia++;
        }
        while (($dia + $dia_semana_inicio - 1) % 7 != 0) {
            echo "<td></td>";
            $dia++;
        }
        ?>
      </tr>
    </tbody>
  </table>
</body>
</html>
