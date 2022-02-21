import { Response } from '../types/response.type';
import { Request } from '../types/request.type';

export class AjaxService
{
    public static request( url: string, method: string = 'GET', request: Request = {}): Promise<Response>
    {
        return new Promise((resolve) => {
            let xhr: XMLHttpRequest = new XMLHttpRequest;

            xhr.onload = () => {
                let responseJson: Response = { 
                    status: false, 
                    message: '', 
                    extended: '' 
                };
                
                try {
                    responseJson = JSON.parse(xhr.responseText);
                } catch ( e ) {
                    responseJson.message = e;
                }

                resolve(responseJson);
            };

            xhr.onerror = () => {
                let responseJson: Response = {
                    status: false,
                    message: '',
                    extended: ''
                };

                responseJson.message = xhr.statusText;

                resolve(responseJson);
            };

            xhr.open(method, url);
            xhr.send(JSON.stringify(request));
        });
    }
}