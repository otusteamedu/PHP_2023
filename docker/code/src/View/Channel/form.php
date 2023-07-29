<?php include $_SERVER['DOCUMENT_ROOT']. "/src/View/header.php" ?>
<?php
$formData = $arrResult['formData'];

if(!empty($arrResult['error'])){
    echo '<span style="color: red">'.$arrResult['error'].'</span>';
}

if(!empty($arrResult['message'])){
    echo '<span style="color: green">'.$arrResult['message'].'</span>';
}
?>

    <form action="" method="post">
        <div class="form-group">
            <label for="channel_id">Channel ID:</label>
            <input type="text" id="channel_id" name="channel_id" value="<?php echo $formData['channel_id'] ?>" required <?=(!empty($formData['id']) && $arrResult['formType']!=='add')?"disabled":'' ?> >
        </div>

        <div class="form-group">
            <label for="channel_name">Название канала:</label>
            <input type="text" id="channel_name" name="channel_name" value="<?php echo $formData['channel_name'] ?>" required>
        </div>

        <div class="form-group">
            <label for="subscribers">Подписчики:</label>
            <input type="text" id="subscribers" name="subscriber_count" value="<?php echo $formData['subscriber_count'] ?>" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Отправить">
        </div>
    </form>


<?php include $_SERVER['DOCUMENT_ROOT']. "/src/View/footer.php" ?>