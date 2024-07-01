import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        const slide = this.element.nextElementSibling;
        const button = this.element;

        this.element.addEventListener('click', () => {
            slide.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!slide.contains(e.target) && !button.contains(e.target)) {
                slide.classList.remove('active');
            }
        });
    }
}
