<?php

declare(strict_types=1);

namespace Gesparo\Homework\Infrastructure\Controller;

use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\Request;

#[OAT\Info(
    version: '1.0.0',
    description: 'Homework API',
    title: 'Homework API',
    contact: new OAT\Contact(
        name: 'Gesparo',
        email: 'gesparo1@gmail.com'
    ),
    license: new OAT\License(name: 'MIT')
)]
#[OAT\Server(url: 'http://mysite.local')]
class AbstractController
{
    public function __construct(
        protected readonly Request $request
    ) {
    }
}
