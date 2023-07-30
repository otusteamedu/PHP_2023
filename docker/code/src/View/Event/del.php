<?php
include $_SERVER['DOCUMENT_ROOT'] . "/src/View/header.php" ?>
<?php
if (!empty($arrResult['error'])) {
    echo '<span style="color: red">' . $arrResult['error'] . '</span>';
}

if (!empty($arrResult['message'])) {
    echo '<span style="color: green">' . $arrResult['message'] . '</span>';
}
?>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/src/View/footer.php";
