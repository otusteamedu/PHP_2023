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

        .container {
            max-width: max-content !important;
        }
    </style>

    <h2>Список видео</h2>
    <a href="/movie/add/">Добавить</a>
    <table>
        <tr>
        <tr>
            <th>#</th>
            <th>Movie ID</th>
            <th>Channal ID</th>
            <th>Название видео</th>
            <th>Описание видео</th>
            <th>Лайки</th>
            <th>Дизайлки</th>
            <th>Длительность</th>
            <th>Редактировать</th>
            <th>Удалить</th>
        </tr>

        </tr>
        <?php
        $i = 1;
        foreach ($arrResult['list'] as $movie) {
            echo '<tr>';
            echo '<td class="number">' . $i++ . '</td>';
            echo '<td>' . $movie['movie_id'] . '</td>';
            echo '<td>' . $movie['channel_id'] . '</td>';
            echo '<td>' . $movie['movie_name'] . '</td>';
            echo '<td>' . $movie['movie_description'] . '</td>';
            echo '<td class="number">' . $movie['like'] . '</td>';
            echo '<td class="number">' . $movie['dislike'] . '</td>';
            echo '<td class="number">' . $movie['duration'] . '</td>';
            echo '<td><a href="/movie/update/' . $movie['movie_id'] . '/">Редактировать</a></td>';
            echo '<td><a href="/movie/delete/' . $movie['movie_id'] . '/"  onclick="return confirmDelete()">Удалить</a></td>';
            echo '</tr>';
        }
        ?>
    </table>
    <script>
        function confirmDelete() {
            const result = confirm("Вы действительно хотите удалить?");
            return result;
        }
    </script>
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