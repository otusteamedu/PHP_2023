<?php

declare(strict_types=1);

namespace Yevgen87\App\Controllers;

use Yevgen87\App\Services\FilmService;

class FilmController extends Controller
{
    /**
     * @var FilmService
     */
    private FilmService $filmService;

    public function __construct()
    {
        $this->filmService = new FilmService();
    }

    public function index()
    {
        return $this->response($this->filmService->findAll());
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

        try {
            $film = $this->filmService->store($data);
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

        try {
            return $this->response($this->filmService->update($id, $data));
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), (int)$e->getCode());
        }
    }

    public function delete(int $id)
    {
        return $this->response($this->filmService->delete($id), 204);
    }
}
