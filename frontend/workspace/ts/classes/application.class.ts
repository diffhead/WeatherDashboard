import { Router } from './router.class';

import { Error } from '../types/error.type';

import { Component } from '../interfaces/component.interface';

export class Application
{
    readonly route: string;
    readonly error: Error;

    constructor(route: string, error: Error|undefined)
    {
        this.route = route;

        if ( error !== undefined ) {
            this.error = error;
        }
    }

    public run(): void
    {
        let router: Router = new Router();
        let component: Component = router.getRouteComponent(
            this.error ? '__ERROR__' : this.route
        );

        component.init();
        component.draw();
    }

    public getHome(): void
    {
        document.location = '/';
    }
}
