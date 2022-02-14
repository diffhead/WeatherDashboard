import { Component } from '../interfaces/component.interface';

import { ComponentsRegistry } from './components-registry.class';

import { routes } from '../routes.config';

import { Error } from '../types/error.type';

export class Router
{
    public getRouteComponent(route: string): Component
    {
        if ( routes.hasOwnProperty(route) === false ) {
            throw new Error('Route component not found');
        }

        return ComponentsRegistry.getComponent(
            this.getComponentName(route)
        );
    }

    private getComponentName(route: string): string
    {
        return routes[route]['component'];
    }
}
