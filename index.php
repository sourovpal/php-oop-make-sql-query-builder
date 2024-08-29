<?php

class Table
{
    public $query = 'CREATE TABLE ';
    public $attributes = [];
    public $name;

    public static function create($tableName, $callback = null)
    {
        $instance = new self();
        $instance->query .= $tableName;
        if ($callback) {
            $callback($instance);
        }
        return $instance->build();
    }

    public function id()
    {
        $this->attributes['id'] = 'id INT AUTO_INCREMENT PRIMARY KEY';
    }

    public function string($name, $length = 255)
    {
        $this->name = $name;
        $this->attributes[$name] = "$name VARCHAR($length)";
        return $this;
    }

    public function integer($name, $length = 11)
    {
        $this->name = $name;
        $this->attributes[$name] = "$name INT($length)";
        return $this;
    }

    public function float($name, $length = 11)
    {
        $this->name = $name;
        $this->attributes[$name] = "$name FLOAT($length)";
        return $this;
    }

    public function text($name)
    {
        $this->name = $name;
        $this->attributes[$name] = "$name TEXT";
        return $this;
    }

    public function timestamps()
    {
        $this->attributes['created_at'] = "created_at DATETIME NULL";
        $this->attributes['updated_at'] = "updated_at DATETIME NULL";
        return $this;
    }

    public function nullable()
    {
        $this->attributes[$this->name] .= ' NULL';
        return $this;
    }

    public function notNullable()
    {
        $this->attributes[$this->name] .= ' NOT NULL';
        return $this;
    }

    public function unique()
    {
        $this->attributes[$this->name] .= ' UNIQUE';
        return $this;
    }

    public function default($value)
    {
        $this->attributes[$this->name] .= " DEFAULT $value";
        return $this;
    }

    public function build()
    {
        $attributes = implode(', ', $this->attributes);
        $build = $this->query . ' (' . $attributes . ');';
        return $build;
    }
}

// Usage
$query1 = Table::create('users', function (Table $table) {
    $table->id();
    $table->string('email', 100)->unique()->notNullable();
    $table->string('username', 50)->unique()->notNullable();
    $table->string('password', 255)->notNullable();
    $table->text('bio')->nullable();
    $table->float('rating')->nullable();
    $table->timestamps();
});

$query2 = Table::create('admins', function (Table $table) {
    $table->id();
    $table->string('email', 100)->unique()->notNullable();
    $table->string('username', 50)->unique()->notNullable();
    $table->string('password', 255)->notNullable();
    $table->text('bio')->nullable();
    $table->float('rating')->nullable();
});

$query3 = Table::create('accounts', function (Table $table) {
    $table->id();
    $table->string('name', 100)->nullable();
    $table->string('email', 100)->unique()->notNullable();
    $table->string('username', 50)->unique()->notNullable();
    $table->string('password', 255)->notNullable();
    $table->integer('age', 3)->nullable();
    $table->integer('status', 3)->default(1);
    $table->text('bio')->nullable();
    $table->float('rating')->nullable();
});

echo '<pre>';
echo $query1;
echo "\n";
echo $query2;
echo "\n";
echo $query3;
