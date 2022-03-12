import { View } from '../../classes/View';

import { Tabs } from '../Tabs';
import { Users } from './admin/Users';
import { Modules } from './admin/Modules';
import { Weather } from './admin/Weather';

import { DomService } from '../../services/DomService';
import { AjaxService } from '../../services/AjaxService';

export class Admin extends View
{
    private tabs: Tabs;

    private users: Users;
    private modules: Modules;
    private weather: Weather;

    public render(): boolean
    {
        if ( this.element !== undefined ) {
            return false;
        }

        this.setElement(DomService.findOne('.tabbed-content'));

        this.tabs = new Tabs;
        this.tabs.setElement(this.element);
        this.tabs.render();

        return true;
    }
}
