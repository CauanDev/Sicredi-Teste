<table class="table table-hover">
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
        if ($key == "actions-documentos") {
          echo "
          <td>
              <button class='btn btn-sm btn-danger' data-id='{$row->id}' data-target='delete'><i class='bi bi-trash-fill'></i></button>
              <button class='btn btn-sm btn-warning text-white view-document' data-id='{$row->id}' data-bs-toggle='modal' data-bs-target='#documentModal'><i class='bi bi-eye-fill'></i></button>
          </td>
          ";
        } elseif ($key == "actions-users") {
          echo "
          <td>
              <button class='btn btn-sm btn-danger' data-id='{$row->id}' data-target='delete'><i class='bi bi-trash-fill'></i></button>
              <button class='btn btn-sm btn-primary edit-user' data-id='{$row->id}' data-bs-toggle='modal' data-bs-target='#updateUserModal'><i class='bi bi-pencil-fill'></i></button>
          </td>
          ";
        } elseif ($key == "actions-dashboard") {
          echo "
          <td>
              <a href='{$row->url}}' class='btn btn-sm btn-warning text-white ' target='_blank'>
                  <i class='bi bi-eye-fill'></i>
              </a>
          </td>
          ";
        } else {
          echo "<td>{$row->$key}</td>";
        }
      }
      echo "</tr>";
    }
    ?>
  </tbody>
</table>