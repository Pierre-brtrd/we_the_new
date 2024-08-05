import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.querySelectorAll('.add_item_link')
            .forEach(btn => {
                btn.addEventListener('click', this.addFormToCollection.bind(this));
            });

        this.element.querySelectorAll('.remove_item_link')
            .forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    btn.parentNode.remove();
                });
            })

    }

    addFormToCollection(e) {
        const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

        const item = document.createElement('li');
        item.classList.add('col-md-4');

        item.innerHTML = collectionHolder
            .dataset
            .prototype
            .replace(
                /__name__/g,
                collectionHolder.dataset.index
            );

        this.addTagFormDeleteLink(item);

        collectionHolder.appendChild(item);

        collectionHolder.dataset.index++;
    }

    addTagFormDeleteLink(item) {
        const removeFormButton = document.createElement('button');
        removeFormButton.innerHTML = '<i class="bi bi-x-square-fill"></i>';
        removeFormButton.classList.add('btn', 'btn-danger')

        item.prepend(removeFormButton);

        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            item.remove();
        });
    }
}
