<!DOCTYPE html>
<html>
<head>
    <title>Event System</title>
</head>
<body>
    <h1>Event System</h1>
    <h2>Add Event</h2>
    <form action="index.php?action=add" method="post">
        <label for="priority">Priority:</label>
        <input type="text" name="priority" id="priority"><br><br>
        <label for="conditions">Conditions:</label>
        <input type="text" name="conditions" id="conditions"><br><br>
        <label for="event">Event:</label>
        <input type="text" name="event" id="event"><br><br>
        <input type="submit" value="Add Event">
    </form>

    <h2>Clear Events</h2>
    <form action="index.php?action=clear" method="post">
        <input type="submit" value="Clear Events">
    </form>

    <h2>Find Matching Event</h2>
    <form action="index.php?action=find" method="get">
        <label for="params">Params:</label>
        <input type="text" name="params" id="params"><br><br>
        <input type="submit" value="Find Matching Event">
    </form>
</body>
</html>
