import { Model } from '../classes/Model';

import { ModelData } from '../types/ModelData';
import { ModelDefinitions } from '../types/ModelDefinitions';

export class SelectOption extends Model
{
    protected modelDefinitions: ModelDefinitions = {
        'id': 'number',
        'title': 'string',
        'value': 'string',
        'selected': 'number'
    };

    public constructor(id: number, title: string, value: string = '', selected: number = 0)
    {
        super();

        this.setData({
            id, title, value, selected
        });
    }

    public getTitle(): string
    {
        return this.getData().title as string;
    }

    public getValue(): string
    {
        return this.getData().value as string;
    }

    public isSelected(): boolean
    {
        return !!this.getData().selected;
    }

    public selected(value: boolean): void
    {
        this.assignData({ selected: Number(value) });
    }
}
