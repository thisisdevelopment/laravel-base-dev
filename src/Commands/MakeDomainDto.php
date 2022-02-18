<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

use Symfony\Component\Console\Input\InputArgument;

class MakeDomainDto extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-dto';

    protected $description = 'Create a new domain-dto class';

    protected function getClassFqn(): string
    {
        return $this->fqnHelper()->dtoFqn($this->argument('type'));
    }

    protected function getVariables(): array
    {
        $h = $this->fqnHelper();

        $modelFqn = $h->dtoFqn($this->argument('type'));

        return [
            'namespace' => $h->getModelNamespace('dto', true),
            'className' => $h->baseClass($modelFqn),
        ];
    }

    protected function getArguments(): array
    {
        return [
            ...parent::getArguments(),
            ['type', InputArgument::REQUIRED, 'the type of event to generate']
        ];
    }
}
