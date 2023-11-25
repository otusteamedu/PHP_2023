<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<form  action = '/src/EmailValidation.php' method="POST">
    <label for="email">Input EMAIL for validate</label>
    <input type="text" id = "email_str" name="email_str" placeholder="Input EMAIL">
    <button type="submit">Validate</button>
</form>
</body>
</html>
<?php
?>