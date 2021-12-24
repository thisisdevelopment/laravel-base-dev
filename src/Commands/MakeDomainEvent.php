<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

class MakeDomainEvent extends AbstractDomainGeneratorCommand
{
    protected $name = 'make:domain-event';

    protected $description = 'Create a new domain-event class';

    protected $type = 'Event';
}
