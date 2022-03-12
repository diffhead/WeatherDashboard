import { View } from '../../classes/View';

import { DomService } from '../../services/DomService';

export class Error extends View
{
    private expanded: boolean = false;
    private extendedMessage: HTMLDivElement;

    public contructor()
    {
        let element: Element = DomService.findOne('.error-modal');
        let extendedMessage: Element = DomService.findOne('.error-modal-additional', element)

        this.setElement(element);
        this.setExtendedMessage(extendedMessage as HTMLDivElement);
    }

    private setExtendedMessage(element: HTMLDivElement): void
    {
        this.extendedMessage = element;
    }

    public render(): boolean
    {
        let homeBtn: HTMLButtonElement = DomService.findOne('[data-entity="home"]', this.element) as HTMLButtonElement;
        let expandBtn: HTMLButtonElement = DomService.findOne('[data-entity="expand"]', this.element) as HTMLButtonElement;

        homeBtn.addEventListener('click', () => window.application.getHome());

        expandBtn.addEventListener('click', () => {
            this.expanded = !this.expanded;

            if ( this.expanded ) {
                expandBtn.textContent = 'CutBack';
            } else {
                expandBtn.textContent = 'Expand';
            }

            this.toggleMessage();
        });

        return true;
    }

    private toggleMessage(): void
    {
        if ( this.extendedMessage ) {
            if ( this.expanded ) {
                this.extendedMessage.classList.add('expanded');
            } else {
                this.extendedMessage.classList.remove('expanded');
            }
        }
    }
}
