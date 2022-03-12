import { Request } from '../../types/Request';
import { Response } from '../../types/Response';

import { ValidationResult } from '../../types/ValidationResult';
import { ValidationDescription } from '../../types/ValidationDescription';

import { View } from '../../classes/View';

import { Spinner } from '../Spinner';

import { Auth as AuthModel } from '../../models/Auth';

import { DomService } from '../../services/DomService';
import { AjaxService } from '../../services/AjaxService';

export class Auth extends View
{
    private spinner: Spinner;
    private inputs: NodeList;
    private button: HTMLButtonElement;

    private setOtherElements(): void
    {
        this.setInputs();
        this.setButton();
        this.setSpinner();
    }

    private setInputs(): void
    {
        this.inputs = DomService.findAll('input[data-entity]', this.element);
        this.inputs.forEach(element => {
            element.addEventListener('change', () => {
                let entity: string = (element as HTMLInputElement).getAttribute('data-entity');
                let value: string = (element as HTMLInputElement).value;

                this.getModel().assignData({ [entity]: value });

                if ( (element as HTMLInputElement).classList.contains('invalid') ) {
                    (element as HTMLInputElement).classList.remove('invalid');
                }
            });
        });
    }

    private setButton(): void
    {
        this.button = DomService.findOne('button[data-entity]', this.element) as HTMLButtonElement;
        this.button.addEventListener('click', () => {
            let request: Request = this.getModel().getData();

            let validationDescription: ValidationDescription = (this.getModel() as AuthModel).validate();
            let validationStatus: boolean = validationDescription[0];
            let validationResult: ValidationResult = validationDescription[1];
            let validationInvalid: string[] = [];

            if ( validationStatus === false ) {
                for ( let field in validationResult ) {
                    if ( validationResult[field].status === false ) {
                        validationInvalid.push(field);

                        window.application.showNotification(
                            'Validation error', validationResult[field].message, true
                        );
                    }
                }

                this.setupInvalidFields(validationInvalid);
            } else {
                this.handleAuthRequestSending(request);
            }
        });
    }

    private async handleAuthRequestSending(request: Request): Promise<void>
    {
        let response: Response;
        let requestUri: string;
        let onSuccessMessage: string;
        let onSuccessRedirectUri: string;

        switch ( document.location.pathname ) {
            case '/login':
                    requestUri = '/api/login';

                    onSuccessMessage = 'You are successfully logged in and will be redirected until 3 seconds';
                    onSuccessRedirectUri = '/';
                break;

            case '/register':
                    requestUri = '/api/register';

                    onSuccessMessage = 'You are successfully registered and will be redirected into login form until 3 seconds';
                    onSuccessRedirectUri = '/login';

                break;

            case '/reset':
                    requestUri: '/api/reset';

                    onSuccessMessage = 'We sent reset password instructions to your email. Follow it';
                    onSuccessRedirectUri = '/login';

                break;

        }

        this.spinner.show();

        response = await AjaxService.request(requestUri, 'POST', request);

        this.spinner.hide();

        if ( response.status ) {
            window.application.showNotification('Success', onSuccessMessage);

            setTimeout(() => window.application.getPage(onSuccessRedirectUri), 3000);
        } else {
            window.application.showNotification(
                'Failed', response.message as string || 'Failed auth action', true
            );
        }
    }

    private setSpinner(): void
    {
        this.spinner = new Spinner(
            DomService.findOne('.simple-spinner', this.element) as HTMLDivElement
        );
    }

    private setupInvalidFields(fields: string[]): void
    {
        this.inputs.forEach(element => {
            if ( fields.includes((element as HTMLInputElement).getAttribute('data-entity')) ) {
                (element as HTMLInputElement).classList.add('invalid');
            }
        })
    }

    public render(): boolean
    {
        if ( this.element !== undefined ) {
            return false;
        }

        this.setElement(DomService.findOne('.auth-form'));
        this.setModel(new AuthModel(document.location.pathname.replace('/', '')));
        this.setOtherElements();

        return true;
    }
}
