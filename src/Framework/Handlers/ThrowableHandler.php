<?php
namespace Framework\Handlers;

use Throwable;

class ThrowableHandler
{
    public function ThrowableHandler()
    {
        try {
            $this->loadBootstrap();
            //@todo как правельнее загружать
        } catch (Throwable $th) {
            if (DEV_MODE == 'true') {
                $throwableType = $this->getThrowableType($th);
                extract($this->getThrowableMassages($th));
                require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Framework/Helpers/PrintHelper.php';
                require_once $_SERVER['DOCUMENT_ROOT'] . '/ExeptionPage.php';
            }
            if (DEV_MODE == 'false') {
                if ($this->getHttpStatusIfExist($th)) {
                    http_response_code($this->getHttpStatusIfExist($th));
                } else {
                    http_response_code(500);
                }
            }
        }
    }
    private function getHttpStatusIfExist(Throwable $th): mixed
    {
        if (method_exists($th, 'getHttpStatus')) {
            return $th->getHttpStatus();
        } else return false;
    }
    private function getThrowableType(Throwable $th): string
    {
        return str_replace('Exception\\', '', get_class($th));
    }
    private function loadBootstrap(): void
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/bootstrap.php';
    }
    private function getThrowableMassages(Throwable $th, array $massages = []): array
    {
        $massages['exceptionMassage'] = $th->getMessage();
        $massages['exceptionFile'] = $th->getFile();
        $massages['exceptionLine'] = $th->getLine();
        $massages['exceptionTrace'] = $th->getTrace();
        return $massages;
    }
}
