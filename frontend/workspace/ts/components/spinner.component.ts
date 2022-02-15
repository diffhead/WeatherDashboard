import { Component } from '../interfaces/component.interface';

const SPINNER_CLASS = '.simple-spinner';

export class SpinnerComponent implements Component
{
    private $el: Element;
    private $parent: Element;
    private existsInDom: boolean = false;
    private visible: boolean = false;

    public constructor(parentSelector: string)
    {
        let $parent: Element|null;
        let $el: Element|null;

        $parent = document.querySelector(parentSelector);

        if ( $parent === null ) {
            throw new Error(`Parent DIV by selector '${parentSelector}' not found`);
        }

        $el = $parent.querySelector(SPINNER_CLASS);

        if ( $el ) {
            this.$el = $el;
        }

        this.$parent = $parent;
    }

    public init(): void
    {
        if ( this.$el  ) {
            this.existsInDom = true;
            this.visible = this.$el.classList.contains('visible');
        }
    }

    public draw(): boolean
    {
        if ( this.existsInDom === false ) {
            this.render();
        }

        this.$el.classList.add('visible');

        return true;
    }

    private render(): void
    {
        let spinnerDiv: Element = document.createElement('div');

        this.$parent.appendChild(spinnerDiv);
        this.$el = spinnerDiv;

        this.existsInDom = true;
    }

    public hide(): boolean
    {
        if ( this.existsInDom === false ) {
            return false;
        }

        this.$el.classList.remove('visible');
    }
}
