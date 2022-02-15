import { Component } from '../interfaces/component.interface';

import { ErrorComponent } from '../components/error.component';
import { IndexComponent } from '../components/index.component';
import { LoginComponent } from '../components/login.component';

export class ComponentsRegistry
{
    private static components: { [key: string]: any } = {
        ErrorComponent, IndexComponent, LoginComponent
    };

    public static getComponent(component: string): Component|null
    {
        let _component: Component;

        if ( ComponentsRegistry.components.hasOwnProperty(component) === false ) {
            return null;
        }

        return new ComponentsRegistry.components[component].prototype.constructor();
    }
}
