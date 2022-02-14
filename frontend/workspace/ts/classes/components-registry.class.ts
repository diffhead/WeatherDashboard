import { Component } from '../interfaces/component.interface';

import { ErrorComponent } from '../components/error.component';
import { IndexComponent } from '../components/index.component';

export class ComponentsRegistry
{
    private static components: { [key: string]: Component } = {
        'ErrorComponent': new ErrorComponent(),
        'IndexComponent': new IndexComponent()
    };

    public static getComponent(component: string): Component|null
    {
        console.log(component);

        if ( ComponentsRegistry.components.hasOwnProperty(component) === false ) {
            return null;
        }

        return ComponentsRegistry.components[component];
    }
}
