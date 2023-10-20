<?php

namespace Raid\Core\Controller\Commands;

use Raid\Core\Command\Commands\CreateCommand;

class CreateControllerCommand extends CreateCommand
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'core:make-controller {classname}';

    /**
     * The console command description.
     */
    protected $description = 'Make a controller class';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->createCommand();
    }

    /**
     * Return the stub file path.
     */
    public function getStubPath(): string
    {
        return __DIR__.'/../../resources/stubs/controller.stub';
    }

    /**
     * Map the stub variables present in stub to its value.
     */
    public function getStubVariables(): array
    {
        return [
            'NAMESPACE' => 'App\\Http\\Controller',
            'CLASS_NAME' => $this->getClassName(),
        ];
    }

    /**
     * Get the full path of generated class.
     */
    public function getSourceFilePath(): string
    {
        return app_path('Http/Controller/'.$this->getClassName()).'.php';
    }
}
