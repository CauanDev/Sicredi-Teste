<table class="table table-sm table-hover">
  <thead>
    <tr>
      <?php
      foreach ($headers as $header) {
        echo "<th scope='col'>{$header}</th>";
      }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php

    foreach ($body as $row) {
      echo "<tr>";
      foreach ($keys as $key) {
        if ($key == "actions-delete") {
          echo "<td><button class='btn btn-sm btn-primary' data-id='{$row->id}'><i class='bi bi-trash-fill'></i></button></td>";
        } else if ($key == "actions-index") {
          echo "<td>
              <button class='btn btn-sm btn-primary' data-id='{$row->id}' data-target='update'><i class='bi bi-pencil-fill'></i></button>
              <button class='btn btn-sm btn-danger' data-id='{$row->id}' data-target='delete'><i class='bi bi-trash-fill'></i></button>
              </td>";
        } else {
          echo "<td>{$row->$key}</td>";
        }
      }
      echo "</tr>";
    }
    ?>
  </tbody>
</table>