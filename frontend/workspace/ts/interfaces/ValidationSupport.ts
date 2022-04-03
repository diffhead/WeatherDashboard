import { ValidationDescription } from '../types/ValidationDescription';

export interface ValidationSupport
{
    validate(): ValidationDescription;
}
