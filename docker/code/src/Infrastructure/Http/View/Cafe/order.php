<?php

include dirname(__DIR__)."/header.php" ?>
<?php
$formData = $arrResult['formData'] ?? [];

if (!empty($arrResult['error'])) {?>
    <div>
    <?php
    echo '<span style="color: red">'.$arrResult['error'].'</span>';
    ?>
    </div>
    <hr>
    <div style="text-align: center">
    <a href="?refresh=1"> Попробовать  еще раз</a>
    </div>
    <?php
}
if (!empty($arrResult['message'])) {
    echo '<span style="color: green">'.$arrResult['message'].'</span>';
}
?>
<?php
include dirname(__DIR__)."/footer.php" ?>