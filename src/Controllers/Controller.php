<?php

namespace Raid\Core\Modules\Controllers;

use Illuminate\Routing\Controller as IlluminateController;
use Raid\Core\Modules\Traits\Controller\Crudable;
use Raid\Core\Modules\Traits\Controller\WithControllerResolver;
use Raid\Core\Modules\Traits\Response\FractalBuilder;
use Raid\Core\Modules\Traits\Response\ResponseBuilder;

abstract class Controller extends IlluminateController
{
    use Crudable;
    use FractalBuilder;
    use ResponseBuilder;
    use WithControllerResolver;
}
