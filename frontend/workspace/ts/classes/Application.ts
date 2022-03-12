import { Error } from '../types/Error';
import { RoutesViewsAssociation } from '../types/RoutesViewsAssociation';

import { View } from '../interfaces/View';

import { Notification } from './Notification';

import { Error as ErrorView } from '../views/pages/Error';
import { Index as IndexView } from '../views/pages/Index';
import { Login as LoginView } from '../views/pages/Login';

export class Application
{
    private routes: RoutesViewsAssociation = { 
        '/':      IndexView,
        '/login': LoginView
    };

    private view: View;

    public constructor(route: string, error: Error = null)
    {
        if ( error ) {
            this.view = new ErrorView();
        } else {
            if ( this.routes.hasOwnProperty(route) === false ) {
                throw new Error(`Cant find view for route: '${route}'`);
            }

            this.view = new this.routes[route].prototype.constructor();
        }

        Notification.init();
    }

    public showNotification(title: string = '', message: string = '', error: boolean = false): void
    {
        Notification.showNotification(title, message, error);
    }

    public getHome(): void
    {
        this.getPage('/');
    }

    public getPage(uri: string): void
    {
        document.location = uri;
    }

    public render(): boolean
    {
        let status: boolean = this.view.render();

        if ( status === false ) {
            throw new Error('View.render returned false');
        }

        return status;
    }
}
