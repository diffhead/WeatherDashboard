import { Request } from '../../types/Request';
import { Response } from '../../types/Response';

import { ValidationResult } from '../../types/ValidationResult';
import { ValidationDescription } from '../../types/ValidationDescription';

import { View } from '../../classes/View';

import { Spinner } from '../Spinner';

import { Login as LoginModel } from '../../models/Login';

import { DomService } from '../../services/DomService';
import { AjaxService } from '../../services/AjaxService';

export class Login extends View
{
    private spinner: Spinner;
    private inputs: NodeList;
    private button: HTMLButtonElement;

    private setOtherElements(): void
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

        this.button = DomService.findOne('button[data-entity]', this.element) as HTMLButtonElement;
        this.button.addEventListener('click', async () => {
            let loginRequest: Request = this.getModel().getData();
            let loginResponse: Response = { status: false };
            let validationDescription: ValidationDescription = (this.getModel() as LoginModel).validate();
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
                this.spinner.show();

                loginResponse = await AjaxService.request('/api/login', 'POST', loginRequest);

                this.spinner.hide();

                if ( loginResponse.status ) {
                    window.application.showNotification(
                        'Success', 'You are successfully logged in and will be redirected until 3 seconds'
                    );

                    setTimeout(() => window.application.getHome(), 3000);
                } else {
                    window.application.showNotification(
                        'Failed', loginResponse.message as string || 'Failed authorization'
                    );
                }
            }
        });

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
        this.setModel(new LoginModel());
        this.setOtherElements();

        return true;
    }
}
