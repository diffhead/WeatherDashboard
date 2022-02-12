<?php namespace Web\Controller;

use Core\Controller;

use Views\Error as ErrorView;

use Web\HttpHeader;

use Services\HttpService;

class Error extends Controller
{
    private int    $code;
    private string $message;

    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public function init(): void
    {
        $this->view = new ErrorView($this->code, $this->message);
    }

    public function execute(array $params = []): bool
    {
        HttpService::setResponseCode($this->code);

        return true;
    }
}
