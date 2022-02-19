import { Component } from '../../interfaces/component.interface';

import { SpinnerComponent } from '../spinner.component';
import { InputComponent } from '../input.component';
import { ButtonComponent } from '../button.component';

import { Request } from '../../types/request.type';
import { Response } from '../../types/response.type';

import { AuthService } from '../../services/auth.service';

export class LoginComponent implements Component
{
    private formSpinner: SpinnerComponent;

    private inputEntities: string[] = [
        'login', 'password'
    ];

    private inputFields: InputComponent[] = [];
    private loginButton: ButtonComponent;

    public init(): void
    {
        this.formSpinner = new SpinnerComponent('.login-form .login-form-button');
        this.formSpinner.init();

        for ( let entity of this.inputEntities ) {
            this.inputFields.push(new InputComponent(`.login-form input[data-entity="${entity}"]`));
        }

        this.loginButton = new ButtonComponent('.login-form button[data-entity="login"]');
        this.loginButton.onClick(() => this.actionLogin.call(this));
    }

    private async actionLogin(): Promise<void>
    {
        let loginData: Request = {};
        let foundInvalidFields: boolean = false;
        let noEmptyValidationRegExp: RegExp = new RegExp('^\\w{0,}[\\w\\d]{1,}$', 'gm');

        for ( let i = 0; i < this.inputEntities.length; i++ ) {
            let entity: string = this.inputEntities[i];
            let input: InputComponent = this.inputFields[i];

            if ( input.validate(noEmptyValidationRegExp) === false ) {
                foundInvalidFields = true;
            }

            loginData[entity] = input.getValue();
        }

        if ( foundInvalidFields ) {
            return window.application.sendNotify('Invalid field value');
        }

        this.formSpinner.draw();

        let loginResponse: Response = await AuthService.loginRequest(loginData);

        this.formSpinner.hide();

        if ( loginResponse.status ) {
            window.application.getHome();
        } else {
            window.application.sendNotify(loginResponse.message, 'Error', true);
        }
    }

    private getRegisterPage(): void
    {
        document.location = '/register';
    }

    public draw(): boolean
    {
        return true;
    }
}
