<?php


namespace IilyukDmitryi\App\Statistic;

class StatisticSession implements StatisticEngine
{
    public function addStat(bool $isSucces, string $str): void
    {
        $key = $str . " - " . ($isSucces ? 'good' : 'fail');
        if (!isset($_SESSION['StatisticController'][$_ENV['SERVER_ADDR']][$_ENV['HOSTNAME']][$key])) {
            $_SESSION['StatisticController'][$_ENV['SERVER_ADDR']][$_ENV['HOSTNAME']][$key] = 0;
        }
        $_SESSION['StatisticController'][$_ENV['SERVER_ADDR']][$_ENV['HOSTNAME']][$key]++;
    }

    public function printStat()
    {
        $stat = $_SESSION['StatisticController'];
        $arrIp = array_keys($stat);
        $arrHosts = array_keys(array_merge(...array_values($stat)));

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
                        if (!isset($stat[$ip][$host])) {
                            $arrStat = [];
                        } else {
                            $arrStat = $stat[$ip][$host];
                        }
                        echo '<td>';
                        foreach ($arrStat as $key => $count) {
                            echo $key . '&nbsp;-&nbsp;' . $count . "</br>";
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