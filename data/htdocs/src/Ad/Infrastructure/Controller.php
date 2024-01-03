<?php

namespace Ad\Infrastructure;

use Ad\App\AddAction;
use Ad\Domain\Ad;
use Ad\Domain\Type;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManagerInterface;
use FileStorage\App\FileManager;
use Geolocation\Domain\City;
use OpenApi\Annotations as OA;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Somnambulist\Components\Validation\Factory;
use Sunrise\Http\Message\Response\JsonResponse;

/**
 * @OA\Info(
 *     title="Ad API",
 *     version="1.0.0",
 * )
 */
class Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/ad",
     *     @OA\Response(
     *         response="200",
     *         description="The data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="ads",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Ad")
     *             )
     *         )
     *     )
     * )
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): JsonResponse
    {
        $debugStack = new DebugStack();

        $em = container()->get(EntityManagerInterface::class);
        $em->getConnection()->getConfiguration()->setSQLLogger($debugStack);

        $rep = $em->getRepository(Ad::class);
        $all = $rep->findBy([]);

        $arResult = [];
        $arResult['_debug']['_before_presenting'] = (count($debugStack->queries));

        /**
         * @var Ad $ad
         */
        foreach ($all as $ad) {
            $arResult['ads'][] = ArrayPresenter::present($ad);
        }

        $arResult['_debug']['_after_presenting'] = (count($debugStack->queries));

        ksort($arResult);

        return new JsonResponse(200, $arResult);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/ad",
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="The title of the ad",
     *         required=true
     *     ),
     *     @OA\Parameter(
     *          name="price",
     *          in="query",
     *          description="The price of the ad",
     *          required=true
     *      ),
     *     @OA\Parameter(
     *         name="photo[]",
     *         in="query",
     *         description="The photo of the ad",
     *         required=true
     *     ),
     *     @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="The city of the ad",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="The data",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/Ad"
     *         )
     *    )
     * )
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function add(ServerRequestInterface $request): JsonResponse
    {
        $arResult = [];
        // validation
        $validation = (new Factory())->make($_POST + $_FILES, [
            'title' => 'required|min:10|max:255',
            'price' => 'required|integer',
            'photo' => 'required|array',
            'photo.*' => 'required|uploaded_file:0,500K,png,jpeg',
            'city' => 'required|integer',
        ]);
        $validation->validate();

        if ($validation->fails()) {
            $errors = $validation->errors();
            $arResult['errors'] = $errors->firstOfAll();
            return new JsonResponse(422, $arResult);
        }

        $validData = $validation->getValidData();

        // cities
        $citiesRep = container()->get(EntityManagerInterface::class)->getRepository(City::class);
        $city = $citiesRep->findOneBy(['id' => $validData['city']]); // almaty

        // upload files
        $arPhotos = $request->getUploadedFiles()['photo'];
        $arPhotos = array_map(function (UploadedFileInterface $file) {
            return container()->get(FileManager::class)->upload($file);
        }, $arPhotos);

        // save
        $dto = new AdDTO();
        $dto->setTitle($_POST['title'])
            ->setPrice($_POST['price'])
            ->setDescription($_POST['description'])
            ->setPhoto($arPhotos)
            ->setType(Type::work)
            ->setCity($city);

        $action = container()->make(AddAction::class);
        $ad = $action->execute($dto);

        $arResult = ArrayPresenter::present($ad);

        return new JsonResponse(200, $arResult);
    }
}