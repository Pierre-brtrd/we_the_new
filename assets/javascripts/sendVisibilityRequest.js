export async function sendVisibilityRequest(url, input) {
    const response = await fetch(url);

    if (response.ok) {
        const data = await response.json();

        const label = input.nextElementSibling;

        if (data.enable) {
            label.innerHTML = 'Actif';
            label.classList.replace('text-danger', 'text-success');
        } else {
            label.innerHTML = 'Inactif';
            label.classList.replace('text-success', 'text-danger');
        }
    } else {
        if (document.querySelector('.alert.alert-danger')) {
            document.querySelector('.alert.alert-danger').remove();
        }

        const alert = document.createElement('div');
        alert.classList.add('alert', 'alert-danger');
        alert.innerHTML = 'Une erreur est survenue, veuillez réessayer';

        document.querySelector('main').prepend(alert);
    }
}