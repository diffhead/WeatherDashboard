import { ModelData } from '../types/ModelData';
import { DomService } from './DomService';

export class DomModuleItemService
{
    private moduleData: ModelData = {};
    private defaultClass: string = '';

    public constructor(moduleData: ModelData, defaultClass: string = 'module-item')
    {
        this.moduleData = moduleData;
        this.defaultClass = defaultClass;
    }

    public createDomItem(): HTMLDivElement
    {
        let moduleItem: HTMLDivElement = DomService.createDiv(this.defaultClass);
        let moduleItemName: HTMLDivElement = this.createNameDiv();
        let moduleItemEnable: HTMLDivElement = this.createEnableDiv();
        let moduleItemEnvironment: HTMLDivElement = this.createEnvDiv();
        let moduleItemPriority: HTMLDivElement = this.createPriorityDiv();
        let moduleItemControls: HTMLDivElement = this.createControlsDiv();

        for ( let prop in this.moduleData ) {
            let attrName: string = `data-${prop}`;
            let attrValue: string = this.moduleData[prop] as string;

            moduleItem.setAttribute(attrName, attrValue);
        }

        DomService.appendBatch(moduleItem as Element, [
            moduleItemName as Element,
            moduleItemEnable as Element,
            moduleItemEnvironment as Element,
            moduleItemPriority as Element,
            moduleItemControls as Element
        ]);

        return moduleItem;
    }

    private createNameDiv(): HTMLDivElement
    {
        let nameDiv: HTMLDivElement = DomService.createDiv(this.defaultClass + '__name');
        let nameSpan: HTMLSpanElement = DomService.createSpan();
        let nameInput: HTMLInputElement = DomService.createInput('', 'name');

        nameSpan.textContent = this.moduleData.name as string;

        nameInput.value = this.moduleData.name as string;
        nameInput.setAttribute('disabled', 'disabled');

        DomService.appendBatch(nameDiv as Element, [
            nameSpan as Element,
            nameInput as Element
        ]);

        return nameDiv;
    }

    private createEnableDiv(): HTMLDivElement
    {
        let enableDiv: HTMLDivElement = DomService.createDiv(this.defaultClass + '__enable');
        let enableInput: HTMLInputElement = DomService.createInput(this.defaultClass + '__enable-input', 'enable', this.moduleData.enable as string);

        enableInput.setAttribute('type', 'checkbox');
        enableInput.setAttribute('disabled', 'disabled');

        if ( this.moduleData.enable ) {
            enableInput.setAttribute('checked', 'checked');
            enableInput.checked = true;
        }

        DomService.append(enableDiv as Element, enableInput as Element);

        return enableDiv;
    }

    private createEnvDiv(): HTMLDivElement
    {
        let environmentDiv: HTMLDivElement = DomService.createDiv(this.defaultClass + '__environment');
        let environmentSpan: HTMLSpanElement = DomService.createSpan();
        let environmentValue: string = this.moduleData.environment as string;

        let environmentSelect: HTMLSelectElement = DomService.createSelect('', 'environment');
        let optionWeb: HTMLOptionElement = DomService.createSelectOption('', 'Web', 'web');
        let optionCli: HTMLOptionElement = DomService.createSelectOption('', 'Cli', 'cli');

        if ( this.moduleData.environment === 'web' ) {
            environmentSelect.value = 'web';
            optionWeb.setAttribute('selected', 'selected');
        } else {
            environmentSelect.value = 'cli';
            optionCli.setAttribute('selected', 'selected');
        }

        DomService.appendBatch(environmentSelect as Element, [ 
            optionWeb as Element, 
            optionCli as Element 
        ]);

        environmentSpan.textContent = environmentValue;
        
        DomService.appendBatch(environmentDiv as Element, [
            environmentSpan as Element,
            environmentSelect as Element
        ]);

        return environmentDiv;
    }

    private createPriorityDiv(): HTMLDivElement
    {
        let priorityDiv: HTMLDivElement = DomService.createDiv(this.defaultClass + '__priority');
        let prioritySpan: HTMLSpanElement = DomService.createSpan();
        let priorityInput: HTMLInputElement = DomService.createInput('', 'priority', this.moduleData.priority as string);

        prioritySpan.textContent = this.moduleData.priority as string;
        priorityInput.setAttribute('type', 'number');

        DomService.appendBatch(priorityDiv as Element, [
            prioritySpan as Element,
            priorityInput as Element
        ]);

        return priorityDiv;
    }

    private createControlsDiv(): HTMLDivElement
    {
        let controlsDiv: HTMLDivElement = DomService.createDiv(this.defaultClass + '__controls');
        let editButton: HTMLButtonElement = DomService.createButton(this.defaultClass + '__controls--button-edit', 'Edit');
        let saveButton: HTMLButtonElement = DomService.createButton(this.defaultClass + '__controls--button-save', 'Save');
        let deleteButton: HTMLButtonElement = DomService.createButton(this.defaultClass + '__controls--button-delete', 'Delete');

        editButton.setAttribute('data-entity', 'edit');
        saveButton.setAttribute('data-entity', 'save');

        DomService.appendBatch(controlsDiv as Element, [
            editButton as Element,
            saveButton as Element,
            deleteButton as Element
        ]);

        return controlsDiv;
    }
}
