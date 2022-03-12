import { ValidationRules } from '../types/ValidationRules';
import { ValidationResult } from '../types/ValidationResult';
import { ValidationFields } from '../types/ValidationFields';
import { ValidationDescription } from '../types/ValidationDescription';

import { Model } from '../classes/Model';
import { ModelData } from '../types/ModelData';

import { FormValidationService } from '../services/FormValidationService';

export class Auth extends Model
{
    private validator: FormValidationService;

    public constructor(entity: string) 
    {
        let rules: ValidationRules = {};

        if ( entity === 'login' || entity === 'register' ) {
            rules = {
                login: {
                    required: true,
                    pattern: new RegExp('(?=.{5,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$', 'gm')
                },
                password: {
                    required: true,
                    pattern: new RegExp('^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,}$', 'gm')
                }
            };
        }

        if ( entity === 'register' || entity === 'reset' ) {
            rules.email = {
                required: true,
                pattern: new RegExp('^(([^<>()\\[\\]\\\.,;:\\s@"]+(\\.[^<>()\\[\\]\\\.,;:\\s@"]+)*)|(".+"))@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}])|(([a-zA-Z\\-0-9]+\\.)+[a-zA-Z]{2,}))$', 'gm')
            };
        }

        super();

        this.validator = new FormValidationService(rules);
    }

    public validate(): ValidationDescription
    {
        let description: ValidationDescription = [ true, {} ];

        description[0] = this.validator.validate(this.getData() as ValidationFields);
        description[1] = this.validator.getResult();

        return description;
    }
}
