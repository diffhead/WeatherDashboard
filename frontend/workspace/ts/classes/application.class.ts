import { Router } from './router.class';

import { Error } from '../types/error.type';

import { Component } from '../interfaces/component.interface';

import { NotificationComponent } from '../components/notification.component';

export class Application
{
    readonly route: string;
    readonly error: Error;

    private notification: NotificationComponent;

    constructor(route: string, error: Error|undefined)
    {
        this.route = route;

        if ( error !== undefined ) {
            this.error = error;
        }

        this.notification = new NotificationComponent()
        this.notification.init();
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

    public sendNotify(message: string, title: string = 'Notification', error: boolean = false): void
    {
        this.notification.setError(error);
        this.notification.setTitle(title);
        this.notification.setMessage(message);
        this.notification.draw();
    }
}
