import { Request } from '../types/Request';
import { Response } from '../types/Response';
import { Header } from '../types/Header';

export class AjaxService
{
    public static request(url: string, method: string, data: Request = {}, headers: Header[] = [], jsonResponse: boolean = true ): Promise<Response>
    {
        return new Promise(resolve => {
            let xhr: XMLHttpRequest = new XMLHttpRequest;

            xhr.onload = () => {
                let responseJson: Response = { status: true };

                if ( jsonResponse ) {
                    try {
                        responseJson = JSON.parse(xhr.responseText);
                    } catch ( e ) {
                        responseJson.status = false;
                        responseJson.message = 'Failed response JSON parsing';
                        responseJson.response = xhr.responseText;
                    }
                } else {
                    responseJson.response = xhr.responseText;
                }

                resolve(responseJson);
            };

            xhr.onerror = () => {
                let responseJson: Response = { status: false };

                responseJson.message = xhr.statusText;

                resolve(responseJson);
            };

            if ( headers.length ) {
                for ( let header of headers ) {
                    xhr.setRequestHeader(header.name, header.value);
                }
            }

            xhr.open(method, url);
            xhr.send(JSON.stringify(data));
        });
    }
}
