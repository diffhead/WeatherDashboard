import { Component } from '../../interfaces/component.interface';

export class ErrorComponent implements Component
{
    private $el: Element;
    private $buttonHome: Element;
    private $buttonExpand: Element;
    private contentExpanded: boolean = false;

    public init(): void
    {
        this.initElements();
        this.initEventListeners();
    }

    private initElements(): void
    {
        let $el: Element|null = document.querySelector('.error-modal');

        let $buttonHome: Element|null;
        let $buttonExpand: Element|null;

        if ( $el === null ) {
            throw new Error("Failed to error modal finding");
        }

        $buttonHome = $el.querySelector('[data-entity="home"]');
        $buttonExpand = $el.querySelector('[data-entity="expand"]');

        if ( $buttonHome === null || $buttonExpand === null ) {
            throw new Error("Failed error modal buttons finding");
        }

        this.$el = $el;
        this.$buttonHome = $buttonHome;
        this.$buttonExpand = $buttonExpand;
    }

    private initEventListeners(): void
    {
        this.$buttonHome.addEventListener('click', () => this.goHomeAction());
        this.$buttonExpand.addEventListener('click', () => this.toggleContent());
    }

    private goHomeAction(): void
    {
        window.application.getHome();
    }

    private toggleContent(): void
    {
        if ( this.contentExpanded ) {
            this.setExpandedClass(false);
            this.setButtonText('Expand');
        } else {
            this.setExpandedClass(true);
            this.setButtonText('Cut Back');
        }
    }

    private setExpandedClass(value: boolean): void
    {
        this.contentExpanded = value;

        if ( value ) {
            this.$el.classList.add('expanded');
        } else {
            this.$el.classList.remove('expanded');
        }
    }

    private setButtonText(text: string): void
    {
        this.$buttonExpand.textContent = text;
    }

    public draw(): boolean
    {
        console.log(this.$el, this.contentExpanded);

        return true;
    }
}
