<?php

namespace Ad\Domain;

enum Status: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case PROCESSED = 'processed';
    case DONE = 'done';
    case CANCELLED = 'cancelled';
}