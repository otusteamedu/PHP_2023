<?php

declare(strict_types=1);

namespace Ro\Php2023\Controllers;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface EventsControllerInterface
{
    public function add(Request $request): Response;
    public function getById(Request $request): Response;
    public function getAll(): Response;
    public function getMatching(Request $request): Response;
    public function delete(): Response;
}