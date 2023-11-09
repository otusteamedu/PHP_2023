<?php

namespace src\service\linkToUserClass;

use src\factory\FactoryLinkProvider;

class ServiceWrapper {
    private LinkToUserClassService $selfService;
    private array $links;
    private array $acc;

    public function __construct() {
        $provider = FactoryLinkProvider::create();
        $this->selfService = new LinkToUserClassService();
        $this->selfService->setFetchedDataSet($provider->getService()->fetch());
    }

    public function setFetched(array $fetched): self {
        $this->selfService->setFetchedDataSet($fetched);
        return $this;
    }

    public function getLink2UserClass(): self {
        $this->links = $this->selfService->getLink2UserClass();
        return $this;
    }

    public function includeAliases(string $name): self {
        $this->acc = $this->selfService->includeAliases($this->links, $name);
        return $this;
    }

    public function getLinks(): array {
        return $this->links;
    }

    public function getAcc(): array {
        return $this->acc;
    }
}
