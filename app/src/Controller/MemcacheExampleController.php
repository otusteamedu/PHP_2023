<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\StringBracketsVerifier;
use Memcached;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/memcached')]
class MemcacheExampleController extends AbstractController
{
    private Memcached $memcached;

    public function __construct(StringBracketsVerifier $stringVerifier)
    {
        $this->memcached = new Memcached();
        $this->memcached->addServer(
            $_ENV['MEMCACHED_HOST'],
            (int)$_ENV['MEMCACHED_PORT']
        );
    }

    #[Route('/set', name: 'set', methods: 'POST')]
    public function setMemcache(): JsonResponse
    {
        $this->memcached->set('key', 'value');
        return $this->json([
            'server' => $_SERVER['HOSTNAME'],
            'memcached_host' => $_ENV['MEMCACHED_HOST'],
            'value' => $this->memcached->get('key'),
        ]);
    }

    #[Route('/get', name: 'get', methods: 'GET')]
    public function getMemcache(): JsonResponse
    {
        return $this->json([
            'server' => $_SERVER['HOSTNAME'],
            'memcached_host' => $_ENV['MEMCACHED_HOST'],
            'value' => $this->memcached->get('key'),
        ]);
    }
}