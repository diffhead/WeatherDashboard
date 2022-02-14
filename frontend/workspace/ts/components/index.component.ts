import { Component } from '../interfaces/component.interface';

export class IndexComponent implements Component
{
    public init(): void
    {
    }

    public draw(): boolean
    {
        return true;
    }
}
