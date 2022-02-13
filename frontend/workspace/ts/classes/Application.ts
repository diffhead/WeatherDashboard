import { ApplicationRoute } from './ApplicationRoute';

export class Application
{
    readonly route: ApplicationRoute;
    
    constructor(route: ApplicationRoute)
    {
        this.route = route;
    }
    
    display(): void
    {
        console.log('display', this.route);
    }
}
