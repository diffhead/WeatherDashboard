<?php namespace Modules\WebFrontend\Controller;

class Login extends WebFrontendController
{
    public function execute(array $params = []): bool
    {
        $this->setEntity(WebFrontendController::ENTITY_LOGIN);

        $this->view->assign([
            'fields'  => [
                [
                    'entity'      => 'login',
                    'placeholder' => 'Enter your login here',
                    'type'        => 'text',
                    'required'    => true
                ],
                [
                    'entity'      => 'password',
                    'placeholder' => 'Enter your password here',
                    'type'        => 'password',
                    'required'    => true
                ]
            ],
            'buttons' => [
                [
                    'entity' => 'login',
                    'title'  => 'Sign In'
                ],
                [
                    'entity' => 'register',
                    'title'  => 'Sign Up'
                ]
            ]
        ]);

        return true;
    }
}
