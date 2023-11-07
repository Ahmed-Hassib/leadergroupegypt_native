(function () {
  // show or hide delete button
  show_hide_details_btn();
})()


function show_hide_details_btn() {
  // get all content containers
  let content_container = document.querySelectorAll('.feature-details .feature-details__content');
  // check length
  if (content_container.length == 1) {
    // if length == 1 hide delete button
    let delete_btn = document.querySelector('.delete-details')

    if (delete_btn != null) delete_btn.style.display = 'none';
  } else {
    // get delete buttons
    let delete_buttons = document.querySelectorAll('.delete-details');
    // loop on delete buttons
    delete_buttons.forEach(btn => {
      // if length > 1 show delete button
      btn.style.display = 'block';
    });
  }
}


function delete_feature_detail(btn) {
  // get container
  let content_conteiner = btn.parentElement.parentElement;
  // get feature detail id
  let detail_id = btn.dataset.featureDetailId;
  // confirm delete
  if (!confirm(lang.delete_confirm)) return;
  // send a request to delete detail
  $.get(`../requests/index.php?do=delete-detail&id=${detail_id}`, (data) => {
    // check result
    if ($.parseJSON(data) == true) {
      // delete container
      content_conteiner.remove();
      // check details delete buttons
      show_hide_details_btn();
      // success message
      alert(lang.delete_feature_succ);
    } else {
      // failed message
      alert(lang.delete_feature_faild);
    }
  })
}