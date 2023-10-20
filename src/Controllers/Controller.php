<?php

namespace Raid\Core\Controller\Controllers;

use Illuminate\Routing\Controller as IlluminateController;
use Raid\Core\Controller\Traits\Controller\Crudable;
use Raid\Core\Controller\Traits\Controller\WithModule;
use Raid\Core\Controller\Traits\Controller\WithRepository;
use Raid\Core\Controller\Traits\Controller\WithResponse;
use Raid\Core\Controller\Traits\Controller\WithTransformer;
use Raid\Core\Controller\Traits\Response\FractalBuilder;
use Raid\Core\Controller\Traits\Response\ResponseBuilder;

abstract class Controller extends IlluminateController
{
    use Crudable;
    use FractalBuilder;
    use ResponseBuilder;
    use WithModule;
    use WithRepository;
    use WithResponse;
    use WithTransformer;
}
