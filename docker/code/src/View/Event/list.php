<?php

include $_SERVER['DOCUMENT_ROOT']."/src/View/header.php" ?>
<?php
$formData = $arrResult['formData'] ?? [];

if (!empty($arrResult['error'])) {
    echo '<span style="color: red">'.$arrResult['error'].'</span>';
}

if (!empty($arrResult['message'])) {
    echo '<span style="color: green">'.$arrResult['message'].'</span>';
}
if (!empty($arrResult['event'])) {
    echo '<span style="color: green">'.$arrResult['event']['event'].", приоритет ".$arrResult['event']['priority'].'</span>';
}
?>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px dotted #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .rating td {
            border: none;
        }

        .rating .label {
            font-weight: bold;
        }

        /* Выравнивание числовых ячеек по центру */
        td.number {
            text-align: center;
        }

        .asc::after {
            content: " ▲";
        }

        .desc::after {
            content: " ▼";
        }

        .asc, .desc {
            white-space: nowrap;
        }

        .container {
            max-width: max-content !important;
        }
    </style>
    <h2>Список событий</h2>
    
    <table>
        <tr>
        <tr>
            <th>#</th>
            <th>Событие</th>
            <th>Приоритет</th>
            <th>Параметры</th>
        </tr>
        
        </tr>
        <?php
        $i = 1;
        foreach ($arrResult['list'] as $event) {
            echo '<tr>';
            echo '<td class="number">'.$i++.'</td>';
            echo '<td>'.$event['event'].'</td>';
            echo '<td>'.$event['priority'].'</td>';
            echo '<td class="number">'.implode("<br>", $event['params']).'</td>';
            echo '</tr>';
        }
        ?>
    </table>
<?php
include $_SERVER['DOCUMENT_ROOT']."/src/View/footer.php" ?>