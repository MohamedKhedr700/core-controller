<?php

namespace Raid\Core\Controller\Commands;

use Raid\Core\Command\Commands\CreateCommand;

class CreateTransformerCommand extends CreateCommand
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'core:make-transformer {classname}';

    /**
     * The console command description.
     */
    protected $description = 'Make a transformer class';

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
        return __DIR__.'/../../resources/stubs/transformer.stub';
    }

    /**
     * Map the stub variables present in stub to its value.
     */
    public function getStubVariables(): array
    {
        return [
            'NAMESPACE' => 'App\\Http\\Transformers',
            'CLASS_NAME' => $this->getClassName(),
        ];
    }

    /**
     * Get the full path of generated class.
     */
    public function getSourceFilePath(): string
    {
        return app_path('Http/Transformers/'.$this->getClassName()).'.php';
    }
}
