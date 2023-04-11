<?php

namespace Builov\Cinema\model;

use Builov\Cinema\DB;
use PDO;

class Seat
{
    private int $id;
    private int $hall_id;
    private int $row_number;
    private int $seat_number;
    private int $price_level_id;
    private Hall $hall;
    private Price $price;

    /**
     * @param $property
     * @return Hall|Price|void
     */
    public function __get($property)
    {
        if ($property == 'hall') {
            return $this->getHall();
        }
        if ($property == 'price') {
            return $this->getPrice();
        }
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     * @param $property
     * @param $value
     * @return void
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    /**
     * @param $hall_id
     * @param $row_number
     * @param $seat_number
     * @param $price_level_id
     * @return int
     */
    public function create($hall_id, $row_number, $seat_number, $price_level_id): int
    {
        $this->set($hall_id, $row_number, $seat_number, $price_level_id);

        $query = 'INSERT INTO "public.seat" ("hall_id", "row_num", "seat_num", "price_level_id") values (?,?,?,?) RETURNING "id"';

        $stmt = DB::$conn->prepare($query);
        $stmt->execute([$this->hall_id, $this->row_number, $this->seat_number, $this->price_level_id]);

        if ($res = $stmt->fetch()) {
            return $res['id'];
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function load($id): bool
    {
        $query = 'SELECT "id", "hall_id", "row_num", "seat_num", "price_level_id" FROM "public.seat" WHERE "id" = ?';

        $stmt = DB::$conn->prepare($query);
        $stmt->execute([$id]);

        if ($res = $stmt->fetch()) {
            $this->id = $res['id'];
            $this->hall_id = $res['hall_id'];
            $this->row_number = $res['row_num'];
            $this->seat_number = $res['seat_num'];
            $this->price_level_id = $res['price_level_id'];
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $hall_id
     * @param $row_number
     * @param $seat_number
     * @param $price_level_id
     * @return void
     */
    private function set($hall_id, $row_number, $seat_number, $price_level_id): void
    {
        $this->hall_id = $hall_id;
        $this->row_number = $row_number;
        $this->seat_number = $seat_number;
        $this->price_level_id = $price_level_id;
    }

    /**
     * @return int
     */
    public function save(): int
    {
        if (isset($this->id)) {
            $query = 'UPDATE "public.seat" SET "hall_id"=?, "row_num"=?, "seat_num"=?, "price_level_id"=? WHERE "id" = ?  RETURNING "id"';

            $stmt = DB::$conn->prepare($query);
            $stmt->execute([$this->hall_id, $this->row_number, $this->seat_number, $this->price_level_id, $this->id]);

            if ($res = $stmt->fetch()) {
                return $res['id'];
            }
        }

        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id): mixed
    {
        $query = 'DELETE FROM "public.ticket" WHERE "seat_id" = ? RETURNING "id"';

        $stmt = DB::$conn->prepare($query);
        $stmt->execute([$id]);

        $query = 'DELETE FROM "public.seat" WHERE "id" = ? RETURNING "id"';

        $stmt = DB::$conn->prepare($query);
        $stmt->execute([$id]);

        if ($res = $stmt->fetch()) {
            return $res['id'];
        }

        return false;
    }

    /**
     * @return Hall
     */
    public function getHall(): Hall
    {
        $hall = new Hall();
        return $hall->get($this->hall_id);
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        $price = new Price();
        return $price->get($this->price_level_id);
    }

    /**
     * @param $session_id
     * @return array
     */
    public static function getSeatsMap($session_id)
    {
        $query = 'SELECT
                        "public.seat"."row_num",
                        "public.seat"."seat_num",
                        "public.hall"."name" as "hall_name",
                        CASE WHEN "public.order_list"."order_id" IS NOT NULL THEN \'sold\' ELSE \'vacant\' END as "state"
                    FROM
                        "public.seat"
                    LEFT JOIN
                        "public.hall" ON "public.hall"."id" = "public.seat"."hall_id"
                    LEFT JOIN
                        "public.ticket" ON "public.seat"."id" = "public.ticket"."seat_id"
                    LEFT JOIN
                        "public.order_list" ON "public.order_list"."ticket_id" = "public.ticket"."id"
                    WHERE
                        "public.ticket"."session_id" = ?
                    ORDER BY
                        "hall_name", "public.seat"."row_num", "public.seat"."seat_num"';

        $stmt = DB::$conn->prepare($query);
        $stmt->execute([$session_id]);

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[$row["hall_name"]][$row["row_num"]][$row["seat_num"]] = $row["state"];
        }

        return $data;
    }
}
