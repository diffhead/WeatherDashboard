import { View } from '../../../classes/View';

import { Request } from '../../../types/Request';
import { Response } from '../../../types/Response';

import { DomService } from '../../../services/DomService';
import { AjaxService } from '../../../services/AjaxService';

export class Weather extends View
{
    private apikeyInput: HTMLInputElement;
    private apiuriInput: HTMLInputElement;

    public render(): boolean
    {
        if ( this.element === undefined ) {
            throw new Error('Weather view element wasnt initialized');
        }

        this.apikeyInput = DomService.findOne('.weather-settings__api--key-input', this.element) as HTMLInputElement;
        this.apiuriInput = DomService.findOne('.weather-settings__api--uri-input', this.element) as HTMLInputElement;

        this.bindActions();

        return true;
    }

    private bindActions(): void
    {
        let apiSaveButton: HTMLButtonElement = DomService.findOne('.weather-settings__api--save-button', this.element) as HTMLButtonElement;

        apiSaveButton.addEventListener('click', async () => {
            let request: Request = {
                'api': {
                    key: this.apikeyInput.value,
                    uri: this.apiuriInput.value
                }
            };

            let response: Response = await AjaxService.request('/weather/api/save', 'POST', request);

            if ( response.status === true ) {
                window.application.showNotification('Weather API', 'Saving settings successfully');
            } else {
                window.application.showNotification('Weather API', 'Saving settings failed', true);
            }
        });
    }
}
