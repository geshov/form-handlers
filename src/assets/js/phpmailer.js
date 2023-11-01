(() => {
  const form = document.querySelector(".form");
  const submit = form.querySelector("[type='submit']");
  const action = form.dataset.action + "?email=" + form.dataset.email;
  form.addEventListener("submit", (event) => {
    event.preventDefault();
    submit.setAttribute("disabled", "");
    form.classList.remove("form-sended", "form-error");
    form.classList.add("form-sending");
    // это сообщение в консоль можно удалить
    console.log("Отправка сообщения...");
    const formdata = new FormData(form);
    fetch(action, {
      method: "POST",
      body: formdata
    })
      .then(response => response.text())
      .then(text => {
        form.classList.remove("form-sending", "form-error");
        form.classList.add("form-sended");
        // это сообщение в консоль можно удалить
        console.log("Сообщение отправлено.");
        setTimeout(() => {
          submit.removeAttribute("disabled");
          form.classList.remove("form-sended");
          form.reset();
        }, form.dataset.timeout);
      })
      .catch(error => {
        submit.removeAttribute("disabled");
        form.classList.remove("form-sending", "form-sended");
        form.classList.add("form-error");
        // это сообщение в консоль лучше не удалять
        console.log(error);
      });
  });
})();
