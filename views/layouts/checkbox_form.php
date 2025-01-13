<div id="error-container-<?php echo $title; ?>" class="invalid-feedback"></div>
<div class="row " id="checkbox-container-<?php echo $title; ?>">
    <?php
    $counter = 0;
    foreach ($options as $option) {
        echo "
                <div class='col-12 col-md-4'>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' value='{$option->value}' data-target='{$option->target}' data-value='{$option->label}' data-status='{$option->status}' data-id='{$option->id}' id='check_{$option->label}'>
                        <label class='form-check-label' for='check_{$option->label}'>
                            {$option->label}
                        </label>
                    </div>
                </div>";

        $counter++;
        if ($counter % 3 == 0) {
            echo "</div><div class='row'>";
        }
    }
    ?>
</div>