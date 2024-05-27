import { Controller } from '@hotwired/stimulus';
import { sendVisibilityRequest } from '../javascripts/sendVisibilityRequest';

export default class extends Controller {
    connect() {
        const input = this.element.querySelector('input');

        input.addEventListener('change', (e) => {
            const id = e.currentTarget.dataset.switchVisibilityId;
            sendVisibilityRequest(`/admin/gender/${id}/switch`, e.target);
        });
    }
}
