import { View } from '../classes/View';

import { FilteredIdStorage } from '../types/FilteredIdStorage';

import { Select } from '../models/Select'
import { SelectOption } from '../models/SelectOption';

import { DomService } from '../services/DomService';

const CSELECT_SELECTOR = '.cselect-with-input';
const CSELECT_INPUT_SELECTOR = '.cselect-with-input--input input';
const CSELECT_OPTION_SELECTOR = '.cselect-select--option';
const CSELECT_TOGGLE_SELECTOR = '.cselect-with-input--toggle';
const CSELECT_VALUE_SELECTOR = '.cselect-with-input--value';
const CSELECT_PLACEHOLDER_SELECTOR = '.cselect-with-input--placeholder';

export class SelectWithInput extends View
{
    private opened: boolean = false;
    private searchTimeout: number = 0;
    private selectDisabled: boolean = false;

    private selectModel: Select;

    private domOptions: null|NodeList = null;

    private input: null|HTMLInputElement = null;
    private placeholder: null|HTMLDivElement = null;
    private valueSpan: null|HTMLSpanElement = null;

    private filteredById: FilteredIdStorage = {};
    private filteredByTitle: FilteredIdStorage = {};

    private setInput(input: HTMLInputElement): void
    {
        this.input = input;
    }

    private setValueSpan(span: HTMLSpanElement): void
    {
        this.valueSpan = span;
    }

    private setPlaceholder(placeholder: HTMLDivElement): void
    {
        this.placeholder = placeholder;
    }

    private toggleSelect(): void
    {
        if ( this.opened ) {
            clearTimeout(this.searchTimeout);

            this.opened = false;
            this.input.value = '';
            this.element.classList.remove('open');

            this.filterOptionsByTitle();
        } else {
            if ( this.selectDisabled === false ) {
                this.opened = true;
                this.element.classList.add('open');
                this.input.focus();
            }
        }
    }

    private selectElement(target: HTMLDivElement, toggle: boolean = true): void
    {
        let selectedOptionId: number = Number(target.getAttribute('data-id'));

        this.selectModel.select(selectedOptionId);

        this.element.dispatchEvent(new CustomEvent('select.option.selected', { 
            bubbles: true, 
            detail: this.selectModel.getSelected() 
        }));

        if ( toggle ) {
            this.toggleSelect();
        }

        this.domOptions.forEach(option => {
            let optionId: number = Number((option as Element).getAttribute('data-id'));

            if ( selectedOptionId !== optionId ) {
                (option as Element).setAttribute('data-selected', '0');
                (option as Element).classList.remove('selected');
            } else {
                (option as Element).setAttribute('data-selected', '1');
                (option as Element).classList.add('selected');
            }
        });

        this.setCurrentData(
            String(selectedOptionId), this.selectModel.getSelected().getTitle(), this.selectModel.getSelected().getValue(), '1'
        );

        this.valueSpan.parentElement.classList.remove('hidden');

        this.placeholder.classList.add('hidden');
    }

    private setCurrentData(id: string = '', title: string = '', value: string = '', selected: string = ''): void
    {
        this.element.setAttribute('data-id', id);
        this.element.setAttribute('data-title', title);
        this.element.setAttribute('data-value', value);
        this.element.setAttribute('data-selected', selected);

        this.valueSpan.textContent = title;
    }

    private setSearchingTimeout(): void
    {
        clearTimeout(this.searchTimeout);

        this.searchTimeout = setTimeout(() => {
            this.filterOptionsByTitle(this.input.value);
        }, 500);
    }

    private checkTargetAndCloseSelectIfNeed(target: Element): void
    {
        if ( DomService.hasParent(target, this.element) === false && this.opened ) {
            this.toggleSelect();
        }
    }

    public constructor(id: string)
    {
        super();

        this.setElement(DomService.findOne(CSELECT_SELECTOR + '#' + id));
        this.setInput(DomService.findOne(CSELECT_INPUT_SELECTOR, this.element) as HTMLInputElement);
        this.setValueSpan(DomService.findOne(CSELECT_VALUE_SELECTOR + ' span', this.element) as HTMLSpanElement);
        this.setPlaceholder(DomService.findOne(CSELECT_PLACEHOLDER_SELECTOR, this.element) as HTMLDivElement);

        this.render();
    }

    public select(id: number, toggle: boolean = true): void
    {
        this.domOptions.forEach(option => {
            let optionDiv: HTMLDivElement = option as HTMLDivElement;
            let optionId: number = Number(optionDiv.getAttribute('data-id'));

            if ( optionId === id ) {
                this.selectElement(optionDiv, toggle);
            }
        });
    }

    public unselect(): void
    {
        this.selectModel.select();
        this.setCurrentData();

        this.filteredById = {};
        this.filteredByTitle = {};

        this.valueSpan.parentElement.classList.add('hidden');
        this.placeholder.classList.remove('hidden');

        this.element.dispatchEvent(
            new CustomEvent('select.option.unset', { bubbles: true, detail: true })
        );
    }

    public disabled(value: boolean = true): void
    {
        this.selectDisabled = value;

        if ( value ) {
            this.element.classList.add('disabled');
        } else {
            this.element.classList.remove('disabled');
        }
    }

    public render(): boolean
    {
        if ( this.element === undefined ) {
            throw new Error('Failed to finding element');
        }

        if ( this.element.classList.contains('disabled') ) {
            this.disabled();
        }

        let togglersSelector: string = `${CSELECT_TOGGLE_SELECTOR}, ${CSELECT_VALUE_SELECTOR}, ${CSELECT_PLACEHOLDER_SELECTOR}`;
        let togglers: NodeList = DomService.findAll(togglersSelector, this.element);

        togglers.forEach(element => {
            element.addEventListener('click', e => this.toggleSelect());
        });

        let options: NodeList = DomService.findAll(CSELECT_OPTION_SELECTOR, this.element);

        this.selectModel = new Select(this.element.id);

        options.forEach(element => {
            let id: number = Number((element as Element).getAttribute('data-id'));
            let title: string = (element as Element).getAttribute('data-title');
            let value: string = (element as Element).getAttribute('data-value');
            let selected: number = Number((element as Element).getAttribute('data-selected'));

            let option: SelectOption = new SelectOption(id, title, value, selected);

            this.selectModel.appendOptions([ option ]);

            if ( option.isSelected() ) {
                this.selectModel.select(option.getId());
            }

            element.addEventListener('click', ({ target }) => {
                let t: Element = target as Element;

                if ( t.nodeName === 'SPAN' ) {
                    target = t.parentElement;
                }

                this.select(
                    Number((target as HTMLDivElement).getAttribute('data-id'))
                );
            });
        });

        this.domOptions = options;

        this.input.addEventListener('input', () => this.setSearchingTimeout());

        document.addEventListener('click', ({ target }) => this.checkTargetAndCloseSelectIfNeed(target as Element));

        return true;
    }

    public filterOptionsByTitle(title: string = ''): void
    {
        if ( title === '' ) {
            this.filteredByTitle = {};
        }

        this.domOptions.forEach(option => {
            let optionDiv: HTMLDivElement = option as HTMLDivElement;
            let optionId: number = Number(optionDiv.getAttribute('data-id'));
            let optionTitle: string = optionDiv.getAttribute('data-title');

            if ( title === '' ) {
                if ( this.filteredById[optionId] ) {
                    optionDiv.classList.remove('hidden');
                }
            } else {
                if ( optionTitle.match(title.trim()) && !this.filteredById[optionId] ) {
                    optionDiv.classList.remove('hidden');
                } else {
                    optionDiv.classList.add('hidden');

                    this.filteredByTitle[optionId] = true;
                }
            }
        });
    }

    public filterOptionsById(identifiers: number[] = []): void
    {
        if ( identifiers.length ) {
            identifiers.map(id => this.filteredById[id] = true);
        } else {
            this.filteredById = {};
        }

        this.domOptions.forEach(option => {
            let optionDiv: HTMLDivElement = option as HTMLDivElement;
            let optionId: number = Number(optionDiv.getAttribute('data-id')) ;

            if ( identifiers.length ) {
                if ( this.filteredById[optionId] && !this.filteredByTitle[optionId] ) {
                    optionDiv.classList.remove('hidden');
                } else {
                    optionDiv.classList.add('hidden');
                }
            } else {
                if ( !this.filteredByTitle[optionId] ) {
                    optionDiv.classList.remove('hidden');
                }
            }
        });
    }

    public replaceOption(id: number, option: SelectOption): void
    {
        this.selectModel.replaceOption(id, option);
    }
}
