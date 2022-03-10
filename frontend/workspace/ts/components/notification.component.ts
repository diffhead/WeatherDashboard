import { Component } from '../interfaces/component.interface';

import { DomService } from '../services/dom.service';

import { NotificationState } from '../types/notification-state.type';

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
    private $closeButton: HTMLButtonElement;

    private defaultTitle: string = 'Notification';
    private defaultMessage: string = 'Attention';

    private titles: string[] = [];
    private messages: string[] = [];

    private visible: number = 0;

    private notification: null|Promise<boolean> = null;
    private notificationState: null|NotificationState = null;

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
            let $closeButton: HTMLButtonElement;

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

            $closeButton = (<HTMLButtonElement>DomService.findOne(`.${PAGE_NOTIFICATION_CLASS} .${PAGE_NOTIFICATION_CLOSE_CLASS}`));

            this.$closeButton = $closeButton;
            this.$closeButton.addEventListener('click', () => {
                if ( this.notificationState !== null ) {
                    clearTimeout(this.notificationState.hideTimeout);
                    clearTimeout(this.notificationState.drawTimeout);

                    this.notificationState.resolve(true);
                    this.notificationState = null;
                }

                this.hide();
            });

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
            if ( this.notification === null ) {
                this.notification = this.getNewNotificationPromise();
            } else {
                this.notification = this.notification.then(
                    () => this.getNewNotificationPromise()
                );
            }
        } else {
            this.render();
        }

        this.visible++;

        return true;
    }

    private getNewNotificationPromise(): Promise<boolean>
    {
        let hideTimeout: number = 0;
        let drawTimeout: number = 0;

        let promise: Promise<boolean> = new Promise(resolve => {

            hideTimeout = setTimeout(() => {
                this.hide();

                drawTimeout = setTimeout(() => {
                    this.render();
                    this.notificationState = null;

                    resolve(true);
                }, 400);
            }, 1500);

            this.notificationState = { 
                resolve, hideTimeout, drawTimeout
            };
        });

        return promise;
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

        if ( this.visible ) {
            this.visible--;
        }

        return true;
    }
}
