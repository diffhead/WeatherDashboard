import { Component } from '../interfaces/component.interface';

export class ButtonComponent implements Component
{
    private $button: HTMLElement;

    public constructor(selector: string)
    {
        let $button: HTMLElement|null = document.querySelector(selector);

        if ( $button === null  ) {
            throw new Error("Button element not found");
        }

        this.$button = $button;
    }

    public init(): void
    {
    }

    public draw(): boolean
    {
        return true;
    }

    public onClick(callback: (e: Event) => boolean): void
    {
        this.$button.addEventListener('click', callback);
    }
}
