<html>
<body>
<style>
    div {
        border: 1px solid #ccc;
        border-radius: 50%;
        text-align: center;
        padding: 5px;
    }
</style>

<?php foreach ($map as $hall => $rows): ?>
    <h1><?= $hall ?></h1>
    <table>
    <?php foreach ($rows as $row => $seats): ?>
        <tr>
        <?php foreach ($seats as $seat => $state): ?>
            <td>
                <div><?= $row ?>-<?= $seat ?><br><?= $state ?></div>
            </td>
        <?php endforeach ?>
        </tr>
    <?php endforeach ?>
    </table>
<?php endforeach ?>

</body>
</html>
