import { Model } from '../classes/Model';

import { Response } from '../types/Response';

import { ModelDefinitions } from '../types/ModelDefinitions';

import { AjaxService } from '../services/AjaxService';

export class City extends Model
{
    protected modelDefinitions: ModelDefinitions = {
        'id': 'number',
        'title': 'string',
        'latitude': 'number',
        'longitude': 'number',
        'country': 'number',
        'active': 'number'
    };

    public constructor()
    {
        super();
    }

    public getTitle(): string
    {
        return this.getData().title as string;
    }

    public getLatitude(): number
    {
        return this.getData().latitude as number;
    }

    public getLongitude(): number
    {
        return this.getData().longitude as number;
    }

    public getCountryId(): number
    {
        return this.getData().country as number;
    }

    public isActive(): boolean
    {
        return !!this.getData().active;
    }

    public async save(): Promise<Response>
    {
        return await AjaxService.request('/weather/city', 'POST', this.getData());
    }
}
