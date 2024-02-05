<?php

namespace GKarman\CleanCode\OldCode\Models;

class Order extends ModelEloquent
{
    const STATUS_CREATED = 100;
    const STATUS_STARTED = 200;
    const STATUS_DONE = 300;

    const STATUS_DELETE = 400;

    public int $status;

}
