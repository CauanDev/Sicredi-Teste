<table class="table table-hover">
  <thead>
    <tr>
      <?php
      // Loop para gerar os cabeçalhos
      foreach ($headers as $header) {
          echo "<th scope='col'>{$header}</th>";
      }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php
    // Loop para gerar as linhas do corpo da tabela
    foreach ($body as $row) {
        echo "<tr>";
        
        // Loop para gerar as células da linha
        foreach ($row as $index => $cell) {
            if ($headers[$index] == "Actions") {
                echo "<td><button class='btn btn-primary' data-id='{$cell}'>Ação {$cell}</button></td>";
            } else {
                // Outras colunas
                echo "<td>{$cell}</td>";
            }
        }
        
        echo "</tr>";
    }
    ?>
  </tbody>
</table>
