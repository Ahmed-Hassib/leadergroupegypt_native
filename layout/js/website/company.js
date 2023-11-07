function add_new_phone(btn, container) {
  // next phone id
  let next_id = Number(btn.dataset.phoneNum);
  // get phone number
  let phone_name = `${lang.phone_number} ${next_id + 1}`;
  // get phone number
  let phone_number = `phone-${next_id + 1}`;
  // check number of phones
  if (next_id < 5) {
    // create label
    let label = document.createElement('label');
    label.classList.add('form-label', 'text-capitalize', 'phone-label');
    label.setAttribute('for', phone_number);
    label.textContent = phone_name;

    // create input
    let input = document.createElement('input')
    input.classList.add('form-control');
    input.setAttribute('type', 'text');
    input.setAttribute('id', phone_number);
    input.setAttribute('name', 'phone[]');
    input.setAttribute('autocomplete', 'off');
    input.setAttribute('required', 'required');

    // create a delete icon
    let trash_icon = document.createElement('i')
    trash_icon.classList.add('bi', 'bi-trash');

    // create a delete button
    let del_btn = document.createElement('button');
    del_btn.classList.add('btn', 'btn-danger', 'w-100', 'h-100');
    del_btn.setAttribute('type', 'button');
    del_btn.appendChild(trash_icon)

    // create a delete button container
    let del_btn_container = document.createElement('div')
    del_btn_container.appendChild(del_btn);

    // create input container
    let input_container = document.createElement('div');
    input_container.classList.add('form-floating');

    // create phone container
    let phone_container = document.createElement('div')
    phone_container.classList.add('phone-content')

    // append input into container
    input_container.appendChild(input);
    input_container.appendChild(label)

    // append phone content into container
    phone_container.appendChild(input_container)
    phone_container.appendChild(del_btn_container)

    del_btn.addEventListener("click", (evt) => {
      evt.preventDefault();
      // delete phone number
      delete_phone(phone_container);
    })
    // append phone container into container
    container.appendChild(phone_container)
    // update phone number of button
    btn.dataset.phoneNum = Number(btn.dataset.phoneNum) + 1;
  } else {
    // display a message of a maximum number of phones
    alert(lang.max_num_phones);
  }
}


function delete_phone(phone) {
  // remove phone field
  phone.remove();
  // get phones labels
  let phone_labels = document.querySelectorAll('.phone-label');
  // loop on it to modify text
  phone_labels.forEach((label, key) => {
    // set text
    label.textContent = `${lang.phone_number} ${key + 1}`;
  });
  // reset phones number
  btn.dataset.phoneNum = Number(btn.dataset.phoneNum) - 1;
}