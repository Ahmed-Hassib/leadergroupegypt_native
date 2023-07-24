
let deleted_client_name_in_modal = document.querySelector('#deleted-client-name');
let deleted_client_url_in_modal = document.querySelector('#deleted-client-url');

function confirm_delete_client(btn, will_back = null) {
  // get client info
  let client_id = btn.dataset.clientId;
  let client_name = btn.dataset.clientName;
  // prepare url
  let url = will_back == null ? `?do=delete-client&client-id=${client_id}` : `?do=delete-client&client-id=${client_id}&back=true`;
  // put it into the modal
  deleted_client_name_in_modal.textContent = `'${client_name}'`;
  deleted_client_url_in_modal.href = url;
}

