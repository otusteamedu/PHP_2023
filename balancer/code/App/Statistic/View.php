<?php

namespace IilyukDmitryi\App\Statistic;

class View
{
    public static function show(array $statistic)
    {
        $arrIp = array_keys($statistic);
        $arrHosts = array_keys(array_merge(...array_values($statistic)));
        $currResult = end($_SESSION['StatisticController'][$_ENV['SERVER_ADDR']][$_ENV['HOSTNAME']]);
        ?>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                max-width: 800px;
                margin: 0 auto;
            }

            thead {
                background-color: #f5f5f5;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            th {
                font-weight: bold;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            @media screen and (max-width: 600px) {
                table {
                    font-size: 14px;
                }
            }
        </style>
        <hr>
        <table>
            <thead>
            <tr>
                <td><b>Last result check </b></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= $currResult ?></td>
            </tr>
            </tbody>
        </table>
        <hr>
        <table>
            <thead>
            <tr>
                <td><b>HOST/IP</b></td>
                <?php
                foreach ($arrIp as $ip) {
                    ?>
                    <td>
                        <?= $ip ?>
                    </td>
                    <?php
                } ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($arrHosts as $host) {
                ?>
                <tr>
                    <td><?= $host ?></td>
                    <?php
                    foreach ($arrIp as $ip) {
                        if (!isset($statistic[$ip][$host])) {
                            $arrStat = [];
                        } else {
                            $arrStat = $statistic[$ip][$host];
                        }
                        echo '<td>';
                        foreach ($arrStat as $emails) {
                            echo $emails . "<hr>";
                        }
                        echo '</td>';
                    } ?>
                </tr>
                <?
            }
            ?>
            </tbody>
        </table>
        <?php
    }
}
