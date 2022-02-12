<?php namespace Modules\AuthModule\Controller;

use Core\Controller;

use Views\Json as JsonView;

use Web\HttpHeader;
use Web\HttpCookie;

class Logout extends Controller
{
    public function init(): void
    {
        $this->view = new JsonView([ 'status' => true ]);
    }
    
    public function execute(array $params = []): bool
    {
        $resetSessionCookie = new HttpCookie('stoken', 'resettoken');
        $redirectToIndexHeader = new HttpHeader('Location', '/');
        
        HttpService::setResponseCode(205);
        HttpService::setResponseCookie($resetSessionCookie);
        HttpService::setResponseHeader($redirectToIndexHeader);
        
        return true;
    }
}
