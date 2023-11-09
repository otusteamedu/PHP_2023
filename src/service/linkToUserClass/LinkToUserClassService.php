<?php

namespace src\service\linkToUserClass;

class LinkToUserClassService
{
    private array $dataSet;

    public function setFetchedDataSet(array $fetched): void
    {
        $this->dataSet = $fetched;
    }

    public function getLink2UserClass(): array
    {
        $dataSrc = $this->dataSet;
        $dt = $this->filterOnlyActive($dataSrc); //@fixme rename ..WithFilterActive
        $dt = $this->includeAliases($dt, 'value'); //@fixme use like public
        //@fixme add temp attribute and get-method for them $this->dt
        return $dt;
    }

    private function filterOnlyActive(array $dt): array
    {
        return array_filter($dt, fn($val) => $val['active'] ?? false);
    }

    public function includeAliases(array $dataset, string $name): array
    {
        $nameAliasesFiled = 'aliases';
        $acc = [];
        /** `$key => $value` is important names, use in second(string $name) argument */
        foreach ($dataset as $key => $value) {
            if (array_key_exists($nameAliasesFiled, $value)) {
                foreach ($value[$nameAliasesFiled] as $subVal) {
                    if (array_key_exists($subVal, $acc)) {
                        //@todo log rewrite exist value, keep State!
                    }
                    $acc[ $subVal ] = ${$name}; //@fixme exist variable?
                }
            }
        }

        return $acc;
    }
}
