<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeDomainEvent extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-event';

    protected $description = 'Create a new domain-event class';

    protected function getStubName(): string
    {
        return match ($this->argument('type')) {
            'creating' => 'stubs/domain-creating-event.stub',
            'created' => 'stubs/domain-created-event.stub',
            'deleting' => 'stubs/domain-deleting-event.stub',
            'deleted' => 'stubs/domain-deleted-event.stub',

            // catch all. This template is problably the most suitable
            // for _any_ update event that will be performed on the model
            default => 'stubs/domain-update-event.stub',
        };
    }

    protected function getClassFqn(): string
    {
        return $this->fqnHelper()->eventFqn($this->argument('type'));
    }

    protected function getVariables(): array
    {
        $h = $this->fqnHelper();

        $eventFqn = $h->eventFqn($this->argument('type'));
        $parentFqn = $h->fqn(
            'events',
            Str::studly("abstract_{$h->getModel()}_event"),
            hasMultiplePerModel: true
        );

        $modelFqn = $h->modelFqn();

        if (0 === preg_match('/(?:ed|ing)$/i', $this->argument('type'))) {
            $this->warn(<<<TXT
                Uncommon event provided (`{$this->argument('type')}` does not end with `ing` or `ed`)
                which could lead to invalid Dto references. Please verify generated code!
            TXT);
        }

        $dtoFqn = $h->dtoFqn(preg_replace(
            '/(?:ed|ing)$/i',
            'e',
            $this->argument('type')
        ));

        return [
            'namespace' => $h->getModelNamespace('event', true),
            'className' => $h->baseClass($eventFqn),
            'extends' => $h->baseClass($parentFqn),
            'modelFqn' => $modelFqn,
            'modelClass' => $h->baseClass($modelFqn),
            'modelVar' => $h->asVariable($modelFqn),
            'dtoFqn' => $dtoFqn,
            'dtoClass' => $h->baseClass($dtoFqn),
            'dtoVar' => $h->asVariable($dtoFqn),
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
