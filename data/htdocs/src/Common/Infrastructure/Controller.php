<?php

namespace Common\Infrastructure;

use Geolocation\Domain\City;
use Geolocation\Domain\CityRepositoryInterface;
use Geolocation\Infrastructure\CityPresenter;
use Geolocation\Infrastructure\Table;
use Psr\Http\Message\ResponseInterface;
use Sunrise\Http\Message\Response\JsonResponse;

class Controller
{
    public function __construct()
    {
    }

    /**
     * @OA\Get(
     *     path="/",
     *     operationId="index",
     *     @OA\Response(
     *         response="200",
     *         description="Main page"
     *     )
     * )
     */
    public function index(): ResponseInterface
    {
        /** @var CityRepositoryInterface $cityRep */
        $cityRep = container()->get(CityRepositoryInterface::class);
        Table::dropTable();
        Table::createTable();

        $city = new City(
            null,
            'Paris',
            48.8534,
            2.3488
        );

        try {
            $cityRep->add($city);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $city = $cityRep->getByName('Paris');

        return new JsonResponse(200, ['city' => CityPresenter::present($city)]);
    }
}
