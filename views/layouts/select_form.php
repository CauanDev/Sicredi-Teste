    <div id="error-container-<?php echo $title; ?>" class="invalid-feedback"></div>
    <div class="form-group" id="select-container-<?php echo $title; ?>">
        <label for="select-<?php echo $title; ?>"><?php echo $placeholder ?></label>
        <select class="form-control" id="select-<?php echo $title; ?>" name="select-<?php echo $title; ?>">
            <?php
            foreach ($options as $option) {
                echo "<option value='{$option->id}' data-target='{$option->target}'>{$option->label}</option>";
            }
            ?>
        </select>
    </div>
