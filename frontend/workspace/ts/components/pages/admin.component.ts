import { Component } from '../../interfaces/component.interface';

import { TabsComponent } from '../tabs.component';

export class AdminComponent implements Component
{
    private tabs: TabsComponent;

    public init(): void
    {
        this.tabs = new TabsComponent('.tabbed-content');
    }

    public draw(): boolean
    {
        return true;
    }
}
