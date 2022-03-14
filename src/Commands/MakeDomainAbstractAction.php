<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

use Illuminate\Support\Str;

class MakeDomainAbstractAction extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-abstract-action';

    protected $description = 'Create a new abstract gdomain-action class';

    protected function getClassFqn(): string
    {
        return $this->fqnHelper()->fqn('action', Str::studly("abstract_{$this->fqnHelper()->getModel()}_action"), true);
    }

    protected function getVariables(): array
    {
        $h = $this->fqnHelper();

        $actionFqn = $this->getClassFqn();
        $repositoryFqn = $h->repositoryInterfaceFqn();

        return [
            'namespace' => $h->getModelNamespace('action', true),
            'className' => $h->baseClass($actionFqn),
            'repositoryInterfaceFqn' => $repositoryFqn,
            'repositoryInterface' => $h->baseClass($repositoryFqn),
        ];
    }
}
