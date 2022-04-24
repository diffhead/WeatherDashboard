export class DomService
{
    public static createElement(elementName: string, className: string = ''): HTMLElement
    {
        let el = document.createElement(elementName);

        if ( className.length ) {
            el.classList.add(className);
        }

        return el;
    }

    public static createDiv(className: string = ''): HTMLDivElement
    {
        return DomService.createElement('div', className) as HTMLDivElement;
    }

    public static createButton(title: string, className: string = ''): HTMLButtonElement
    {
        let button: HTMLButtonElement = DomService.createElement('button', className) as HTMLButtonElement;

        button.textContent = title;

        return button;
    }

    public static createInput(className: string = '', name: string = '', value: string = ''): HTMLInputElement
    {
        let input: HTMLInputElement = DomService.createElement('input', className) as HTMLInputElement;

        input.name = name;
        input.value = value;

        return input;
    }

    public static createSpan(className: string = ''): HTMLSpanElement
    {
        let span: HTMLSpanElement = DomService.createElement('span', className) as HTMLSpanElement;

        return span;
    }

    public static append(parent: Element, child: Element): void
    {
        parent.appendChild(child);
    }

    public static appendBatch(parent: Element, children: Element[]): void
    {
        for ( let el of children ) {
            parent.appendChild(el);
        }
    }
    
    public static createText(text: string): Text
    {
        return document.createTextNode(text);
    }

    public static findOne(selector: string, contextElement: Element|Document = document): null|Element
    {
        return contextElement.querySelector(selector);
    }

    public static findAll(selector: string, contextElement: Element|Document = document): null|NodeList
    {
        return contextElement.querySelectorAll(selector);
    }
}
