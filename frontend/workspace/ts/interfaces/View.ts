import { Model } from './Model';

export interface View 
{
    setElement(element: Element): void;
    getElement(): Element;

    setModel(model: Model): void;
    getModel(): Model;

    render(): boolean;
}
