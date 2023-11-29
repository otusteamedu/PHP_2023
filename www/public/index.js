function sendForm()
{
    const form = document.getElementById('Form');
    const params = new FormData(form);

    let xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            const result = JSON.parse(xmlHttp.responseText);
            if (result != null) {
                let out = '';
                for (let idx = 0; idx < result.length; idx++) {
                    out += '<div>' + result[idx] + '</div>';
                }
                document.getElementById('Result').innerHTML = out;
            }
        }
    }
    xmlHttp.open("post", form.action);
    xmlHttp.send(params);
}

