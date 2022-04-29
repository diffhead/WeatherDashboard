import { View } from '../../../classes/View';

import { SelectWithInput } from '../../../views/SelectWithInput';
import { SelectOption } from '../../../models/SelectOption';

import { City as CityModel } from '../../../models/City';

import { City } from '../../../types/City';
import { Country } from '../../../types/Country';

import { Request } from '../../../types/Request';
import { Response } from '../../../types/Response';

import { DomService } from '../../../services/DomService';
import { AjaxService } from '../../../services/AjaxService';

export class Weather extends View
{
    private currentCity: null|CityModel = null;

    private citySelect: SelectWithInput;
    private countrySelect: SelectWithInput;

    private apikeyInput: HTMLInputElement;
    private apiuriInput: HTMLInputElement;

    private latitudeInput: HTMLInputElement;
    private longitudeInput: HTMLInputElement;

    public render(): boolean
    {
        if ( this.element === undefined ) {
            throw new Error('Weather view element wasnt initialized');
        }

        let firstCountry: Country = window.application.getCountries()[0];

        this.apikeyInput = DomService.findOne('.weather-settings__api--key-input', this.element) as HTMLInputElement;
        this.apiuriInput = DomService.findOne('.weather-settings__api--uri-input', this.element) as HTMLInputElement;

        this.latitudeInput = DomService.findOne('input[name="latitude"]', this.element) as HTMLInputElement;
        this.longitudeInput = DomService.findOne('input[name="longitude"]', this.element) as HTMLInputElement;

        this.citySelect = new SelectWithInput('weatherCitySelect');
        this.countrySelect = new SelectWithInput('weatherCountrySelect');

        this.filterCityOptionsByCountry(firstCountry.id);

        this.bindActions();

        return true;
    }

    private bindActions(): void
    {
        let apiSaveButton: HTMLButtonElement = DomService.findOne('.weather-settings__api--save-button', this.element) as HTMLButtonElement;
        let citySaveButton: HTMLButtonElement = DomService.findOne('.weather-coords-save--button', this.element) as HTMLButtonElement;

        this.latitudeInput.addEventListener('change', ({ target }) => {
            this.currentCity.assignData({
                latitude: Number((target as HTMLInputElement).value)
            })
        });

        this.longitudeInput.addEventListener('change', ({ target }) => {
            this.currentCity.assignData({
                longitude: Number((target as HTMLInputElement).value)
            });
        });

        this.element.addEventListener('select.option.selected', e => {
            if ( (e.target as HTMLDivElement).id === 'weatherCountrySelect' ) {
                this.citySelect.unselect();
                this.setCurrentCity();

                this.filterCityOptionsByCountry((e as CustomEvent).detail.getId());
            } else {
                this.setCurrentCity((e as CustomEvent).detail.getId());
            }
        });

        apiSaveButton.addEventListener('click', async () => {
            let request: Request = {
                'api': {
                    key: this.apikeyInput.value,
                    uri: this.apiuriInput.value
                }
            };

            let response: Response = await AjaxService.request('/weather/api/save', 'POST', request);

            if ( response.status === true ) {
                window.application.showNotification('Weather API', 'Saving settings successfully');
            } else {
                window.application.showNotification('Weather API', 'Saving settings failed', true);
            }
        });

        citySaveButton.addEventListener('click', async () => {
            if ( !this.currentCity ) {
                return false;
            }

            citySaveButton.setAttribute('disabled', 'disabled');

            let request: Request = this.currentCity.getData();
            let response: Response = await AjaxService.request('/weather/city/save', 'POST', request);

            if ( response.status === true ) {
                let city: City;
                let option: SelectOption;

                let cities: City[] = window.application.getCities();

                for ( let i = 0; i < cities.length; i++ ) {
                    if ( cities[i].id === request.id  ) {
                        city = request as City;

                        cities[i] = city;
                        option = new SelectOption(city.id, city.title, `${city.latitude} ${city.longitude}`, 1);

                        this.citySelect.replaceOption(option.getId(), option);
                        this.citySelect.select(option.getId(), false);

                        break;
                    }
                }

                window.application.updateCities(cities);
                window.application.showNotification('Weather City', 'Saving successfully');
            } else {
                window.application.showNotification(
                    'Weather City', response.message as string || 'Saving failed. See logs', true
                );
            }

            citySaveButton.removeAttribute('disabled');
        });
    }

    private setCurrentCity(city: number = 0): void
    {
        if ( city === 0 ) {
            this.currentCity = null;
            this.setLatLon(0, 0);
        } else {
            this.currentCity = new CityModel();

            for ( let _city of window.application.getCities() ) {
                if ( _city.id === city ) {
                    this.currentCity.setData(_city);
                }
            }

            this.setLatLon(this.currentCity.getLatitude(), this.currentCity.getLongitude());
        }
    }

    private filterCityOptionsByCountry(country: number): void
    {
        let cities: City[] = window.application.getCities();
        let citiesId: number[] = [];

        for ( let city of cities ) {
            if ( city.country === country ) {
                citiesId.push(city.id);
            }
        }

        this.citySelect.filterOptionsById(citiesId);
    }

    private clearLatLon(): void
    {
        this.latitudeInput.value = '';
        this.latitudeInput.setAttribute('data-active', '0');

        this.longitudeInput.value = '';
        this.longitudeInput.setAttribute('data-active', '1');
    }

    private setLatLon(lat: number, lon: number): void
    {
        let latStr: string = lat ? String(lat) : '';
        let lonStr: string = lon ? String(lon) : '';

        this.latitudeInput.value = latStr;
        this.longitudeInput.value = lonStr;
    }
}
