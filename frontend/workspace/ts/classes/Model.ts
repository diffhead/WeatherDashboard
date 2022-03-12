import { ModelData } from '../types/ModelData';
import { ModelDefinitions } from '../types/ModelDefinitions';

import { Model as ModelInterface } from '../interfaces/Model';

export class Model implements ModelInterface
{
    protected modelData: ModelData = { id: 0 };
    protected modelDefinitions: ModelDefinitions = {};

    public getId(): number
    {
        return this.modelData.id;
    }

    public setData(data: ModelData): void
    {
        for ( let prop in data ) {
            let value: string|number|object|boolean = data[prop];

            if ( this.modelDefinitions.hasOwnProperty(prop) ) {
                switch ( this.modelDefinitions[prop] ) {
                    case 'string':
                        value = String(value); break;

                    case 'bool':
                        value = Boolean(value); break;

                    case 'number':
                        value = Number(value); break;
                }
            }

            data[prop] = value;
        }

        this.modelData = data;
    }

    public assignData(data: ModelData): void
    {
        let currentData: ModelData = this.getData();
        let assignedData: ModelData = Object.assign(currentData, data);

        this.setData(assignedData);
    }

    public getData(): ModelData
    {
        return this.modelData;
    }

    public setDefinitions(definitions: ModelDefinitions): void
    {
        this.modelDefinitions = definitions;
    }
}
