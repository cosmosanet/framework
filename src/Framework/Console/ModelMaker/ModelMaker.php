<?php

namespace Framework\Console\ModelMaker;

use Framework\Console\Console;

class ModelMaker extends Console
{
    private string $pathToFile = 'app/Models/';
    private string $filename;
    private string $fillable = ';';
    protected string $content;
    private string $tableName = 'DefaultTable';
    protected array $operations = [
        '-t' => 'setTableName',
        '--tablename' => 'setTableName',
        '-f' => 'setFillable',
        '--fillable' => 'setFillable',
    ];

    protected function buildModel(): void
    {
        $this->content = "<?php
namespace App\Models;

use Framework\Database\Model;

class " . $this->value . " extends Model
{
    protected string \$table = '" . $this->tableName . "';

    protected \$fillable" . $this->fillable . "

}";
        $this->filename = $this->value . ".php";
    }

    protected function setTableName(string $name): void
    {
        $this->tableName = $name;
    }

    protected function setFillable(string $fillable): void
    {
        $dumpText = " = [" . PHP_EOL;
        $fillablArray = explode(',', $fillable);
        foreach ($fillablArray as $item) {
            $dumpText .= str_repeat("\t", 4) . "'" . $item . "'," . PHP_EOL;
        }
        $this->fillable = $dumpText . str_repeat("\t", 2) . "];";
    }

    protected function execCommand(): void
    {
        $this->buildModel();
        $filename = $_SERVER['DOCUMENT_ROOT'] . $this->pathToFile . $this->filename;

        if (file_put_contents($filename, $this->content) !== false) {
            echo "File " . $filename . " created.";
        } else {
            echo "File: " . $filename . "not created";
        }
    }
}
