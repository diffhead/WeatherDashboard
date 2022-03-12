import { Model as ModelInterface } from '../interfaces/Model';
import { View as ViewInterface } from '../interfaces/View';

import { Model } from './Model';

export class View implements ViewInterface
{
    protected model: ModelInterface;
    protected element: Element;

    public setElement(element: Element): void
    {
        this.element = element;
    }

    public getElement(): Element
    {
        if ( this.element === undefined ) {
            this.setElement(new Element);
        }

        return this.element;
    }

    public setModel(model: ModelInterface): void
    {
        this.model = model;
    }

    public getModel(): ModelInterface
    {
        if ( this.model === undefined ) {
            this.setModel(new Model);
        }

        return this.model;
    }

    public render(): boolean
    {
        return true;
    }
}
