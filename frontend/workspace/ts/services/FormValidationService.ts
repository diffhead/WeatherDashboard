import { ValidationResult } from '../types/ValidationResult';
import { ValidationRules } from '../types/ValidationRules';
import { ValidationFields } from '../types/ValidationFields';

export class FormValidationService
{
    private validationRules: ValidationRules;
    private validationResult: ValidationResult;

    public constructor(rules: ValidationRules)
    {
        this.validationRules = rules;
    }

    public validate(form: ValidationFields): boolean
    {
        let status: boolean = true;
        let result: ValidationResult = {};

        for ( let field in this.validationRules ) {
            let rule: { pattern?: RegExp, required?: boolean } = this.validationRules[field];
            let test: { status: boolean, message: string } = { status: true, message: '' };

            if ( rule.required && form[field] === undefined ) {
                status = false;

                test.status = false;
                test.message = `Required field '${field}' not found`;

                result[field] = test;
            } else if ( rule.pattern && form[field].match(rule.pattern) === null ) {
                status = false;

                test.status = false;
                test.message = `Field '${field}' pattern testing failed`;

                result[field] = test;
            } else {
                test.status = true;
                test.message = 'OK';

                result[field] = test;
            }
        }

        this.validationResult = result;

        return status;
    }

    public getResult(): ValidationResult
    {
        if ( this.validationResult === undefined ) {
            this.validationResult = {};
        }

        return this.validationResult;
    }
}
