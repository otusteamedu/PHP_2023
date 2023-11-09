<?php

namespace src\factory;

use src\extern\inputFromDB\LinkDBData;
use src\extern\IoCInput;
use src\interface\LinkProviderInterface;
use src\service\link\LinkArrayProvider;
use src\service\link\source\LinkDynamicArrayData;

class FactoryLinkProvider
{
    public static function create(): LinkProviderInterface
    {
         return new LinkArrayProvider(
            //IoCInput::create(LinkDBData::class)
            IoCInput::create(LinkDynamicArrayData::class)
         );
    }
}
