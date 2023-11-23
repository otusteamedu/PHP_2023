<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use AntonArdyshev\OtusComposerPackage\TransliteratorProcessor;

$processor = new TransliteratorProcessor();
$text = 'Ёж поймал в реке 2-е щуки и съел на ужин очень вкусную пиццу';

echo $processor->getFriendlyUrlForRussianLanguage($text);
