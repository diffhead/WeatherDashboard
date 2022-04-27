import { View } from '../../classes/View';

import { DomService } from '../../services/DomService';

export class Error extends View
{
    private expanded: boolean = false;
    private extendedMessage: HTMLDivElement;

    public constructor()
    {
        let element: Element = DomService.findOne('.error-modal');
        let extendedMessage: HTMLDivElement = DomService.findOne('.error-modal-additional', element) as HTMLDivElement;

        super();

        this.setElement(element);
        this.setExtendedMessage(extendedMessage);
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
                this.element.classList.add('expanded');
            } else {
                this.element.classList.remove('expanded');
            }
        }
    }
}
