import { View } from '../classes/View';

import { Notification as NotificationModel } from '../models/Notification';

import { DomService } from '../services/DomService';

export class Notification extends View
{
    private notificationTextDiv: HTMLDivElement;
    private notificationTitleDiv: HTMLDivElement;

    private beforeClose: () => void;
    private afterClose: () => void;

    public render(): boolean
    {
        if ( this.element === undefined ) {
            let content: HTMLDivElement = DomService.findOne('.content') as HTMLDivElement;

            let notification: HTMLDivElement;
            let notificationText: HTMLDivElement;
            let notificationMenu: HTMLDivElement;
            let notificationMenuClose: HTMLButtonElement;
            let notificationTitle: HTMLDivElement;
            let notificationTitleText: Text;
            let closeButton: HTMLButtonElement;

            if ( content === null ) {
                throw new Error('Page content wrapper not found');
            }

            notification = DomService.createDiv('content-notification');
            notificationMenu = DomService.createDiv('content-notification-menu');
            notificationText = DomService.createDiv('content-notification-text');

            notificationTitle = DomService.createDiv('notification-title');
            notificationTitleText = DomService.createText('Notification');

            notificationMenuClose = DomService.createButton('close-button');
            notificationMenuClose.addEventListener('click', () => {
                if ( this.beforeClose !== undefined ) {
                    this.beforeClose();
                }

                this.hide();

                if ( this.afterClose !== undefined ) {
                    this.afterClose();
                }
            });
 
            DomService.append(notificationTitle, notificationTitleText as Node as Element);
            DomService.appendBatch(notificationMenu, [ notificationTitle, notificationMenuClose ]);
            DomService.appendBatch(notification, [ notificationMenu, notificationText ]);
            DomService.append(content, notification);
           
            this.element = notification;

            this.notificationTextDiv = notificationText;
            this.notificationTitleDiv = notificationTitle;

            return true;
        }

        return false;
    }

    public setBeforeClose(callback: () => void): void
    {
        this.beforeClose = callback;
    }

    public setAfterClose(callback: () => void): void
    {
        this.afterClose = callback;
    }

    public show(): void
    {
        if ( this.element !== undefined ) {
            this.notificationTextDiv.textContent = this.getModel().getData().message as string;
            this.notificationTitleDiv.textContent = this.getModel().getData().title as string;

            this.element.classList.add('visible');

            if ( this.getModel().getData().error ) {
                this.element.classList.add('error');
            } else {
                this.element.classList.remove('error');
            }

            this.getModel().assignData({ 
                visible: true 
            });
        }
    }

    public hide(): void
    {
        if ( this.element !== undefined ) {
            this.element.classList.remove('visible');

            this.getModel().assignData({
                visible: false 
            });
        }
    }
}
