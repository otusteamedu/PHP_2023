<?php

namespace Builov\Cinema\controller;

use Builov\Cinema\View;

class Seat
{
    /**
     * Карта занятости мест на определенный сеанс
     * @param $session_id
     * @return void
     */
    public function map($session_id = null): void
    {
        $map = \Builov\Cinema\model\Seat::getSeatsMap($session_id);

        View::out('./src/tmpl/hall_map.php', $map);
    }

    /**
     * тестовое создание новой записи (из данных POST)
     * @return void
     */
    public function create(): void
    {
        $seat = new \Builov\Cinema\model\Seat();
        echo $seat->create(1, 30, 32, 3);
    }

    /**
     * тестовое редактирование места (из данных POST)
     * @return void
     */
    public function update(): void
    {
        $seat = new \Builov\Cinema\model\Seat();

        if ($seat->load(1310)) {
            $seat->hall_id = 2;
            $seat->row_num = 31;
            echo $seat->save();
        } else {
            echo 'Не найдено.';
        }
    }

    /**
     * удаление места
     * @param $id
     * @return void
     */
    public function delete($id = null): void
    {
        $seat = new \Builov\Cinema\model\Seat();

        if ($deleted_id = $seat->delete($id)) {
            echo $deleted_id;
        } else {
            echo 'Не найдено.';
        }
    }

    /**
     * получение цены места
     * @param $id
     * @return void
     */
    public function price($id = null): void
    {
        $seat = new \Builov\Cinema\model\Seat();

        $seat->load($id);
        echo $seat->price;
    }

    /**
     * получение названия зала
     * @param $id
     * @return void
     */
    public function hall($id = null): void
    {
        $seat = new \Builov\Cinema\model\Seat();

        $seat->load($id);
        echo $seat->hall;
    }
}
