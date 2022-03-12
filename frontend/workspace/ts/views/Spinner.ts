import { View } from '../classes/View';

import { DomService } from '../services/DomService';

export class Spinner extends View
{
    public constructor(element: HTMLDivElement)
    {
        super();

        this.setElement(element as Element);
    }

    public static getSpinnerDiv(): HTMLDivElement
    {
        return DomService.createDiv('simple-spinner');
    }

    public show(): void
    {
        if ( this.element ) {
            this.element.classList.add('visible');
        }
    }

    public hide(): void
    {
        if ( this.element ) {
            this.element.classList.remove('visible');
        }
    }
}
