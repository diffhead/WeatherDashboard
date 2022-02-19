import { Response } from '../types/response.type';
import { Request } from '../types/request.type';

import { AjaxService } from './ajax.service';

export class AuthService
{
    public static loginRequest(loginData: Request): Promise<Response>
    {
        return AjaxService.request('/api/login', 'POST', loginData);
    }

    public static registerRequest(registerData: Request): Promise<Response>
    {
        return AjaxService.request('/api/register', 'POST', registerData);
    }
}
