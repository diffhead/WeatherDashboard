import { Application } from './classes/application.class';

import { Error } from './types/error.type';

declare global {
    interface Window {
        application: Application,
        error: Error
    }
}

window.application = new Application(document.location.pathname, window.error);
window.application.run();
