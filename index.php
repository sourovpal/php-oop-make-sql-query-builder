<?php
class Table
{
    public static $query = 'CREATE TABLE ';
    public static $attributes = [];
    public static $buildQuery;
    public static $name;

    public static function create($tableName, $callback = null)
    {
        self::$query .= $tableName;
        if ($callback) {
            $callback(new self);
        }
    }

    public function id()
    {
        self::$attributes['id'] = 'id INT AUTO_INCREMENT PRIMARY KEY';
    }

    public function string($name, $length = 255)
    {
        self::$name = $name;
        self::$attributes[$name] = "$name VARCHAR($length)";
        return $this;
    }

    public function integer($name, $length=11)
    {
        self::$name = $name;
        self::$attributes[$name] = "$name INT($length)";
        return $this;
    }

    public function float($name, $length=11)
    {
        self::$name = $name;
        self::$attributes[$name] = "$name FLOAT($length)";
        return $this;
    }

    public function text($name)
    {
        self::$name = $name;
        self::$attributes[$name] = "$name TEXT";
        return $this;
    }

    public function nullable()
    {
        self::$attributes[self::$name] .= ' NULL';
        return $this;
    }

    public function notNullable()
    {
        self::$attributes[self::$name] .= ' NOT NULL';
        return $this;
    }

    public function unique()
    {
        self::$attributes[self::$name] .= ' UNIQUE';
        return $this;
    }

    public static function build()
    {
        print_r(self::$attributes);
        $attributes = implode(', ', self::$attributes);
        $build = self::$query . ' (' . $attributes . ');';
        return $build;
    }
}


Table::create('users', function($table) {
    $table->id();
    $table->string('email', 100)->unique()->notNullable();
    $table->string('username', 50)->unique()->notNullable();
    $table->string('password', 255)->notNullable();
    $table->text('bio')->nullable();
    $table->float('rating')->nullable();
});

$sql = Table::build();
echo $sql;
