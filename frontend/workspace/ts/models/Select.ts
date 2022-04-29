import { SelectOption } from './SelectOption';

export class Select
{
    private id: string = '';
    private options: SelectOption[] = [];
    private selected: null|SelectOption = null;

    public constructor(id: string = '', options: SelectOption[] = [])
    {
        this.id = id;
        this.appendOptions(options);
    }

    public getId(): string
    {
        return this.id;
    }

    public getOptions(): SelectOption[]
    {
        return this.options;
    }

    public appendOptions(options: SelectOption[] = []): void
    {
        this.options = this.options.concat(options);
    }

    public replaceOption(id: number, option: SelectOption): void
    {
        for ( let i = 0; i < this.options.length; i++ ) {
            if ( this.options[i].getId() === id ) {
                this.options[i] = option; break;
            }
        }
    }

    public select(id: number = 0): boolean
    {
        if ( id ) {
            for ( let option of this.options ) {
                if ( option.getId() == id ) {
                    option.selected(true);

                    this.setSelected(option);
                } else {
                    option.selected(false);
                }
            }

            return true;
        }

        this.selected = null;

        return false;
    }

    private setSelected(option: SelectOption): void
    {
        this.selected = option;
    }

    public getSelected(): null|SelectOption
    {
        return this.selected;
    }
}
