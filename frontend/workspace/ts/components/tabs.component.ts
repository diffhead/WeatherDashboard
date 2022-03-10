import { Component } from '../interfaces/component.interface';

import { ButtonComponent } from './button.component';

export class TabsComponent implements Component
{
    private tabs: NodeList;
    private contents: NodeList;

    private tabButtons: ButtonComponent[] = [];

    private inited: boolean = false;
    private rootSelector: string;

    private entity: string = '';

    public constructor(rootSelector: string)
    {
        this.rootSelector = rootSelector;

        this.init();
    }

    public init(): void
    {
        let $el: null|HTMLElement;

        if ( this.inited === false ) {
            if ( this.rootSelector === '' ) {
                throw new Error("TabsComponent root selector cannot be an empty");
            }

            $el = document.querySelector(this.rootSelector);

            if ( $el === null ) {
                throw new Error("TabsComponent didnt find root element");
            }

            this.tabs = $el.querySelectorAll('.tabs .tab');
            this.contents = $el.querySelectorAll('.contents .content');

            this.tabs.forEach(node => {
                let nodeEntity: string = (<HTMLElement>node).dataset.entity;
                let tabButton: ButtonComponent = new ButtonComponent(
                    `${this.rootSelector} .tab[data-entity="${nodeEntity}"]`
                );

                tabButton.onClick(() => this.switchTab(nodeEntity));

                if ( (<HTMLElement>node).classList.contains('active') ) {
                    this.setEntity(nodeEntity);
                }
            });

            this.inited = true;
        }
    }

    public setEntity(entity: string): void
    {
        this.entity = entity;
    }

    public switchTab(entity: string): boolean
    {
        this.setEntity(entity);

        return this.draw();
    }

    public draw(): boolean
    {
        if ( this.inited === false ) {
            return false;
        }

        this.tabs.forEach(node => {
            if ( (<HTMLElement>node).dataset.entity !== this.entity ) {
                (<HTMLElement>node).classList.remove('active');
            } else {
                (<HTMLElement>node).classList.add('active');
            }
        });
        
        this.contents.forEach(node => {
            if ( (<HTMLElement>node).dataset.entity !== this.entity ) {
                (<HTMLElement>node).classList.remove('active');
            } else {
                (<HTMLElement>node).classList.add('active');
            }
        });

        return true;
    }
}
