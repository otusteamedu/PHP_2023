<?php

namespace old\code\src\OldCode\Models;

class Member extends ModelEloquent
{
    public ?int $id;
    public int $carrier_company_id;
    public int $price;
}
