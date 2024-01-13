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
        $cityRep->getAll();
//        Table::dropTable();
//        Table::createTable();
//
//        $city = new City(
//            null,
//            'Moscow',
//            55.7558,
//            37.6173,
//        );
//
//        try {
//            $cityRep->add($city);
//        } catch (\Exception $e) {
//            echo $e->getMessage();
//        }

        $rs = $cityRep->getAll();
        $cities = [];
        foreach ($rs as $city) {
            $cities[] = CityPresenter::present($city);
        }

        return new JsonResponse(200, ['city' => $cities]);
    }
}
