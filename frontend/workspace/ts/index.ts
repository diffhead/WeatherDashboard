import { Application } from './classes/Application';
import { Error } from './types/Error';
import { City } from './types/City';
import { Country } from './types/Country';

declare global {
    interface Window {
        error: Error,
        application: Application,
        countries: Country[],
        cities: City[]
    }
}

window.application = new Application(document.location.pathname, window.error);
window.application.render();
