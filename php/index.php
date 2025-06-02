<?php require_once("conexao.php"); ?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Reservas</title>
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


  <h1>Agenda de Reservas</h1>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nome = $_POST['nome'];
      $data = $_POST['data_reserva'];
      $turno = $_POST['turno'];

      $confere = mysqli_query($conexao, "SELECT * FROM reserva WHERE data_reserva = '$data' AND turno = '$turno'");
      if (mysqli_num_rows($confere)) {
          echo "<div class='mensagem alerta'>⚠ Já há reserva para essa data/turno.</div>";
      } else {
          $insere = mysqli_query($conexao, "INSERT INTO reserva VALUES (NULL, '$nome', '$data', '$turno')");
          if ($insere) {
              header("Location: index.php");
              exit;
          } else {
              echo "<div class='mensagem erro'>Erro ao reservar.</div>";
          }
      }
  }
  ?>

  <form method="POST">
    <input type="text" name="nome" placeholder="Seu nome" required><br>
    <input type="date" name="data_reserva" required><br>
    <label><input type="radio" name="turno" value="manha" required> Desenvolvimento de Software Multiplataforma</label>
    <label><input type="radio" name="turno" value="noite"> Análise e processos Agroindustriais</label><br>
    <button type="submit">Reservar</button>
  </form>

  <h2>Reservas Realizadas</h2>
  <table>
    <thead>
      <tr>
        <th>Nome</th>
        <th>Data</th>
        <th>Período</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $res = mysqli_query($conexao, "SELECT nome, data_reserva, turno FROM reserva ORDER BY data_reserva ASC, turno ASC");
      while ($row = mysqli_fetch_assoc($res)) {
          echo "<tr><td>" . htmlspecialchars($row['nome']) . "</td><td>" . date('d/m/Y', strtotime($row['data_reserva'])) . "</td><td>" . ucfirst($row['turno']) . "</td></tr>";
      }
      ?>
    </tbody>
  </table>
</body>
</html>
