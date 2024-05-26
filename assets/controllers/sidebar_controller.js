import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        const toggleBtn = this.element.querySelector('#toggle-btn');
        const sidebar = this.element;

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    }
}
