<?php

include $_SERVER['DOCUMENT_ROOT'] . "/src/View/header.php" ?>

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
    </style>

<?php
if (!empty($arrResult['error'])) {
    echo '<span style="color: red">' . $arrResult['error'] . '</span>';
}

if (!empty($arrResult['message'])) {
    echo '<span style="color: green">' . $arrResult['message'] . '</span>';
} ?>
    <h2>Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков</h2>
    <table>
        <tr>
        <tr>
            <th onclick="sortTable(this)">#</th>
            <th>Channel ID</th>
            <th>Название канала</th>
            <th onclick="sortTable(this)">Подписчики</th>
            <th onclick="sortTable(this)">Лайки</th>
            <th onclick="sortTable(this)">Дизлайки</th>
        </tr>

        </tr>
        <?php
        $i = 1;
        foreach ($arrResult['list'] as $channel) {
            echo '<tr>';
            echo '<td class="number">' . $i++ . '</td>';
            echo '<td>' . $channel['channel_id'] . '</td>';
            echo '<td>' . $channel['channel_name'] . '</td>';
            echo '<td class="number">' . $channel['subscriber_count'] . '</td>';
            echo '<td class="number">' . $channel ['summary']['likes'] . '</td>';
            echo '<td class="number">' . $channel ['summary']['dislikes'] . '</td>';
            echo '</tr>';
        }

        ?>
    </table>

    <form id="myForm" method="GET">
        <label for="itemsPerPage">Количество элементов:</label>
        <select id="itemsPerPage" name="items_per_page" onchange="document.getElementById('myForm').submit()">
            <?php
            $currCntTop = $_GET['items_per_page'] ?? 100;

            for ($option = 100; $option <= 1000; $option += 100) {
                $selected = $currCntTop == $option ? 'selected' : '';
                echo "<option value='$option' $selected>$option</option>";
            }
            ?>
        </select>
    </form>
    <script>
        function sortTable(header) {
            let table, rows, switching, i, x, y, shouldSwitch, columnIndex;
            table = document.querySelector('table');
            switching = true;
            columnIndex = header.cellIndex;
            let sortOrder = header.classList.contains('asc') ? 'desc' : 'asc';

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = parseFloat(rows[i].cells[columnIndex].textContent);
                    y = parseFloat(rows[i + 1].cells[columnIndex].textContent);

                    if ((sortOrder === 'asc' && x > y) || (sortOrder === 'desc' && x < y)) {
                        shouldSwitch = true;
                        break;
                    }
                }

                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
            let headers = table.querySelectorAll('th');
            headers.forEach((header) => {
                header.classList.remove('asc', 'desc');
            });
            header.classList.add(sortOrder);
        }
    </script>


<?php
include $_SERVER['DOCUMENT_ROOT'] . "/src/View/footer.php" ?>