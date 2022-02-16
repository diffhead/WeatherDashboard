import { Component } from '../interfaces/component.interface';

export class InputComponent implements Component
{
    private valid: boolean = false;
    private value: string = '';
    private inited: boolean = false;

    private $input: HTMLInputElement;

    public constructor(selector: string)
    {
        let $input: HTMLInputElement|null = document.querySelector(selector);

        if ( $input === null  ) {
            throw new Error("Input element not found");
        }

        this.$input = $input;

        this.init();
    }

    public init(): void
    {
        if ( this.inited === false ) {
            this.value = this.$input.value;
            this.valid = this.$input.classList.contains('invalid') === false;
            this.inited = true;

            this.$input.addEventListener('input', () => {
                if ( this.valid === false ) {
                    this.setValid(true);
                }

                this.setValue(this.$input.value);
            });
        }
    }

    public draw(): boolean
    {
        return true;
    }

    public setValue(value: string): boolean
    {
        this.value = value;

        return true;
    }

    public getValue(): string
    {
        return this.value;
    }

    public validate(pattern: RegExp): boolean
    {
        return this.setValid(!!this.value.match(pattern));
    }

    private setValid(value: boolean): boolean
    {
        this.valid = value;

        if ( value ) {
            this.$input.classList.remove('invalid');
        } else {
            this.$input.classList.add('invalid');
        }

        return this.valid;
    }
}
