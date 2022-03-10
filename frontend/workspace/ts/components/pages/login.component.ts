import { Component } from '../../interfaces/component.interface';

import { SpinnerComponent } from '../spinner.component';

import { Request } from '../../types/request.type';
import { Response } from '../../types/response.type';

import { AuthService } from '../../services/auth.service';
import { DomService } from '../../services/dom.service';

export class LoginComponent implements Component
{
    private formSpinner: SpinnerComponent;

    private inputEntities: string[] = [
        'login', 'password'
    ];

    private inputFields: HTMLInputElement[] = [];
    private $loginBtn: HTMLButtonElement;

    public init(): void
    {
        this.formSpinner = new SpinnerComponent('.auth-form .auth-form-button');
        this.formSpinner.init();

        for ( let entity of this.inputEntities ) {
            this.inputFields.push(
                (<HTMLInputElement>DomService.findOne(`.auth-form input[data-entity="${entity}"]`))
            );
        }

        this.$loginBtn = (<HTMLInputElement>DomService.findOne('.auth-form button[data-entity="login"]'));
        this.$loginBtn.addEventListener('click', () => this.actionLogin());
    }

    private async actionLogin(): Promise<void>
    {
        let loginData: Request = {};
        let foundInvalidFields: boolean = false;
        let noEmptyValidationRegExp: RegExp = new RegExp('^\\w{0,}[\\w\\d]{1,}$', 'gm');

        for ( let i = 0; i < this.inputEntities.length; i++ ) {
            let entity: string = this.inputEntities[i];
            let $input: HTMLInputElement = this.inputFields[i];

            if ( $input.value.match(noEmptyValidationRegExp) === null ) {
                foundInvalidFields = true;

                $input.classList.add('invalid');
            } else {
                $input.classList.remove('invalid');
            }

            loginData[entity] = $input.value;
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

    public draw(): boolean
    {
        return true;
    }
}
