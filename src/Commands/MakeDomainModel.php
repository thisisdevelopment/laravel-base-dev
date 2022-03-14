<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

class MakeDomainModel extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-model';

    protected $description = 'Create a new domain-model class';

    protected function getClassFqn(): string
    {
        return $this->fqnHelper()->modelFqn();
    }

    protected function getVariables(): array
    {
        $h = $this->fqnHelper();

        $modelFqn = $h->modelFqn();

        return [
            'namespace' => $h->getModelNamespace('model', false),
            'className' => $h->baseClass($modelFqn),
        ];
    }
}
