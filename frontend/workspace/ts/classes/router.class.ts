import { Component } from '../interfaces/component.interface';

import { ErrorComponent } from '../components/error.component';

export class Router
{
    getRouteComponent(route: string): Component
    {
        return new ErrorComponent();
    }
}
