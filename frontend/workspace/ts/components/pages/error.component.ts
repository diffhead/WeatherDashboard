import { Component } from '../../interfaces/component.interface';

import { DomService } from '../../services/dom.service';

export class ErrorComponent implements Component
{
    private $el: Element;

    private $homeBtn: HTMLButtonElement;
    private $expandBtn: HTMLButtonElement;

    private contentExpanded: boolean = false;

    public init(): void
    {
        this.initElements();
    }

    private initElements(): void
    {
        let $el: Element|null = DomService.findOne('.error-modal');

        if ( $el === null ) {
            throw new Error("Failed to error modal finding");
        }

        this.$el = $el;

        this.$homeBtn = (<HTMLButtonElement>DomService.findOne('[data-entity="home"]'));
        this.$homeBtn.addEventListener('click', () => window.application.getHome());

        this.$expandBtn = (<HTMLButtonElement>DomService.findOne('[data-entity="expand"]'));
        this.$expandBtn.addEventListener('click', () => this.toggleContent());
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
        this.$expandBtn.textContent = text;
    }

    public draw(): boolean
    {
        return true;
    }
}
