
const routes = {
    period: '/api/v1/statement/period'
};

const forms = document.querySelectorAll('.email-form');
const resultContainer = document.querySelector('.result-container');

const addEvent = (form) => {
    form.addEventListener('submit', (event) => {
        event.preventDefault();

        clearResult();
        clearErrors();

        let enabledSend = false;
        let route = null;
        let formData = null;

        const form = event.target;

        if (form.classList.contains('simpleEmail')) {
            enabledSend = true;
            route = routes.period;
            formData = {
                email: form.elements['email'].value,
                dateStart: form.elements['dateStart'].value,
                dateEnd: form.elements['dateEnd'].value
            };
        }

        if (!enabledSend) {
            return;
        }

        (async () => {
            const result = await sendPostRequest(route, formData);

            if (result.error) {
                renderErrors(result.error);
            }

            if (result.result) {
                renderResult(result.result);
            }
        })();
    });
}

forms.forEach((form) => {addEvent(form)});

const sendPostRequest = async (route, data) => {

    const headers = {
        'Content-Type': 'multipart/form-data'
    }

    try {
        const response = await axios.post(route, data, {
            headers: headers
        });
        return response.data;
    } catch (err) {
        console.error(err);
    }
};

const renderResult = (result) => {
    const fragment = document.createDocumentFragment();

    const item = document.createElement('div');
    item.classList.add('text-success');
    item.textContent = result;
    fragment.appendChild(item);

    resultContainer.appendChild(fragment);
}

const renderErrors = (errors) => {

    for (let name in errors) {
        const fieldName = name.replace(/[\[, \]]/gi, '');
        const el = document.getElementsByName(fieldName)[0];
        const errorBox = el.previousElementSibling;
        const messages = errors[name];
        const fragment = document.createDocumentFragment();

        el.classList.add('is-invalid');

        for (let key in messages) {
            const message = messages[key];
            const item = document.createElement('div');
            item.classList.add('text-danger');
            item.textContent = message;
            fragment.appendChild(item);
        }

        errorBox.appendChild(fragment);
    }
}

const clearResult = () => {
    resultContainer.innerHTML = '';
}

const clearErrors = () => {
    const errorBoxes = document.querySelectorAll('.error-box');
    const inputs = document.querySelectorAll('input');

    errorBoxes.forEach((errorBox) => {
        for (let i=0; i < errorBox.childNodes.length; i++) {
            errorBox.childNodes[i].remove();
        }
    });

    inputs.forEach((input) => {
        input.classList.remove('is-invalid');
    });
}
