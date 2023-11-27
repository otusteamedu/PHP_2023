<?php

namespace DimAl\Homework5\Services;

class BeautifulTableOutputService
{
    private array $table_cols_name = [];
    private array $rows = [];

    public function setTableTitle(array $cols)
    {
        foreach ($cols as $cn => $cv) {
            $this->table_cols_name[$cn] = $cv;
        }
    }

    public function setRows(array $rows)
    {
        $this->rows = $rows;
    }

    public function showTable()
    {
        $head = '';
        foreach ($this->table_cols_name as $v) {
            $head .= "<th scope=\"col\">$v</th>";
        }

        $body = '';
        foreach ($this->rows as $r) {
            $body .= "<tr>";
            $class = $r['status'] == 'OK' ? 'table-success' : 'table-danger';
            foreach ($r as $c) {

                $body .= "<td class=\"$class\">$c</td>";
            }
            $body .= "</tr>";
        }

        echo <<<HEREDOC
<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<head><title>Check Email service</title></head>
<body>
<table class="table table-striped" style="max-width:500px" align="center">
<thead class="thead-dark">
<tr>$head</tr>
</thead>
<tbody>$body</tbody>
</table>
</body>
</html>
HEREDOC;
    }
}
