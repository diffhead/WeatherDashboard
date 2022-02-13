<?php namespace Views;

use Core\View;

use Services\StringService;

class Error extends View
{
    protected string $template = 'templates/error.tpl';

    protected array  $params = [
        'code'    => 0,
        'message' => '',
        'entity'  => _APP_ENVIRONMENT_
    ];

    protected bool   $templateIsFile = true;

    public function __construct(int $code, string $message = 'Error', string $extMessage = '')
    {
        parent::__construct();

        $this->assign([
            'code'       => $code,
            'message'    => $message,
            'extMessage' => $extMessage
        ]);
    }
}
