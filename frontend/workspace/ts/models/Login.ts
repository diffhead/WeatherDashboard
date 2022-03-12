import { ValidationResult } from '../types/ValidationResult';
import { ValidationFields } from '../types/ValidationFields';
import { ValidationDescription } from '../types/ValidationDescription';

import { Model } from '../classes/Model';
import { ModelData } from '../types/ModelData';

import { FormValidationService } from '../services/FormValidationService';

export class Login extends Model
{
    private formValidationService: FormValidationService;

    public constructor() 
    {
        super();

        this.formValidationService = new FormValidationService({
            login: {
                required: true,
                pattern: new RegExp('(?=.{5,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$', 'gm')
            },
            password: {
                required: true,
                pattern: new RegExp('^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,}$', 'gm')
            }
        });

        this.setData({ 
            login: '', 
            password: '' 
        });

        this.setDefinitions({
            login: 'string',
            password: 'string'
        });
    }

    public validate(): ValidationDescription
    {
        let description: ValidationDescription = [ true, {} ];

        description[0] = this.formValidationService.validate(this.getData() as ValidationFields);
        description[1] = this.formValidationService.getResult();

        return description;
    }
}
