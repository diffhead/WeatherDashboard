import { View } from '../../../classes/View';

import { Module as ModuleView } from '../../Module';
import { Module as ModuleModel } from '../../../models/Module';

import { DomService } from '../../../services/DomService';

export class Modules extends View
{
    private moduleViews: ModuleView[] = [];

    public render(): boolean
    {
        if ( this.element === undefined ) {
            return false;
        }

        let moduleItems: NodeList = DomService.findAll('.module-item[data-id][data-name][data-enable][data-environment]');

        moduleItems.forEach(node => {
            let moduleView: ModuleView = new ModuleView();
            let moduleModel: ModuleModel = new ModuleModel();
            let enableCheckbox: HTMLInputElement = DomService.findOne('.module-item__enable-input', node as Element) as HTMLInputElement;

            moduleModel.setData({
                'id': Number((node as Element).getAttribute('data-id')),
                'name': (node as Element).getAttribute('data-name'),
                'environment': (node as Element).getAttribute('data-environment'),
                'priority': (node as Element).getAttribute('data-priority'),
                'enable': enableCheckbox.checked ? 1 : 0
            });

            moduleView.setElement(node as Element);
            moduleView.setModel(moduleModel);
            
            moduleView.render();

            this.moduleViews.push(moduleView);
        });

        return true;
    }
}
