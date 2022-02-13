export class ApplicationRoute
{
    readonly path: string;
    
    constructor(location: Location)
    {
        this.path = location.pathname;
    }
}
