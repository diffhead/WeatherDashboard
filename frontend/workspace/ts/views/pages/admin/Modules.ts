import { View } from '../../../classes/View';

import { ModelData } from '../../../types/ModelData';

import { Module as ModuleView } from '../../Module';
import { Module as ModuleModel } from '../../../models/Module';

import { DomService } from '../../../services/DomService';
import { DomModuleItemService } from '../../../services/DomModuleItemService';

export class Modules extends View
{
    public render(): boolean
    {
        if ( this.element === undefined ) {
            return false;
        }

        let moduleItems: NodeList = DomService.findAll('.module-item:not(.decoration)', this.element);
        let moduleNewItem: Element = DomService.findOne('.module-item[data-id="NULL"]', this.element);
        let moduleNewItemView: ModuleView = new ModuleView();
        let moduleNewItemModel: ModuleModel = new ModuleModel();

        moduleNewItemModel.setData(this.getModelDataFromElement(moduleNewItem));

        moduleNewItemView.setElement(moduleNewItem);
        moduleNewItemView.setModel(moduleNewItemModel);

        moduleNewItemView.render();

        moduleItems.forEach(node => {
            let moduleView: ModuleView = new ModuleView();
            let moduleModel: ModuleModel = new ModuleModel();
            let enableCheckbox: HTMLInputElement = DomService.findOne('.module-item__enable-input', node as Element) as HTMLInputElement;

            moduleModel.setData(this.getModelDataFromElement(node as Element));

            moduleView.setElement(node as Element);
            moduleView.setModel(moduleModel);
            
            moduleView.render();
        });

        this.element.addEventListener('module:created', e => {
            this.createNewModuleItem((e as CustomEvent).detail);
        });

        this.element.addEventListener('module:removed', e => {
            this.deleteModuleItem((e as CustomEvent).detail)
        })

        return true;
    }

    private getModelDataFromElement(element: Element): ModelData
    {
        return {
            'id': Number(element.getAttribute('data-id')),
            'name': element.getAttribute('data-name'),
            'environment': element.getAttribute('data-environment'),
            'priority': element.getAttribute('data-priority'),
            'enable': element.getAttribute('data-enable')
        };
    }

    private createNewModuleItem(module: ModelData): void
    {
        let moduleItemService: DomModuleItemService = new DomModuleItemService(module);
        let moduleItemElement: HTMLDivElement = moduleItemService.createDomItem();
        let moduleItemView: ModuleView = new ModuleView();
        let moduleItemModel: ModuleModel = new ModuleModel();

        DomService.appendBefore(this.element.lastElementChild, moduleItemElement);

        moduleItemModel.setData(module);

        moduleItemView.setModel(moduleItemModel);
        moduleItemView.setElement(moduleItemElement)

        moduleItemView.render();
    }

    private deleteModuleItem(module: ModelData): void
    {
        let selectorParts: string[] = [ '.module-item' ];
        let selector: string = '';
        let itemElement: null|HTMLDivElement = null;

        for ( let prop in module ) {
            selectorParts.push(`[data-${prop}="${module[prop]}"]`);
        }

        selector = selectorParts.join('');
        itemElement = DomService.findOne(selector, this.element) as HTMLDivElement;

        if ( itemElement === null ) {
            throw new Error("Module item element not found");
        }

        itemElement.remove();
    }
}
