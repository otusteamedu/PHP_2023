<?php

namespace DimAl\Homework5\Presentation;

class EmailStatusHtmlView
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

    public function show()
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

        $vars = ['head' => $head, 'body' => $body];

        echo $this->render(__DIR__ . '/templates/emailstatus.tpl', $vars);
    }

    private function render($file, $vars): string
    {
        $html = file_get_contents($file);

        foreach ($vars as $n => $v) {
            $html = str_replace('$' . $n, $v, $html);
        }

        return $html;
    }
}
