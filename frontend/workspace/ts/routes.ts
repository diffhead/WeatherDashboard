import { RoutesStorage } from './types/routesstorage.type';
import { Route } from './types/route.type';

export let routes: RoutesStorage = {
    '/': { 
        'component': 'IndexComponent', 
        'authorized': false 
    },
    '/login': {
        'component': 'LoginComponent',
        'authorized': false
    },
    '/admin': {
        'component': 'AdminComponent',
        'authorized': true
    }
};
