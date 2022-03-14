<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

class MakeDomainException extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-exception';

    protected $description = 'Create a new domain-exception class';

    protected function getClassFqn(): string
    {
        return $this->fqnHelper()->exceptionFqn();
    }

    protected function getVariables(): array
    {
        $h = $this->fqnHelper();

        $exceptionFqn = $h->exceptionFqn();

        return [
            'namespace' => $h->getModelNamespace('exception', false),
            'className' => $h->baseClass($exceptionFqn),
        ];
    }
}
