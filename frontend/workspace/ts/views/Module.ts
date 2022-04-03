import { View } from '../classes/View';

import { Response } from '../types/Response';

import { Module as ModuleModel } from '../models/Module';

import { DomService } from '../services/DomService';

const EDIT_FIELDS_SELECTOR = '.module-item:not(.decoration) input, .module-item:not(.decoration) select';

const SAVE_BUTTON_SELECTOR = '.module-item__controls--button-save';
const EDIT_BUTTON_SELECTOR = '.module-item__controls--button-edit';
const DELETE_BUTTON_SELECTOR = '.module-item__controls--button-delete';

export class Module extends View
{
    public render(): boolean
    {
        if ( this.element === undefined ) {
            return false;
        }

        let saveBtn: HTMLButtonElement = DomService.findOne(SAVE_BUTTON_SELECTOR, this.element) as HTMLButtonElement;
        let editBtn: HTMLButtonElement = DomService.findOne(EDIT_BUTTON_SELECTOR, this.element) as HTMLButtonElement;
        let deleteBtn: HTMLButtonElement = DomService.findOne(DELETE_BUTTON_SELECTOR, this.element) as HTMLButtonElement;

        DomService.findAll(EDIT_FIELDS_SELECTOR, this.element).forEach(element => {
            element.addEventListener('change', () => {
                this.setModelDataByInputValue(element as HTMLInputElement);
                this.setElementAttributeByInputValue(element as HTMLInputElement);
                this.setSiblingSpanTextByInputValue(element as HTMLInputElement);
            });
        });

        saveBtn.addEventListener('click', async () => {
            let enableCheckbox: HTMLInputElement = DomService.findOne('input[name="enable"]', this.element) as HTMLInputElement;
            let response: Response = { status: true };

            this.element.classList.remove('editable');

            enableCheckbox.setAttribute('disabled', 'disabled');

            response = await (this.getModel() as ModuleModel).save();

            if ( response.status === false ) {
                window.application.showNotification('Fail', response.message as string || 'Module saving failed. See logs', true);
            } else {
                window.application.showNotification('Success', 'Module data saving successfully processed');
            }
        });

        editBtn.addEventListener('click', () => {
            let enableCheckbox: HTMLInputElement = DomService.findOne('input[name="enable"]', this.element) as HTMLInputElement;

            this.element.classList.add('editable');

            enableCheckbox.removeAttribute('disabled');
        });

        deleteBtn.addEventListener('click', async () => {
            let confirmation: boolean = confirm("Are you sure?");
            let response: Response = { status: true };

            if ( confirmation ) {
                response = await (this.getModel() as ModuleModel).delete();

                if ( response.status === false ) {
                    window.application.showNotification('Fail', response.message as string || 'Module removing failed. See logs', true);
                } else {
                    window.application.showNotification('Success', 'Module removing successfully processed.');

                    this.element.remove();
                }
            }
        });

        return true;
    }

    private setModelDataByInputValue(input: HTMLInputElement): void
    {
        let prop: string = input.name;
        let value: string = input.value;

        if ( prop === 'enable' ) {
            value = input.checked ? '1' : '0';
        }

        this.getModel().assignData({ [prop]: value });
    }

    private setElementAttributeByInputValue(input: HTMLInputElement): void
    {
        let attributeName: string = `data-${input.name}`;
        let attributeValue: string = input.value;

        if ( input.name === 'enable' ) {
            attributeValue = input.checked ? '1' : '0';
        }

        this.element.setAttribute(attributeName, attributeValue);
    }

    private setSiblingSpanTextByInputValue(input: HTMLInputElement): boolean
    {
        let span: Element = input.previousElementSibling;

        if ( span === null || span.nodeName !== 'SPAN' ) {
            span = input.nextElementSibling;

            if ( span === null || span.nodeName !== 'SPAN' ) {
                return false;
            }
        }

        span.textContent = input.value;

        return true;
    }
}
