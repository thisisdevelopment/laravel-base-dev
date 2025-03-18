<?php

declare(strict_types=1);

namespace ThisIsDevelopment\LaravelBaseDev\Helpers;

class SQLiteConnection extends \Illuminate\Database\SQLiteConnection
{
    public function addJsonContainsFunction()
    {
        $this->getPdo()->sqliteCreateFunction('JSON_CONTAINS', function ($json, $val, $path = null) {
            $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
            // trim double quotes from around the value to match MySQL behaviour
            $val = trim($val, '"');
            // this will work for a single dimension JSON value, if more dimensions
            // something more sophisticated will be required
            // that is left as an exercise for the reader
            if ($path) {
                return $array[$path] == $val;
            }

            return in_array($val, $array, true);
        });
    }

    protected function getDefaultQueryGrammar()
    {
        return new SQLiteGrammar($this)
            ->setTablePrefix($this->tablePrefix); // here comes our custom Grammar object
    }
}
