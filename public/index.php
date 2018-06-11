<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\HttpRequest;
use App\JsonResponse;
use App\Router;
use App\UserValidator;

$container                      = new Pimple\Container();
$container['challenge_manager'] = function () {
    return new \App\ChallengeManager();
};
$container['user_validator']    = function () {
    return new UserValidator();
};
$container['request']           = function () {
    return new HttpRequest();
};
$container['route_matcher']     = function () {
    return new \App\RouteMatcher();
};
$container['router']            = function ($c) {
    return new Router($c['request'], $c['route_matcher']);
};

/** @var Router $router */
$router = $container['router'];
$router->addRoute('/challenges', 'GET', function () use ($container) {
    $challenges = $container['challenge_manager']->getChallenges();

    return new JsonResponse($challenges);
});

$router->addRoute('/challenges/{id}', 'GET', function ($id) use ($container) {
    $challenge = (new \App\ChallengeManager())->getChallengeById($id);

    return new JsonResponse($challenge);
});

$router->addRoute('/score', 'POST', function () use ($container) {
    $request     = $container['request'];
    $token       = $request->getHeaders()['X_AUTH_TOKEN'] ?? null;
    $challengeId = $request->get('challenge_id');

    try {
        if (!$challengeId) {
            throw new \Exception('Missing parameter: challenge_id');
        }
        /** @var \App\User $user */
        $user = $container['user_validator']->getUserFromToken($token);
    } catch (\Exception $exception) {
        return new JsonResponse(['error' => $exception->getMessage()], 400);
    }
    $points = $container['challenge_manager']->getChallengeById($challengeId)->points;
    $user->addPoints($points);

    return new JsonResponse(['message' => "$points points added."]);
});

$response = $router->dispatch();

$response->render();