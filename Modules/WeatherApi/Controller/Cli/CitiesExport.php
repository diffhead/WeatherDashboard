<?php namespace Modules\WeatherApi\Controller\Cli;

use Core\Controller;

use Views\StdOut;

use Cli\ErrorCode;

use Modules\WeatherApi\Core\WeatherCityExporter;

class CitiesExport extends Controller
{
    public function init(): void
    {
        $this->view = new StdOut();
    }

    public function execute(array $params = []): bool
    {
        $exportFilePath = _MODULES_DIR_ . 'WeatherApi/worldcities.csv';

        $exporter = new WeatherCityExporter($exportFilePath);
        $exporter->export();

        if ( $exporter->doSomethingExported() === false ) {
            $this->view->setCode(ErrorCode::ERR_HAVE_ERRORS);
            $this->view->setMessage('Nothing exported');

            return false;
        }

        $this->view->setCode(0);
        $this->view->setMessage('Everything exported');

        return true;
    }
}
