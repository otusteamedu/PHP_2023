<?php

namespace Order\App;

class AddOrderDTO
{
    public function __construct(
        public string $email,
        public \DateTime $from,
        public \DateTime $to
    ) {
    }

    public function toJson()
    {
        return json_encode([
            'from' => $this->from->format('Y-m-d H:i:s'),
            'to' => $this->to->format('Y-m-d H:i:s')
        ]);
    }
}
