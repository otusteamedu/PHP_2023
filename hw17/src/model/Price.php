<?php

namespace Builov\Cinema\model;

use Builov\Cinema\DB;

class Price
{
    public int $price_level_id;
    public string $price_level_name;
    public int $price_value;
    public string $currency_name;
    public string $currency_sign;

    public function get($id): Price
    {
        $query = 'SELECT
                        "public.price_level"."id" as "price_level_id",
                        "public.price_level"."name" as "price_level_name",
                        "public.price_level"."price" as "price_value",
                        "public.currency"."name" as "currency_name",
                        "public.currency"."sign" as "currency_sign"
                    FROM
                        "public.price_level"
                    LEFT JOIN 
                        "public.currency" ON "public.currency"."id" = "public.price_level"."currency_id"
                    WHERE
                        "public.price_level"."id" = ?';

        $stmt = DB::$conn->prepare($query);
        $stmt->execute([$id]);

        if ($res = $stmt->fetch()) {
            $this->price_level_id = $res['price_level_id'];
            $this->price_level_name = $res['price_level_name'];
            $this->price_value = $res['price_value'];
            $this->currency_name = $res['currency_name'];
            $this->currency_sign = $res['currency_sign'];
        }

        return $this;
    }

    public function __toString()
    {
        return $this->price_value . ' ' . $this->currency_sign;
    }
}
