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
            <label for="movie_id">Movie ID:</label>
            <input type="text" id="movie_id" name="movie_id" value="<?php echo $formData['movie_id'] ?>" required <?=(!empty($formData['id']) && $arrResult['formType']!=='add')?"disabled":'' ?> >
        </div>
        <div class="form-group">
            <label for="movie_id">Channal ID:</label>
            <input type="text" id="channel_id" name="channel_id" value="<?php echo $formData['channel_id'] ?>" required>
        </div>
        <div class="form-group">
            <label for="movie_name">Название Видео:</label>
            <input type="text" id="movie_name" name="movie_name" value="<?php echo $formData['movie_name'] ?>" required>
        </div>
        <div class="form-group">
            <label for="movie_name">Описание Видео:</label>
            <textarea name="movie_description"><?php echo $formData['movie_description'] ?></textarea>
        </div>

        <div class="form-group">
            <label for="subscribers">Лайки:</label>
            <input type="text" id="like" name="like" value="<?php echo $formData['like'] ?>" required>
        </div>
        <div class="form-group">
            <label for="subscribers">Дизайлки:</label>
            <input type="text" id="dislike" name="dislike" value="<?php echo $formData['dislike'] ?>" required>
        </div>
        <div class="form-group">
            <label for="subscribers">Длительность:</label>
            <input type="text" id="duration" name="duration" value="<?php echo $formData['duration'] ?>" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Отправить">
        </div>
    </form>


<?php include $_SERVER['DOCUMENT_ROOT']. "/src/View/footer.php" ?>