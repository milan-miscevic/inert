# inert

[![Software License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg?style=flat-square)](https://github.com/php-pds/skeleton)

[![GitHub Build](https://github.com/milan-miscevic/inert/workflows/Test/badge.svg?branch=master)](https://github.com/milan-miscevic/inert/actions)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=milan-miscevic_inert&metric=alert_status)](https://sonarcloud.io/dashboard?id=milan-miscevic_inert)
[![Type Coverage](https://shepherd.dev/github/milan-miscevic/inert/coverage.svg)](https://shepherd.dev/github/milan-miscevic/inert)

This repository provides a mini PHP framework with basic MVC and service container support. The name comes from the type of projects it is intended for - small and (almost) non-dynamic, or just inert.

After working with full-fledged frameworks on bigger projects, it can be strange to work in vanilla PHP with `require`s and without controllers and actions. The main idea was to bring controllers and actions to small private projects to organize code but keep simplicity (of configuration) from vanilla PHP and dependencies minimal. This is how this framework was born. Later, during development, the service locator is added.

## Minimal installation

Install Inert via Composer:

```bash
composer require milan-miscevic/inert
```

`index.php`

```php
<?php

use Mmm\Inert\ActionContainer;
use Mmm\Inert\Application;
use Mmm\Inert\ServiceContainer;

require '../vendor/autoload.php';

$actions = [
    'index' => IndexAction::class,
];

$actionContainer = new ActionContainer(
    $actions,
    new ServiceContainer([])
);

echo (new Application($actionContainer))->run()->getContent();
```

`IndexAction.php`:

```php
<?php

use Mmm\Inert\Action;
use Mmm\Inert\Response;

class IndexAction implements Action
{
    public function run(): Response
    {
        return new Response('Hello, world!');
    }
}
```
