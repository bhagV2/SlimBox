<?php

use Slim\App;
use App\Controllers\AccueilController;

return function (App $app) {
    $app->get('/', [AccueilController::class, 'index']);
};