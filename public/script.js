document.addEventListener('DOMContentLoaded', (event) => {

    const form = document.querySelector('form');

    form.addEventListener('submit', function (e) {

        e.preventDefault();

        const formData = new FormData(this);

        fetch('/send', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                alert('Запрос успешно отправлен!');
            })
            .catch(error => {
                console.error('There was a problem with your fetch operation:', error);
                alert('Ошибка при отправке запроса: ' + error.message);
            });
    });
});

