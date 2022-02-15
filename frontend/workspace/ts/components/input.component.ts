import { Component } from '../interfaces/component.interface';

export class InputComponent implements Component
{
    private value: string = '';
    private inited: boolean = false;
    private invalid: boolean = false;

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
            this.invalid = this.$input.classList.contains('invalid');
            this.inited = true;

            this.$input.addEventListener('input', () => {
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
        this.invalid = !!this.value.match(pattern) === false;

        if ( this.invalid ) {
            this.$input.classList.add('invalid');
        } else {
            this.$input.classList.remove('invalid');
        }

        return this.invalid;
    }
}
