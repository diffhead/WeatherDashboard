import { View } from '../../classes/View';

import { Tabs } from '../Tabs';
import { Users } from './admin/Users';
import { Modules } from './admin/Modules';
import { Weather } from './admin/Weather';

import { DomService } from '../../services/DomService';

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

        this.modules = new Modules;
        this.modules.setElement(DomService.findOne('.module-items', this.element));
        this.modules.render();

        this.users = new Users;
        this.users.setElement(DomService.findOne('.users-items', this.element));
        this.users.render();

        this.weather = new Weather;
        this.weather.setElement(DomService.findOne('.weather-settings', this.element));
        this.weather.render();

        return true;
    }
}
