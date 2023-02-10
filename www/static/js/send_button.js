document.querySelector('#send').onclick = async function(){ //реакция на событие нажатия кнопки с id = send
    let data = {                                            //подготавливаем ассоциативный массив для отправки в запросе
        name: document.forms.form.elements.name.value,
        mail: document.forms.form.elements.mail.value,
        link: document.forms.form.elements.link.value,
        submit: 'send'                                     //для правильной отработки процесса в Controller.php
    };

    let response = await fetch('Controller.php', {       //отправка запроса в формате json
        method: 'POST',
        headers: {'Content-Type': 'application/json;charset=utf-8'},
        body: JSON.stringify(data)
    });
    if(response.ok){                                       //ответ на запрос
        alert(response.headers.get('Message'));
        /*let result = response.json();
        alert(result.message)*/
    }
    else {
        alert("Ошибка HTTP: " + response.status);
    }
    //чистка всех полей формы
    document.forms.form.elements.name.value = '';
    document.forms.form.elements.mail.value = '';
    document.forms.form.elements.link.value = '';
}