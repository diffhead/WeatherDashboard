export class DomService
{
    public static createElement(elementName: string, className: string = ''): HTMLElement
    {
        let $el = document.createElement(elementName);

        $el.classList.add(className);

        return $el;
    }

    public static createDiv(className: string): HTMLDivElement
    {
        return (<HTMLDivElement>DomService.createElement('div', className));
    }

    public static createButton(title: string, className: string = ''): HTMLButtonElement
    {
        let $button: HTMLButtonElement = (<HTMLButtonElement>DomService.createElement('button', className));

        $button.textContent = title;

        return $button;
    }

    public static append($parent: Element, $child: Element): void
    {
        $parent.appendChild($child);
    }

    public static appendBatch($parent: Element, children: Element[]): void
    {
        for ( let $el of children ) {
            $parent.appendChild($el);
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
