import { View } from '../classes/View';

import { DomService } from '../services/DomService';

export class Tabs extends View
{
    private tab: string;
    private tabs: NodeList;
    private contents: NodeList;

    public render(): boolean
    {
        if ( this.element === undefined ) {
            return false;
        }

        this.tabs = DomService.findAll('.tabs .tab', this.element);
        this.contents = DomService.findAll('.contents .content', this.element);

        if ( this.tabs === null || this.contents === null ) {
            throw new Error('Tabs or Contents not found');
        }

        this.tabs.forEach(node => {
            if ( (node as Element).classList.contains('active') ) {
                this.tab = (node as Element).getAttribute('data-entity');
            }

            node.addEventListener('click', () => {
                this.switch((node as Element).getAttribute('data-entity'));
            });
        });

        if ( this.tab === undefined ) {
            this.tab = (this.tabs[0] as Element).getAttribute('entity');
        }

        this.switch(this.tab);

        return true;
    }

    public switch(toTab: string): void
    {
        this.tabs.forEach(node => {
            if ( (node as Element).getAttribute('data-entity') === toTab ) {
                (node as Element).classList.add('active');
            } else {
                (node as Element).classList.remove('active');
            }
        });

        this.contents.forEach(node => {
            if ( (node as Element).getAttribute('data-entity') === toTab ) {
                (node as Element).classList.add('active');
            } else {
                (node as Element).classList.remove('active');
            }
        });

        this.tab = toTab;
    }
}
