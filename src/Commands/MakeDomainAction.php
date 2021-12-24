<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

class MakeDomainAction extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-action';

    protected $description = 'Create a new domain-action class';

    protected $type = 'Action';
}
