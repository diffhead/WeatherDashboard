import { Request } from '../types/Request';
import { Response } from '../types/Response';

import { ValidationRules } from '../types/ValidationRules';
import { ValidationResult } from '../types/ValidationResult';
import { ValidationFields } from '../types/ValidationFields';
import { ValidationDescription } from '../types/ValidationDescription';

import { ModelDefinitions } from '../types/ModelDefinitions';

import { Model } from '../classes/Model';

import { AjaxService } from '../services/AjaxService';
import { FormValidationService } from '../services/FormValidationService';

import { ValidationSupport } from '../interfaces/ValidationSupport';

export class Module extends Model implements ValidationSupport
{
     private validator: FormValidationService;

     protected modelDefinitions: ModelDefinitions = {
         'name': 'string',
         'enable': 'number',
         'environment': 'string',
         'priority': 'number'
     };

     public constructor()
     {
         super();

         this.validator = new FormValidationService({
             'name': {
                 required: true,
                 pattern: new RegExp('^\w{2,}$')
             },
             'enable': {
                 required: true,
                 pattern: new RegExp('^\\d$', 'm')
             },
             'environment': {
                 required: true,
                 pattern: new RegExp('^(cli|web)$', 'm')
             },
             'priority': {
                 required: true,
                 pattern: new RegExp('^\\d{1,}$', 'm')
             }
         });
     }

     public validate(): ValidationDescription
     {
         let description: ValidationDescription = [ true, {} ];

         description[0] = this.validator.validate(this.getData() as ValidationFields);
         description[1] = this.validator.getResult();

         return description;
     }

     public async save(): Promise<Response>
     {
         return await AjaxService.request('/module/save', 'POST', this.getData());
     }

     public async create(): Promise<Response>
     {
         let response: Response = await AjaxService.request('/module/create', 'POST', this.getData());

         if ( response.status === true && response.module && response.moduleId ) {
             this.assignData({ id: response.moduleId as number });
         }

         return response;
     }

     public async delete(): Promise<Response>
     {
         return await AjaxService.request('/module/delete', 'POST', this.getData());
     }
}
