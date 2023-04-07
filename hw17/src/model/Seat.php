<?php

namespace Builov\Cinema\model;

use Builov\Cinema\DB;
use PDO;

class Seat
{
    public $id;
    public $hall_id;
    public $row_number;
    public $seat_number;
    public $price_level_id;

    public $price_level;
    public $price_value;
    public $price_currency;
    public $hall_name;

    /**
     * @param $hall_id
     * @param $row_number
     * @param $seat_number
     * @param $price_level_id
     * @return int|bool
     */
    public function create($hall_id, $row_number, $seat_number, $price_level_id)
    {
        $query = 'INSERT INTO "public.seat" ("hall_id", "row_num", "seat_num", "price_level_id") values (?,?,?,?) RETURNING "id"';

        $stmt = DB::$conn->prepare($query);
        $stmt->execute([$hall_id, $row_number, $seat_number, $price_level_id]);

        if ($res = $stmt->fetch()) {
            return $res['id'];
        } else {
            return false;
        }
    }
    public function get($id)
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
    public function save()
    {
        $query = 'UPDATE "public.seat" SET "hall_id"=?, "row_num"=?, "seat_num"=?, "price_level_id"=? WHERE "id" = ?';

        $stmt = DB::$conn->prepare($query);
        $stmt->execute([$this->hall_id, $this->row_number, $this->seat_number, $this->price_level_id, $this->id]);

        if ($res = $stmt->fetch()) {
            return true;
        } else {
            return false;
        }
    }
    public function delete()
    {
        $query = 'DELETE FROM "public.seat" WHERE "id" = ?';

        $stmt = DB::$conn->prepare($query);
        $stmt->execute([$this->id]);

        if ($res = $stmt->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public function getHall()
    {
        return $this->hall_id;
    }
    public function getPrice()
    {
        return $this->hall_id;
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
                        "public.ticket" ON "public.seat"."id" = "public.ticket"."seat_id"
                    LEFT JOIN 
                        "public.order_list" ON "public.order_list"."ticket_id" = "public.ticket"."id"
                    LEFT JOIN 
                        "public.hall" ON "public.hall"."id" = "public.seat"."hall_id"
                    WHERE
                        "public.ticket"."session_id" = ' . $session_id . '
                    ORDER BY 
                        "hall_name", "public.seat"."row_num", "public.seat"."seat_num"';

        $res = DB::$conn->query($query);

        $data = [];
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {

            $data[$row["hall_name"]][$row["row_num"]][$row["seat_num"]] = $row["state"];
        }

        return $data;
    }

}