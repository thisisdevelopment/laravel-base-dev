<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

use Illuminate\Support\Str;

class MakeDomainAbstractEvent extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-abstract-event';

    protected $description = 'Create a new domain-event class';

    protected function getClassFqn(): string
    {
        return $this->fqnHelper()->fqn('event', Str::studly("abstract_{$this->fqnHelper()->getModel()}_event"), true);
    }

    protected function getVariables(): array
    {
        $h = $this->fqnHelper();

        $eventFqn = $this->getClassFqn();

        return [
            'namespace' => $h->getModelNamespace('event', true),
            'className' => $h->baseClass($eventFqn),
        ];
    }
}
