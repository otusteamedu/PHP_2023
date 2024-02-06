<?php

namespace old\code\src\OldCode\Models;

use old\code\src\OldCode\Models\ModelEloquent;

class Member extends ModelEloquent
{
    public ?int $id;
    public int $carrier_company_id;
    public int $price;
}
