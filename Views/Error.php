<?php namespace Views;

use Core\View;

use Services\StringService;

class Error extends View
{
    protected string $template = _APP_BASE_DIR_ . 'Templates/error.tpl';
    protected array  $params = [
        'code' => 0,
        'message' => ''
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

    public function assign(array $params): void
    {
        if ( isset($params['code']) ) {
            $this->params['code'] = $params['code'];
        }

        if ( isset($params['message']) ) {
            $this->params['message'] = $params['message'];
        }
    }

    public function render(): string
    {
        $template = $this->template;

        $template = StringService::strReplace($template, '{{ code }}', $this->params['code']);
        $template = StringService::strReplace($template, '{{ message }}', $this->params['message']);

        return $template;
    }
}
