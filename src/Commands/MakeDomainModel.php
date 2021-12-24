<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

use Symfony\Component\Console\Input\InputOption;

class MakeDomainModel extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-model';

    protected $description = 'Create a new domain-model class';

    protected $type = 'Model';

    protected $hasMultiplePerModel = false;

    public function handle()
    {
        if (parent::handle() === false && !$this->option('force')) {
            return false;
        }

        if ($this->option('all')) {
            $this->createException();
            $this->createRepositoryInterface();
            $this->createAction('create');
            $this->createAction('update');
            $this->createAction('delete');
        }

        return null;
    }

    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate all related files'],
            ['force', null, InputOption::VALUE_NONE, 'Create related files even if the model already exists'],
         ];
    }

    private function createAction(string $action)
    {
        $this->call('make:domain-action', [
            'domain' => $this->input->getArgument('domain'),
            'model' => $this->input->getArgument('name'),
            'name' => $action,
            '--all' => true,
        ]);
    }
}
