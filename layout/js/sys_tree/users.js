let profile_img_container = document.querySelector('#profile-image-container');
let profile_img_input = document.querySelector('#profile-img-input');
let profile_img = document.querySelector('#profile-img');


function click_input() {
  profile_img_input.click()
}

function change_profile_img(btn) {
  // get image path
  let img_path = URL.createObjectURL(btn.files[0]);
  // upload image
  profile_img.setAttribute("src", img_path);

  let profile_img_status = document.querySelector('#profile-img-status');
  if (profile_img_status != null) {
    profile_img_status.textContent = lang.save_changes_please;
    profile_img_status.classList.replace('text-danger', 'text-success')
  } else {
    let status = create_profile_img_status(lang.save_changes_please, 'text-success');
    profile_img_container.appendChild(status)
  }
}

function delete_profile_image() {
  profile_img.setAttribute("src", '../../../../data/uploads/employees-img/male-avatar.svg');

  let confirm_delete = confirm(lang.delete_confirm)

  if (confirm_delete) {
    // send request
    $.get(`../requests/index.php?do=delete-profile-img`, (data) => {
      if (data) {
        let profile_img_status = document.querySelector('#profile-img-status');
        if (profile_img_status != null) {
          console.log('deleted');
          profile_img_status.textContent = lang.success_del_emp_img;
          profile_img_status.classList.replace('text-success', 'text-danger');
        } else {
          let status = create_profile_img_status(lang.success_del_emp_img, 'text-danger');
          profile_img_container.appendChild(status)
        }
      }
    });
  }
}

function create_profile_img_status(status_text, text_class) {
  // append text to save chnges
  let span = document.createElement('span')
  span.textContent = status_text;
  span.classList.add('text-center', text_class);
  span.id = 'profile-img-status';

  return span;
}

/**
 * showUserModal function
 */
function show_delete_user_modal(btn, will_back = null) {
  // check the attribute
  if (btn.hasAttribute('data-user-id')) {
    // get user id and name
    let userid = btn.getAttribute('data-user-id');
    let username = btn.getAttribute('data-username');
    // get deleteUser page url
    let url = will_back != null ? `?do=delete-user-info&userid=${userid}&back=true` : `?do=delete-user-info&userid=${userid}`;
    // add username and url
    document.getElementById('deleted-username').textContent = username;
    document.getElementById('delete-user').setAttribute('href', url);
  }
}