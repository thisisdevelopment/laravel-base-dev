<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

class MakeDomainRepositoryInterface extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-repository-interface';

    protected $description = 'Create a new domain-repository interface';

    protected $type = 'Repository';

    protected $hasMultiplePerModel = false;
}
