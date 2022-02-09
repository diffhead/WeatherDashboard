<?php namespace Views;

use Core\View;

use Services\StringService;

class Error extends View
{
    protected string $template = _APP_BASE_DIR_ . 'Templates/error.tpl';

    protected array  $params = [
        'code'    => 0,
        'message' => '',
        'entity'  => _APP_ENVIRONMENT_
    ];

    protected bool   $templateIsFile = true;

    public function __construct(int $code, string $message = 'Error')
    {
        parent::__construct();

        $this->assign([
            'code'    => $code,
            'message' => $message
        ]);
    }
}
