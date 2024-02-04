<?php

declare(strict_types=1);

namespace Yevgen87\App\Infrastructure\Controllers;

use Exception;
use Yevgen87\App\Application\Services\Film\DTO\FilmDTO;
use Yevgen87\App\Application\Services\Film\FilmService;

class FilmController extends Controller
{
    public function __construct(private FilmService $filmService)
    {
    }

    public function index()
    {
        try {
            return $this->response($this->filmService->findAll());
        } catch (Exception $e) {
            return $this->response([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(array $data)
    {
        if (!(isset($data['title']) and isset($data['description']) and isset($data['image_preview']) and isset($data['teaser_preview']))) {
            return $this->response(
                [
                    'error' => 'Missing required params: title, description, image_preview or teaser_preview'
                ],
                400
            );
        }

        $dto = new FilmDTO(
            $data['title'],
            $data['description'],
            $data['image_preview'],
            $data['teaser_preview']
        );

        try {
            $film = $this->filmService->store($dto);
        } catch (\Exception $e) {
            return $this->response(['error' => $e->getMessage()], 500);
        }

        return $this->response($film, 201);
    }

    public function show(int $id)
    {
        try {
            return $this->response($this->filmService->getById($id));
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), $e->getCode());
        }
    }

    public function update(int $id, array $data)
    {
        if (!(isset($data['title']) or isset($data['description']) or isset($data['image_preview']) or isset($data['teaser_preview']))) {
            return $this->response(
                [
                    'error' => 'Missing required params: title, description, image_preview or teaser_preview'
                ],
                400
            );
        }

        $dto = new FilmDTO(
            $data['title'],
            $data['description'],
            $data['image_preview'],
            $data['teaser_preview']
        );

        try {
            return $this->response($this->filmService->update($id, $dto));
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), (int)$e->getCode());
        }
    }

    public function delete(int $id)
    {
        return $this->response($this->filmService->delete($id), 204);
    }
}
