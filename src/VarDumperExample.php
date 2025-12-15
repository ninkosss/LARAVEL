<?php

namespace Inna\Task28;

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class VarDumperExample
{
    public function run(): void
    {
        echo "<h2>Приклад використання Symfony VarDumper</h2>";

        // Простий масив
        $array = ['window', 'linux', 'mac ios'];
        echo "<h3>Простий масив:</h3>";
        dump($array);

        // Асоціативний масив
        $assocArray = [
            'name' => 'Inna',
            'age' => 18,
            'city' => 'Kropivnitsky'
        ];
        echo "<h3>Асоціативний масив:</h3>";
        dump($assocArray);

        // Об'єкт
        $object = (object) [
            'title' => 'Студентка',
            'salary' => 0,
            'skills' => ['Python', 'C++', 'JavaScript']
        ];
        echo "<h3>Об'єкт:</h3>";
        dump($object);

    }
}
