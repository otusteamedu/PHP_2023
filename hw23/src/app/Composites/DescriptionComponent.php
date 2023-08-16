<?php

namespace App\Composites;

use App\Decorators\TrackDescriptionDecorator;
use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Database\Eloquent\Model;

abstract class DescriptionComponent extends Model
{
    public function setDescription(Track|Playlist &$instance): void
    {
        $descriptionDecorator = new TrackDescriptionDecorator($instance, $instance->description);

        $instance->description = $descriptionDecorator->decorate($instance instanceof Track);
    }
}
