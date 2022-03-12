import { ModelData } from '../types/ModelData';
import { ModelDefinitions } from '../types/ModelDefinitions';

export interface Model 
{
    getId(): number;

    setData(data: ModelData): void;
    getData(): ModelData;

    assignData(data: ModelData): void;

    setDefinitions(definitions: ModelDefinitions): void;
}
