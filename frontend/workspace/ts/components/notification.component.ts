import { Component } from '../interfaces/component.interface';

import { ButtonComponent } from './button.component';

import { DomService } from '../services/dom.service';

import { 
    PAGE_CONTENT_CLASS,
    PAGE_NOTIFICATION_CLASS,
    PAGE_NOTIFICATION_MENU_CLASS,
    PAGE_NOTIFICATION_TEXT_CLASS,
    PAGE_NOTIFICATION_CLOSE_CLASS,
    PAGE_NOTIFICATION_TITLE_CLASS,
    PAGE_NOTIFICATION_ERROR_CLASS
} from '../consts';

export class NotificationComponent implements Component
{
    private $el: HTMLDivElement;
    private $titleDiv: HTMLDivElement;
    private $messageDiv: HTMLDivElement;

    private closeButton: ButtonComponent;

    private defaultTitle: string = 'Notification';
    private defaultMessage: string = 'Attention';

    private titles: string[] = [];
    private messages: string[] = [];

    private visible: number = 0;
    private notification: Promise<boolean> = new Promise(resolve => resolve(true));

    public init(): void
    {
        if ( this.$el === undefined ) {
            let $content: HTMLDivElement|null;
            let $notification: HTMLDivElement|null;
            let $notificationText: HTMLDivElement|null;
            let $notificationMenu: HTMLDivElement;
            let $notificationMenuClose: HTMLButtonElement;
            let $notificationTitle: HTMLDivElement;
            let $notificationTitleText: Text;

            $content = document.querySelector(`.${PAGE_CONTENT_CLASS}`);

            if ( $content === null ) {
                throw new Error('Page content wrapper not found');
            }

            $notification = DomService.createDiv(PAGE_NOTIFICATION_CLASS);
            $notificationMenu = DomService.createDiv(PAGE_NOTIFICATION_MENU_CLASS);
            $notificationText = DomService.createDiv(PAGE_NOTIFICATION_TEXT_CLASS);

            $notificationTitle = DomService.createDiv(PAGE_NOTIFICATION_TITLE_CLASS);
            $notificationTitleText = DomService.createText('Notification');
            $notificationMenuClose = DomService.createButton('', PAGE_NOTIFICATION_CLOSE_CLASS);

            DomService.append($notificationTitle, (<Element>(<Node>$notificationTitleText)));
            DomService.appendBatch($notificationMenu, [ $notificationTitle, $notificationMenuClose ]);
            DomService.appendBatch($notification, [ $notificationMenu, $notificationText ]);
            DomService.append($content, $notification);

            this.closeButton = new ButtonComponent(
                `.${PAGE_NOTIFICATION_CLASS} .${PAGE_NOTIFICATION_CLOSE_CLASS}`
            );

            this.closeButton.init();
            this.closeButton.onClick(() => this.hide.call(this));

            this.$el = $notification;
            this.$titleDiv = $notificationTitle;
            this.$messageDiv = $notificationText;
        }
    }

    public setMessage(message: string): boolean
    {
        this.messages.push(message);

        return false;
    }

    public setTitle(title: string): boolean
    {
        this.titles.push(title);

        return true;
    }

    public setError(value: boolean): void
    {
        if ( value ) {
            this.$el.classList.add(PAGE_NOTIFICATION_ERROR_CLASS);
        } else {
            this.$el.classList.remove(PAGE_NOTIFICATION_ERROR_CLASS);
        }
    }

    public draw(): boolean
    {
        if ( this.$el === undefined ) {
            return false;
        }

        if ( this.visible ) {
            this.notification = this.notification.then(() => {
                return this.getNewNotificationPromise();
            });

            return false;
        }

        this.render();

        this.visible++;

        return true;
    }

    private getNewNotificationPromise(): Promise<boolean>
    {
        return new Promise(resolve => {
            setTimeout(() => {
                this.hide();

                setTimeout(() => {
                    this.draw();

                    resolve(true);
                }, 400);
            }, 1500);
        });
    }

    private render(): void
    {
        let title: string;
        let message: string;

        if ( this.messages.length ) {
            message = this.messages.shift();
        } else {
            message = this.defaultMessage;
        }

        if ( this.titles.length ) {
            title = this.titles.shift();
        } else {
            title = this.defaultTitle;
        }

        this.$titleDiv.textContent = title;
        this.$messageDiv.textContent = message;

        this.$el.classList.add('visible');
    }

    public hide(): boolean
    {
        if ( this.$el === undefined ) {
            return false;
        }

        this.$el.classList.remove('visible');

        this.visible--;

        return true;
    }
}
