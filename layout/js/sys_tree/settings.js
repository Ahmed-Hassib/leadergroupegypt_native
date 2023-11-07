let company_img_container = document.querySelector('#company-image-container');
let company_img_input = document.querySelector('#company-img-input');
let company_img = document.querySelector('#company-img');
let change_company_img_btn = document.querySelector('#change-company-img-btn');


function click_input() {
  company_img_input.click()
}

function change_company_img(btn) {
  // get image path
  let img_path = URL.createObjectURL(btn.files[0]);
  // upload image
  company_img.setAttribute("src", img_path);

  let company_img_status = document.querySelector('#company-img-status');
  if (company_img_status != null) {
    company_img_status.textContent = 'برجاة حفظ التغييرات';
    company_img_status.classList.remove('text-danger', 'text-muted')
    company_img_status.classList.add('text-success')
  } else {
    let status = create_company_img_status('برجاة حفظ التغييرات', 'text-success');
    company_img_container.appendChild(status)
  }

  change_company_img_btn.classList.remove('d-none')
}

function delete_company_image() {
  company_img.setAttribute("src", '../../../../data/uploads/companies-img/leadergroupegypt.jpg');

  let confirm_delete = confirm(lang.confirm);

  if (confirm_delete) {
    // send request
    $.get(`../requests/index.php?do=delete-company-img`, (data) => {
      if (data) {
        let company_img_status = document.querySelector('#company-img-status');
        if (company_img_status != null) {
          console.log('deleted');
          company_img_status.textContent = 'تم حذف الصورة بنجاح!\n برجاء تحديث الجلسة لتطبيق التغييرات';
          company_img_status.classList.remove('text-danger', 'text-muted')
          company_img_status.classList.add('text-success')
        } else {
          let status = create_company_img_status('تم حذف الصورة بنجاح!\n برجاء تحديث الجلسة لتطبيق التغييرات', 'text-danger');
          company_img_container.appendChild(status)
        }
      }
    });
  }
}

function create_company_img_status(status_text, text_class) {
  // append text to save chnges
  let span = document.createElement('span')
  span.textContent = status_text;
  span.classList.remove('text-danger', 'text-muted', 'text-success')
  span.classList.add('text-center', text_class);
  span.id = 'company-img-status';

  return span;
}

function check_mikrotik_info(evt, form) {
  // get modal body if
  let modal_id = evt.dataset.bsTarget;
  // get mikrotik ip or hostname
  let host = form.elements['mikrotik-ip'].value;
  // get mikrotik port
  let port = form.elements['mikrotik-port'].value;
  // get mikrotik password
  let password = form.elements['mikrotik-password'].value;
  // get mikrotik username
  let username = form.elements['mikrotik-username'].value;

  let data = [host, port, username, password];

  evt.classList.add('disabled');
  evt.children[0].classList.add('d-none');
  evt.children[1].classList.remove('d-none');

  $.get(`../requests/index.php?do=check-mikrotik-info&data=${JSON.stringify(data)}`, function (response) {
    // convert response
    let is_connected = JSON.parse(response);
    // hide loader
    document.querySelector(`${modal_id} .modal-header`).children[1].classList.remove('d-none');
    document.querySelector(`${modal_id} .modal-body`).children[0].classList.add('d-none');
    document.querySelector(`${modal_id} .modal-footer button`).classList.remove('disabled');
    document.querySelector(`${modal_id} .modal-footer button`).children[0].classList.remove('d-none');
    document.querySelector(`${modal_id} .modal-footer button`).children[1].classList.add('d-none');
    // reset check connection button
    evt.classList.remove('disabled');
    evt.children[0].classList.remove('d-none');
    evt.children[1].classList.add('d-none');
    // update modal content
    update_modal_body(modal_id, is_connected);
  });
}

function clear_modal_body(modal_id) {
  // get modal header
  let modal_header = document.querySelector(`${modal_id} .modal-header`);
  // get modal body
  let modal_body = document.querySelector(`${modal_id} .modal-body`);
  // get modal footer
  let modal_footer_button = document.querySelector(`${modal_id} .modal-footer button`);
  // clear modal body
  if (modal_body.childElementCount > 1) {
    // reset modal header
    modal_header.children[1].classList.add('d-none');
    // reset modal body
    modal_body.children[0].classList.remove('d-none');
    modal_body.children[1].remove();
    // reset modal footer
    modal_footer_button.classList.add('disabled');
    modal_footer_button.children[0].classList.add('d-none');
    modal_footer_button.children[1].classList.remove('d-none');
  }
}

function update_modal_body(modal_id, status) {
  // get modal body
  let modal_body = document.querySelector(`${modal_id} .modal-body`);
  // create a div for put content
  let div = document.createElement('div');
  div.classList.add(status ? 'text-success' : 'text-danger');
  div.textContent = status ? lang.connected : lang.failed_connection;
  // append div into modal body
  modal_body.appendChild(div);
}