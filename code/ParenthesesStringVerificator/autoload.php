<?

spl_autoload_register(
    function ($sClassName) {
        $iOffset = mb_strrpos($sClassName, '\\');
        $sFileName = __DIR__ . '/' . substr($sClassName, ($iOffset + 1)) . ".php";
        if (file_exists($sFileName)) {
            require $sFileName;
        }
    }
);