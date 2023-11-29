<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Emails Verifications</title>
</head>
<body>
<h3>Emails Verifications</h3>
<form action="app.php" method="post" id="Form">
    <label for="Emails">Emails List</label><br />
    <textarea name="emails" id="Emails" rows="10" cols="50"></textarea>
    <p><button type="button" onclick="sendForm()">Validate</button></p>
</form>
<div id="Result"></div>
<script src="index.js"></script>
</body>
</html>