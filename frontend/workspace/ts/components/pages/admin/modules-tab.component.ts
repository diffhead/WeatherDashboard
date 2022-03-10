import { Component } from '../../../interfaces/component.interface';

export class ModulesTabComponent implements Component 
{
    private inited: boolean = false;

    public init(): void
    {
        if ( this.inited === false ) {
        }
    }

    public draw(): boolean
    {
        return true;
    }

    public moduleCreation(): boolean
    {
        return true;
    }
}
