<?php
namespace Framework\Env;

use Exception\EnvExeption;
use Framework\Traits\ArrayTrait;

class Env
{
    use ArrayTrait;

    public function setEnv(?string $pathToFile = null): void
    {
        $fileContent = $this->getEnvFileContent($pathToFile);
        $this->setDefinefromEnv($this->getEnvFileVars($fileContent));
    }

    private function getEnvFileContent(?string $pathToFile): string
    {
        if (!$pathToFile) {
            $pathToFile = $_SERVER['DOCUMENT_ROOT'] . '/.env';
        }
        $this->checkFileOrFail($pathToFile);
        return file_get_contents($pathToFile);
    }

    private function checkFileOrFail(string $pathToFile): bool
    {
        if (file_exists($pathToFile)) {
            return true;
        }
        throw new EnvExeption('File: ' . $pathToFile . ' not found.');
    }

    private function getEnvFileVars(string $fileContetnt): array
    {
        $envVars = explode("\n", $fileContetnt);
        $envVars = $this->deleteEmty($envVars);
        $envVarsArray = [];
        foreach ($envVars as $var) {
            $var = rtrim($var);
            $tempArray = explode('=', $var);
            $envVarsArray[$tempArray[0]] = $tempArray[1];
        }
        return $envVarsArray;
    }

    public function setDefinefromEnv(array $envVarsArray): void
    {
        foreach ($envVarsArray as $key => $value) {
            define($key, $value);
        }
    }
}