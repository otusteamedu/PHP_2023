<?php

namespace src\service\link\source;

use src\extern\inputStaticStructure\LinkStaticArrayData;
use src\interface\FetchableArrayInterface;

class LinkDynamicArrayData implements FetchableArrayInterface
{
    public function fetch(): array
    {
        return IoCFetchableSource::create(
            LinkStaticArrayData::class
        )->fetch();
    }
}
