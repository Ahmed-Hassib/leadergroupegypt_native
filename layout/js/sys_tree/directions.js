(function () {
  // direction tree body
  let dir_tree_body = document.querySelector('.genealogy-body');
  // get updated dir select box
  let updated_dir = document.getElementById("updated-dir-name");
  // get updated dir id input
  let updated_dir_id = document.getElementById('updated-dir-id');
  // get new dir name input
  let new_dir_name = document.getElementById('new-direction-name');

  if (updated_dir != null) {
    // add event on updated direction select box
    updated_dir.addEventListener("change", (evt) => {
      evt.preventDefault();
      // set updated dir id 
      updated_dir_id.value = updated_dir.value;

      // set new dir name
      new_dir_name.value = updated_dir[updated_dir.selectedIndex].textContent;

      // assign dir id as an attribute to new dir
      // to check if new name is exist or not
      new_dir_name.dataset.id = updated_dir.value;
    })
  }

  // get previous button
  let prev_btn = document.querySelector(".scroll-button.scroll-prev");
  // get next button
  let next_btn = document.querySelector(".scroll-button.scroll-next");

  if (prev_btn != null && next_btn != null) {
    // add event when click on previous button
    prev_btn.addEventListener("click", (evt) => {
      evt.preventDefault();
      // get tree container
      let tree_container = next_btn.parentElement.parentElement;
      // increase scroll left value
      tree_container.scrollLeft -= 100;
    })
    // add event when click on previous button
    next_btn.addEventListener("click", (evt) => {
      evt.preventDefault();
      // get tree container
      let tree_container = next_btn.parentElement.parentElement;
      // increase scroll left value
      tree_container.scrollLeft += 100;
    })
  }

  if (dir_tree_body != null) {
    dir_tree_body.scrollLeft = dir_tree_body.offsetWidth / 2 * 3
  }

})()

/**
 * put_updated_dir_info function
 * is used to classify the operations wants to do on directions
 */
function put_dir_info(btn, type) {
  switch (type) {
    case 'update':
      put_updated_data(btn);
      break;

    case 'delete':
      put_deleted_data(btn);
      break;

    default:
      break;
  }
}


/**
 * put_updated_data function
 * is used to put direction info into update form
 */
function put_updated_data(btn) {
  // id
  var id = document.getElementById("updated-dir-id");
  // old ip
  var old_dir_name = document.getElementById("updated-dir-name");
  // new name
  var new_dir_name = document.getElementById("new-direction-name");
  // new ip
  var new_ip_addr = document.getElementById("new-direction-ip");

  // put values
  id.value = btn.dataset.directionId;
  old_dir_name.value = btn.dataset.directionId;
  new_dir_name.value = btn.dataset.directionName;
  new_dir_name.dataset.id = btn.dataset.directionId;
  // new_ip_addr.value = btn.dataset.directionIp;
}

/**
 * put_deleted_dir function
 * is used to put direction info into delete form
 */
function put_deleted_data(btn) {
  // id
  var id = document.getElementById("deleted-dir-id");
  // old ip
  var deleted_dir_name = document.getElementById("deleted-dir-name");

  // put values
  id.value = btn.dataset.directionId;
  deleted_dir_name.value = btn.dataset.directionId;
}

