import { Component } from '../../interfaces/component.interface';
import { ButtonComponent } from '../button.component';

export class ErrorComponent implements Component
{
    private $el: Element;

    private buttonHome: ButtonComponent;
    private buttonExpand: ButtonComponent;

    private contentExpanded: boolean = false;

    public init(): void
    {
        this.initElements();
        this.initEventListeners();
    }

    private initElements(): void
    {
        let $el: Element|null = document.querySelector('.error-modal');

        if ( $el === null ) {
            throw new Error("Failed to error modal finding");
        }

        this.$el = $el;

        this.buttonHome = new ButtonComponent('[data-entity="home"]');
        this.buttonExpand = new ButtonComponent('[data-entity="expand"]');
    }

    private initEventListeners(): void
    {
        this.buttonHome.onClick(() => { 
            window.application.getHome() 

            return true;
        });

        this.buttonExpand.onClick(() => { 
            this.toggleContent();

            return true;
        });
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
        this.buttonExpand.setText(text);
    }

    public draw(): boolean
    {
        return true;
    }
}
