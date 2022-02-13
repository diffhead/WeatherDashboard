import { Application } from './classes/Application';
import { ApplicationRoute } from './classes/ApplicationRoute';

declare global {
    interface Window {
        application: Application;
    }
}

window.application = new Application(new ApplicationRoute(document.location));
window.application.display();
