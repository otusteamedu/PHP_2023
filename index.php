<!DOCTYPE html>
<html>
<body>
<form id="form" method="POST" action="save_data.php">
    <input type="text" name="text_field[]">
    <button type="submit">SUBMIT</button>
</form>
<button onclick="add_field()">ADD FIELD</button>
<script>
    function add_field(){
        var x = document.getElementById("form");
        var new_field = document.createElement("input");
        new_field.setAttribute("type", "text");
        new_field.setAttribute("name", "text_field[]");
        var pos = x.childElementCount;
        x.insertBefore(new_field, x.childNodes[pos]);
    }
</script>
</body>
</html>