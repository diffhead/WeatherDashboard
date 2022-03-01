import { Component } from '../../interfaces/component.interface';

import { SpinnerComponent } from '../spinner.component';
import { InputComponent } from '../input.component';
import { ButtonComponent } from '../button.component';

import { Request } from '../../types/request.type';
import { Response } from '../../types/response.type';

import { AuthService } from '../../services/auth.service';

export class RegisterComponent implements Component
{
    private formSpinner: SpinnerComponent;

    private inputEntities: string[] = [
        'login', 'password', 'email',
        'name', 'secondname', 'thirdname',
        'phone'
    ];

    private inputFields: InputComponent[] = [];
    private registerButton: ButtonComponent;

    public init(): void
    {
        this.formSpinner = new SpinnerComponent('.auth-form .auth-form-button');
        this.formSpinner.init();

        for ( let entity of this.inputEntities ) {
            this.inputFields.push(new InputComponent(`.auth-form input[data-entity="${entity}"]`));
        }

        this.registerButton = new ButtonComponent('.auth-form button[data-entity="register"]');
        this.registerButton.onClick(() => this.actionRegister.call(this));
    }

    private async actionRegister(): Promise<void>
    {
        let loginData: Request = {};
        let foundInvalidFields: boolean = false;
        let noEmptyValidationRegExp: RegExp = new RegExp('^[\\w\\d\\W]{1,}$', 'gm');

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

        let loginResponse: Response = await AuthService.registerRequest(loginData);

        if ( loginResponse.status ) {
            window.application.sendNotify('Successfully registration. You will be redirected to sign in page until 3 seconds')

            setTimeout(() => {
                window.application.getPage('/login');
            }, 3000);
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
