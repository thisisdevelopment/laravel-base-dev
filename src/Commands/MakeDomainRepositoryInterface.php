<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

class MakeDomainRepositoryInterface extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-repository-interface';

    protected $description = 'Create a new domain-repository interface';

    protected function getClassFqn(): string
    {
        return $this->fqnHelper()->repositoryInterfaceFqn();
    }

    protected function getVariables(): array
    {
        $h = $this->fqnHelper();

        $exceptionFqn = $h->exceptionFqn();
        $modelFqn = $h->modelFqn();
        $repositoryInterfaceFqn = $h->repositoryInterfaceFqn();
        $createDtoFqn = $h->dtoFqn('create');
        $updateDtoFqn = $h->dtoFqn('update');

        return [
            'namespace' => $h->getModelNamespace('repository', false),
            'className' => $h->baseClass($repositoryInterfaceFqn),

            'exceptionFqn' => $exceptionFqn,
            'exceptionClass' => $h->baseClass($exceptionFqn),

            'modelFqn' => $modelFqn,
            'modelClass' => $h->baseClass($modelFqn),

            'createDtoFqn' => $createDtoFqn,
            'createDtoClass' => $h->baseClass($createDtoFqn),
            'updateDtoFqn' => $updateDtoFqn,
            'updateDtoClass' => $h->baseClass($updateDtoFqn)
        ];
    }
}
