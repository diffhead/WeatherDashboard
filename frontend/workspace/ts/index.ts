import { Application } from './classes/Application';
import { Error } from './types/Error';

declare global {
    interface Window {
        error: Error,
        application: Application
    }
}

window.application = new Application(document.location.pathname, window.error);
window.application.render();
