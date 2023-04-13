<?php

namespace Builov\Cinema\model;

use Builov\Cinema\DB;
use PDOException;

class Hall
{
    public int $id;
    public string $name;

    public function get($id): Hall
    {
        self::dbConnect();

        $query = 'SELECT
                        "public.hall"."id",
                        "public.hall"."name"
                    FROM
                        "public.hall"
                    WHERE
                        "public.hall"."id" = ?';

        $stmt = DB::$conn->prepare($query);
        $stmt->execute([$id]);

        if ($res = $stmt->fetch()) {
            $this->id = $res['id'];
            $this->name = $res['name'];
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    private static function dbConnect(): void
    {
        try {
            DB::connect();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
