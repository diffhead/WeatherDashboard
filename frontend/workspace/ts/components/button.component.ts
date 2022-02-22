import { Component } from '../interfaces/component.interface';

export class ButtonComponent implements Component
{
    private selector: string;
    private $button: HTMLElement;

    public constructor(selector: string)
    {
        this.selector = selector;
        this.init();
    }

    public init(): void
    {
        if ( this.$button === undefined ) {
            let $button: HTMLElement|null = document.querySelector(this.selector);

            if ( $button !== null  ) {
                this.$button = $button;
            }
        }
    }

    public draw(): boolean
    {
        return true;
    }

    public onClick(callback: (e: Event) => boolean): void
    {
        if ( this.$button ) {
            this.$button.addEventListener('click', callback);
        }
    }

    public setText(text: string): void
    {
        this.$button.textContent = text;
    }
}
