<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeDomainAction extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-action';

    protected $description = 'Create a new domain-action class';

    protected function getStubName(): string
    {
        return match ($this->argument('type')) {
            'create' => 'stubs/domain-create-action.stub',
            'delete' => 'stubs/domain-delete-action.stub',

                // catch all. This template is problably the most suitable
                // for _any_ action that will be performed on the model
            default => 'stubs/domain-update-action.stub',
        };
    }

    protected function getClassFqn(): string
    {
        return $this->fqnHelper()->actionFqn($this->argument('type'));
    }

    protected function getVariables(): array
    {
        $h = $this->fqnHelper();

        $actionFqn = $h->actionFqn($this->argument('type'));

        $preEventFqn = $h->eventFqn(match ($this->argument('type')) {
            'create' => 'creating',
            'delete' => 'deleting',
            default => 'updating',
        });

        $postEventFqn = $h->eventFqn(match ($this->argument('type')) {
            'create' => 'created',
            'delete' => 'deleted',
            default => 'updated',
        });

        $exceptionFqn = $h->exceptionFqn();
        $modelFqn = $h->modelFqn();
        $repositoryInterfaceFqn = $h->repositoryInterfaceFqn();

        $context = [
            'namespace' => $h->getModelNamespace('action', true),
            'className' => $h->baseClass($actionFqn),

            'preEventFqn' => $preEventFqn,
            'preEventClass' => $h->baseClass($preEventFqn),
            'postEventFqn' => $postEventFqn,
            'postEventClass' => $h->baseClass($postEventFqn),

            'exceptionFqn' => $exceptionFqn,
            'exceptionClass' => $h->baseClass($exceptionFqn),
            'modelFqn' => $modelFqn,
            'modelClass' => $h->baseClass($modelFqn),
            'repositoryInterfaceFqn' => $repositoryInterfaceFqn,
            'repositoryInterface' => $h->baseClass($repositoryInterfaceFqn),
            'repositoryAction' => Str::camel($this->argument('type')),
        ];

        if ('delete' !== $this->argument('type')) {
            $dtoFqn = $h->dtoFqn($this->argument('type'));
            $context += [
                'dtoFqn' => $dtoFqn,
                'dtoClass' => $h->baseClass($dtoFqn)
            ];
        }

        return $context;
    }

    protected function getArguments(): array
    {
        return [
            ...parent::getArguments(),
            ['type', InputArgument::REQUIRED, 'the type of action to generate']
        ];
    }
}
