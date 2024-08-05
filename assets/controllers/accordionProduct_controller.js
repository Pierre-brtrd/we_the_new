import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.querySelector('button').addEventListener('click', this.toggleAccordion.bind(this));
    }

    toggleAccordion(e) {
        const content = this.element.querySelector(e.currentTarget.dataset.target);
        content.classList.toggle('active');

        if (content.classList.contains('active')) {
            content.style.height = content.scrollHeight + 'px';
            e.currentTarget.querySelector('i').classList.replace('bi-plus', 'bi-dash');
        } else if (content.classList.contains('first')) {
            content.style.height = '3rem';
            e.currentTarget.querySelector('i').classList.replace('bi-dash', 'bi-plus');
        } else {
            content.style.height = 0;
            e.currentTarget.querySelector('i').classList.replace('bi-dash', 'bi-plus');
        }
    }
}
