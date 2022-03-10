import { Component } from '../../interfaces/component.interface';

import { TabsComponent } from '../tabs.component';

import { ModulesTabComponent } from './admin/modules-tab.component';

export class AdminComponent implements Component
{
    private tabs: TabsComponent;

    private modulesTabContent: ModulesTabComponent;

    public init(): void
    {
        this.tabs = new TabsComponent('.tabbed-content');

        this.modulesTabContent = new ModulesTabComponent();
        this.modulesTabContent.init();
    }

    public draw(): boolean
    {
        return true;
    }
}
