<?php namespace Modules\CacheHandler\Controller;

use Core\Controller;

use Lib\Memcached;

use Cli\ErrorCode;

use View\StdOut;

class Flush extends Controller
{
    public function init(): void
    {
        $this->view = new StdOut();
    }

    public function execute(array $params = []): bool
    {
        $memcached = new Memcached();

        $flush = $memcached->flush();

        if ( $flush === false ) {
            $this->view->setCode(ErrorCode::ERR_HAVE_ERRORS);
            $this->view->setMessage('Failed cache flushing');

            return false;
        }

        $this->view->setCode(0);
        $this->view->setMessage('Successfully cache flushing');

        return true;
    }
}
