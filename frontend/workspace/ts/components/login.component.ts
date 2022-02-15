import { Component } from '../interfaces/component.interface';

import { SpinnerComponent } from './spinner.component';
import { InputComponent } from './input.component';
import { ButtonComponent } from './button.component';

import { LoginRequest } from '../types/login-request.type';
import { Response } from '../types/response.type';

import { LoginService } from '../services/login.service';

export class LoginComponent implements Component
{
    private formSpinner: SpinnerComponent;

    private loginInput: InputComponent;
    private passwordInput: InputComponent;

    private buttonLogin: ButtonComponent;
    private buttonRegister: ButtonComponent;

    public init(): void
    {
        this.formSpinner = new SpinnerComponent('.login-form .login-form-button');
        this.formSpinner.init();

        this.loginInput = new InputComponent('.login-form input[data-entity="login"]');
        this.passwordInput = new InputComponent('.login-form input[data-entity="password"]');
        this.buttonLogin = new ButtonComponent('.login-form button[data-entity="login"]');
        this.buttonRegister = new ButtonComponent('.login-form button[data-entity="register"]');

        this.buttonLogin.onClick(() => this.actionLogin.apply(this));
        this.buttonRegister.onClick(() => this.getRegisterPage.apply(this));
    }

    private async actionLogin(): Promise<void>
    {
        let loginData: LoginRequest = { 
            login: this.loginInput.getValue(), 
            password: this.passwordInput.getValue() 
        };

        let loginResponse: Response = await LoginService.loginRequest(loginData);

        if ( loginResponse.status ) {
            window.application.getHome();
        } else {
            console.error(loginResponse);
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
