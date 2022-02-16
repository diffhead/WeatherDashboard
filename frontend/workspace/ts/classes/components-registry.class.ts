import { Component } from '../interfaces/component.interface';

import { ErrorComponent } from '../components/pages/error.component';
import { IndexComponent } from '../components/pages/index.component';
import { LoginComponent } from '../components/pages/login.component';
import { RegisterComponent } from '../components/pages/register.component';

export class ComponentsRegistry
{
    private static components: { [key: string]: any } = {
        ErrorComponent, IndexComponent, LoginComponent, RegisterComponent
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
