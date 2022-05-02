<?php

declare(strict_types=1);

namespace ThisIsDevelopment\LaravelBaseDev\Helpers;

class SQLiteGrammar extends \Illuminate\Database\Query\Grammars\SQLiteGrammar
{
    protected function compileJsonContains($column, $value)
    {
        [$field, $path] = $this->wrapJsonFieldAndPath($column);
        return 'json_contains(' . $field . ', ' . $value . $path . ')';
    }
}
