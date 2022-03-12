import { NotificationState } from '../types/NotificationState';

import { Notification as NotificationView } from '../views/Notification';
import { Notification as NotificationModel } from '../models/Notification';

export class Notification
{
    private static view: NotificationView;

    private static titles: string[] = [];
    private static messages: string[] = [];

    private static state: null|NotificationState = null;
    private static promise: null|Promise<boolean> = null;

    public static showNotification(title: string = 'Notification', message: string, error: boolean = false): boolean
    {
        if ( Notification.view === undefined ) {
            return false;
        }

        if ( Notification.view.getModel().getData().visible ) {
            if ( Notification.state ) {
                Notification.promise = Notification.promise.then(() => {
                    return Notification.getNotificationPromise(title, message, error)
                });
            } else {
                Notification.promise = Notification.getNotificationPromise(title, message, error);
            }
        } else {
            Notification.view.getModel().assignData({ 
                title, message, error 
            });

            Notification.view.show();
        }

        return true;
    }

    public static init(): void
    {
        if ( Notification.view === undefined ) {
            Notification.view = new NotificationView;
            Notification.view.setModel(new NotificationModel);
            Notification.view.render();

            Notification.view.setBeforeClose(() => {
                if ( Notification.state !== null ) {
                    clearTimeout(Notification.state.hideTimeout);
                    clearTimeout(Notification.state.showTimeout);

                    Notification.state.resolve(true);
                    Notification.state = null;
                }
            });
        }
    }

    public static getNotificationPromise(title: string, message: string, error: boolean): Promise<boolean>
    {
        return new Promise(resolve => {
            let hideTimeout: number;
            let showTimeout: number;

            hideTimeout = setTimeout(() => {
                Notification.view.hide();

                showTimeout = setTimeout(() => {
                    Notification.view.getModel().assignData({ 
                        title, message, error 
                    });

                    Notification.view.show();
                    Notification.state = null;

                    resolve(true);
                }, 400);
            }, 2000);

            Notification.state = { hideTimeout, showTimeout, resolve };
        });
    }
}
