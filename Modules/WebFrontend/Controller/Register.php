<?php namespace Modules\WebFrontend\Controller;


class Register extends WebFrontendController
{
    public function execute(array $params = []): bool
    {
        $this->setEntity(WebFrontendController::ENTITY_REGISTER);

        $this->view->assign([
            'fields'  => [
                [
                    'entity'      => 'login',
                    'placeholder' => 'Enter your login here',
                    'type'        => 'text',
                    'required'    => true
                ],
                [
                    'entity'      => 'email',
                    'placeholder' => 'Enter your email here',
                    'type'        => 'text',
                    'required'    => true
                ],
                [
                    'entity'      => 'password',
                    'placeholder' => 'Enter your password here',
                    'type'        => 'password',
                    'required'    => true
                ],
                [
                    'entity'      => 'phone',
                    'placeholder' => 'Enter your phone here',
                    'type'        => 'tel',
                    'required'    => false
                ],
                [
                    'entity'      => 'name',
                    'placeholder' => 'Enter your first name here',
                    'type'        => 'text',
                    'required'    => false
                ],
                [
                    'entity'      => 'secondname',
                    'placeholder' => 'Enter your second name here',
                    'type'        => 'text',
                    'required'    => false
                ],
                [
                    'entity'      => 'thirdname',
                    'placeholder' => 'Enter your third name here',
                    'type'        => 'text',
                    'required'    => false
                ]
            ],
            'buttons' => [
                [
                    'entity' => 'register',
                    'title'  => 'Sign Up'
                ]
            ]
        ]);

        return true;
    }
}
