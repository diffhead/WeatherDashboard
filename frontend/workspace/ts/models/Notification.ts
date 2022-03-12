import { Model } from '../classes/Model';
import { ModelData } from '../types/ModelData';
import { ModelDefinitions} from '../types/ModelDefinitions';

export class Notification extends Model
{
    protected modelData: ModelData = {
        error: false,
        title: 'Notification',
        visible: false,
        message: ''
    }

    protected modelDefinitions: ModelDefinitions = {
        error: 'bool',
        title: 'string',
        visible: 'bool',
        message: 'string'
    }
}
