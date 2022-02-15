import { RoutesStorage } from './types/routes-storage.type';

export let routes: RoutesStorage = {
    '/': { 
        'component': 'IndexComponent', 
        'authorized': false 
    },
    '/login': {
        'component': 'LoginComponent',
        'authorized': false
    },
    '/register': {
        'component': 'RegisterComponent',
        'authorized': false
    },
    '/admin': {
        'component': 'AdminComponent',
        'authorized': true
    },
    '/profile': {
        'component': 'ProfileComponent',
        'authorized': true
    },

    '__ERROR__': {
        'component': 'ErrorComponent',
        'authorized': false
    }
};
