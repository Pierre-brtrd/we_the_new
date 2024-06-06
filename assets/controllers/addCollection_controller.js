import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.querySelectorAll('.add_item_link').forEach(btn => {
            btn.addEventListener('click', this.addFormToCollection.bind(this));
        });

        this.element.querySelectorAll('.remove_item_link').forEach(btnRemove => {
            btnRemove.addEventListener('click', () => {
                btnRemove.parentNode.remove();
            })
        });
    }

    addFormToCollection(e) {
        const collectionHolder = this.element.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

        const item = document.createElement('li');
        item.classList.add('col-md-4');

        item.innerHTML = collectionHolder
            .dataset
            .prototype
            .replace(
                /__name__/g,
                collectionHolder.dataset.index
            );

        this.addDeleteCollection(item);

        collectionHolder.appendChild(item);

        collectionHolder.dataset.index++;
    }

    addDeleteCollection(item) {
        const btnRemove = document.createElement('button');
        btnRemove.setAttribute('type', 'button');
        btnRemove.classList.add('btn', 'btn-danger');

        btnRemove.innerHTML = '<i class="bi bi-x-square-fill"></i>';

        item.prepend(btnRemove);

        btnRemove.addEventListener('click', (e) => {
            e.preventDefault();

            item.remove();
        });
    }
}
