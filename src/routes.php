<?php

/*****************************************************************
 * WebDrink API Routes
 *
 * This file defines the outside routes for the API
 *****************************************************************/

/*
 * API v2
 *
 * v2 will represent all routes that are modeled off of the WebDrink-2.0 API
 * A lot of the basic transitions from WebDrink 2.0 to the new API will be made easy through these routes
 * These routes will also serve to help understand how the new v3 of the API needs to be formatted
 */

use Slim\Http\Request;
use Slim\Http\Response;
use WebDrinkAPI\Middleware\AuthMiddleware;

$app->get('/', function (Request $request, Response $response) {
    // TODO: Create fancy display page that shows to documentation
    return $response->withJson([__DIR__, __DIR__ . '/src/api/v2/test.php'], 200, JSON_PRETTY_PRINT);
});

$app->group('/v2', function () use ($app) {
    $app->group('/test', function () use ($app) {
        require __DIR__ . '/api/v2/test.php';
    });

    $auth = new AuthMiddleware();

    $app->group('/users', function () use ($app) {
        require __DIR__ . '/api/v2/users.php';
    })->add($auth);

    $app->group('/machines', function () use ($app) {
        require __DIR__ . '/api/v2/machines.php';
    })->add($auth);

    $app->group('/items', function () use ($app) {
        require __DIR__ . '/api/v2/items.php';
    })->add($auth);

    $app->group('/temps', function () use ($app) {
        require __DIR__ . '/api/v2/temps.php';
    })->add($auth);

    $app->group('/drops', function () use ($app) {
        require __DIR__ . '/api/v2/drops.php';
    })->add($auth);
});

$app->group('/v3', function () use ($app) {
    //TODO
});