import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.querySelectorAll('.dropdown-item')
            .forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();

                    this.element.querySelector('#address_address').value = e.currentTarget.dataset.address;
                    this.element.querySelector('#address_zip_code').value = e.currentTarget.dataset.zipCode;
                    this.element.querySelector('#address_city').value = e.currentTarget.dataset.city;


                    // const address = e.currentTarget.dataset.address;
                    // const zipCode = e.currentTarget.dataset.zipCode;
                    // const city = e.currentTarget.dataset.city;

                    // const addressInput = this.element.querySelector('#address_address');
                    // const zipCodeInput = this.element.querySelector('#address_zip_code');
                    // const cityInput = this.element.querySelector('#address_city');

                    // addressInput.value = address;
                    // zipCodeInput.value = zipCode;
                    // cityInput.value = city;
                })
            })
    }
}
