<?php

namespace lib\validator\rules;

use \lib\db\SqlBuilder;

class db extends \lib\core\Singleton
{
    public function exists($value, $options) {
        if (!$this->isValidStringValue($value)) {
            return TRUE;
        }

        option_require($options, 'connection');
        option_require($options, 'table');
        option_require($options, 'column');

        $connection = $this->app->scope->get($options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');

        }

        $sql = new SqlBuilder($this->app, $connection);

        $sql->select();
        $sql->from($options->table);
        $sql->where($options->column, '=', $value);
        $sql->limit(1);
        $sql->compile();

        return count($connection->execute($sql->query, $sql->params)) > 0;
    }

    // notexists (alternative could be missing or absend)
    public function notexists($value, $options) {
        if (!$this->isValidStringValue($value)) {
            return TRUE;
        }
        
        return !$this->exists($value, $options);
    }

    private function isValidStringValue($value) {
        return isset($value) && is_string($value) && strlen($value) > 0;
    }
}
