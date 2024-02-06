<?php

namespace old\code\src\OldCode\Models;

use old\code\src\OldCode\Models\ModelEloquent;

class Order extends ModelEloquent
{
    const STATUS_CREATED = 100;
    const STATUS_STARTED = 200;
    const STATUS_DONE = 300;

    const STATUS_DELETE = 400;

    public int $status;

}
