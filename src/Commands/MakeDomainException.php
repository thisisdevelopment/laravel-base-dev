<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

class MakeDomainException extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-exception';

    protected $description = 'Create a new domain-exception class';

    protected $type = 'Exception';

    protected $hasMultiplePerModel = false;
}
