<?php

include dirname(__DIR__) . "/header.php" ?>
<?php
if (!empty($arrResult['error'])) {
    echo '<span style="color: red">' . $arrResult['error'] . '</span>';
}

if (!empty($arrResult['message'])) {
    echo '<span style="color: green">' . $arrResult['message'] . '</span>';
} ?>
<?php
include dirname(__DIR__) . "/footer.php";
