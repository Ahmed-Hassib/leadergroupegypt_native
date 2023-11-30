
var client_id_search = document.querySelector("#client-id");
var client_name_search = document.querySelector("#client-name");
var client_name_result = document.querySelector('#clients-names');
var delete_mal_btn = document.querySelectorAll('#delete-mal');
var confirm_delete_malfunction = document.querySelector("#confirm-delete-malfunction");
var modal = document.querySelector("#media-modal");
var modal_content = document.querySelector("#media-modal-content");
var modal_close_btn = document.querySelector("#media-modal-close");


function put_mal_data_into_modal(btn, will_back = null) {
  let mal_id = btn.dataset.malId;
  href = will_back != null ? `?do=delete-malfunction&mal-id=${mal_id}&back=true` : `?do=delete-malfunction&mal-id=${mal_id}`;
  confirm_delete_malfunction.setAttribute('href', href);
}


/**
 * search_name function
 * this function is used to search about the client name
 */
function search_name(input) {
  // get name to search
  let client_name = input.value;
  let company_id = input.dataset.companyId;
  // check if client name box is empty or not
  if (client_name != '' && client_name.length != 0) {
    // send request
    $.get(`../requests/index.php?do=search&client-name=${client_name}&company-id=${company_id}`, (data) => {
      // convert the json data into string
      let src = $.parseJSON(data);
      // clear all previous clients names
      client_name_result.innerHTML = '';
      // check the result length
      if (src.length > 0) {
        // loop on data result to display the src
        for (let i = 0; i < src.length; i++) {
          // create a new li element
          let li = document.createElement('li');
          // add client id as an attribute
          li.setAttribute('data-id', src[i]['id']);
          // add client name as a text content
          li.textContent = src[i]['full_name'];
          // add event
          li.addEventListener('click', function (evt) {
            client_name_search.value = li.textContent;
            client_name_search.dataset.valid = true;
            client_id_search.value = li.getAttribute('data-id');
            // clear all previous clients names
            client_name_result.innerHTML = '';
            // show the result
            client_name_result.style.display = 'none';
          });
          // add an event when click on the one of the clients
          client_name_result.appendChild(li);
        }
      }
    });
    // show the result
    client_name_result.style.display = 'block';
  } else {
    // clear all previous clients names
    client_name_result.innerHTML = '';
    // hide the result
    client_name_result.style.display = 'none';
    // clear client id
    client_id_search.value = '';
  }
}

/**
 * 
 */
function show_media_preview(evt) {
  // total size
  let total_size = 0;
  // get media container
  let media_container = document.querySelector('#media-container');
  // file inputs container
  let file_inputs_container = document.querySelector('#file-inputs');
  // loop on files of the form
  for (let i = 0; i < evt.files.length; i++) {
    // uploaded type
    let type = evt.files[i]['type'].includes('video') ? 'video' : 'img';
    // get size
    total_size += evt.files[i]['size'];
    // create the image src
    var src = URL.createObjectURL(evt.files[i]);
    // create a colomn to append the image
    let col = document.createElement('div');
    col.classList.add('media-content');
    // element that will append to the preview box
    let element;
    // switch ... case ...
    switch (type) {
      case 'video':
        element = create_video_element(src);
        media_type = 'mp4';
        break;

      case 'img':
        // create image
        element = document.createElement('img');
        element.setAttribute('src', src);
        element.setAttribute('class', 'w-100 h-100');
        media_type = 'jpg';
        break;
    }
    // append image into column
    col.appendChild(element);
    // create a control button
    let control_btns = create_control_buttons(src, media_type);
    // append control buttons
    col.appendChild(control_btns);
    // append column into the preview box
    media_container.appendChild(col)
  }

  if (total_size > 45000000) {
    // show alert
    alert('حجم الملفات كبير! برجاء مسح بعض منها!!');
    // delete all file inputs
    file_inputs_container.innerHTML = '';
    // delete all media
    media_container.innerHTML = '<div class="alert alert-danger"><h6 class="h6 text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;لا يوجد صور او فيديوهات لعرضها</h6 ></div>';
  }
}


function create_video_element(video_src) {
  // create video
  let video_element = document.createElement('video');
  // video_element.classList.add('w-100', 'h-100');
  video_element.autoplay = 'autoplay';
  video_element.muted = true;
  video_element.controls = true;
  // video_element.loop = true;

  // create source tag
  let video_source_mp4 = document.createElement('source');
  video_source_mp4.src = video_src;
  video_source_mp4.type = `video/mp4`;
  video_element.appendChild(video_source_mp4);

  // create source tag
  let video_source_mov = document.createElement('source');
  video_source_mov.src = video_src;
  video_source_mov.type = `video/mov`;
  video_element.appendChild(video_source_mov);

  // create source tag
  let video_source_webm = document.createElement('source');
  video_source_webm.src = video_src;
  video_source_webm.type = `video/webm`;
  video_element.appendChild(video_source_webm);

  // return video element
  return video_element;
}

function add_new_media() {
  // get media container
  let media_container = document.querySelector('#media-container');
  // file inputs
  let file_inputs_container = document.querySelector('#file-inputs');
  // check media container
  if (media_container.childElementCount == 1) {
    // media container element
    let element = media_container.children[0];
    // remove all container element
    if (element.classList.contains('alert')) {
      setTimeout(() => {
        media_container.innerHTML = '';
      }, 1500);
    }
  }
  // create file input
  let file_input = create_input_file();
  // append file input into media container
  file_inputs_container.append(file_input);
  // fire click
  file_input.click();
}

function create_input_file() {
  // create a media input
  let input = document.createElement('input');
  input.type = 'file';  // input type
  input.name = 'mal-media[]';   // input name
  input.setAttribute('multiple', 'multiple');
  input.setAttribute('form', 'edit-malfunction-info');
  // input.setAttribute('accept', 'image/*')
  // input.classList.add('d-none');
  // add event
  input.addEventListener('change', (evt) => {
    evt.preventDefault();
    // check files
    if (input.files.length > 0) {
      // show media
      show_media_preview(input);
    }
  })
  // return input
  return input;
}

function create_control_buttons(src, type) {
  // create delete button
  let delete_button = document.createElement('button');
  delete_button.type = 'button';
  delete_button.classList.add('btn', 'btn-danger', 'py-1', 'ms-1');
  delete_button.innerHTML = "<i class='bi bi-trash'></i>";
  // create buttons container
  let btn_container = document.createElement('div');
  btn_container.classList.add('control-btn');
  // add event to delete button
  delete_button.addEventListener('click', (evt) => {
    evt.preventDefault()
    delete_button.parentElement.parentElement.remove();
  })

  // create delete button
  let download_button = document.createElement('a');
  download_button.setAttribute('download', 'download');
  download_button.classList.add('btn', 'btn-primary', 'py-1', 'ms-1');
  download_button.innerHTML = "<i class='bi bi-download'></i>";
  // add event to delete button
  download_button.addEventListener('click', (evt) => {
    evt.preventDefault()
    download_media(src, type)
  })

  // create delete button
  let show_button = document.createElement('a');
  show_button.type = 'button';
  show_button.classList.add('btn', 'btn-primary', 'py-1', 'ms-1');
  show_button.innerHTML = "<i class='bi bi-eye'></i>";
  // add event to delete button
  show_button.addEventListener('click', (evt) => {
    evt.preventDefault()
    open_media(src, type)
  })

  // append buttons
  btn_container.appendChild(download_button);
  btn_container.appendChild(delete_button);
  btn_container.appendChild(show_button);
  // return button
  return btn_container;
}


function delete_media(btn) {
  // get media id
  let media_id = btn.dataset.mediaId;
  let media_name = btn.dataset.mediaName;
  // request url
  let url_content = `../requests/index.php?do=delete-malfunction-media&media-id=${media_id}&media-name=${media_name}`;
  // make a request to delete media
  $.get(url_content, (result) => {
    // convert result
    let res = $.parseJSON(result)
    // check result
    if (res) {
      setTimeout(() => {
        // show message
        alert('تم حذف الصورة بنجاح');
      }, 500);
      // delete image from dom
      btn.parentElement.parentElement.remove();
    } else {
      // show message
      alert('حدث خطأ اثناء حذف الصورة');
    }
  })
}

function download_media(src, type) {

  let media_name = `malfunction-media.${type}`;

  fetch(src)
    .then(response => response.blob())
    .then(blob => {
      const url = window.URL.createObjectURL(new Blob([blob]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', media_name);
      document.body.appendChild(link);
      link.click();
    });
}

function open_media(src, type) {
  // check type
  switch (type) {
    case 'jpg':
      // create image
      element = document.createElement('img');
      element.setAttribute('src', src);
      break;

    case 'mp4':
      element = create_video_element(src);
      break;
  }
  modal_content.innerHTML = '';
  modal.style.display = "block";
  element.classList.add('media-modal-content');
  modal_content.appendChild(element);
}


if (modal_close_btn != null) {
  modal_close_btn.addEventListener('click', (evt) => {
    modal.style.display = "none";
    // check type
    if (type == 'mp4') {
      // element.pause();

      console.log('mp4')
    }
  })
}



function change_cost_receipt_img(btn, preview_id) {
  // get preview el
  let prev_el = document.querySelector(`#${preview_id}`);

  // uploaded type
  let type = btn.files[0]['type'].includes('video') ? 'video' : 'img';
  // get size
  total_size = btn.files[0]['size'];
  // create the image src
  var src = URL.createObjectURL(btn.files[0]);
  // create image
  let img_element = document.createElement('img');
  img_element.setAttribute('src', src);
  img_element.setAttribute('class', 'w-100 h-100');
  img_element.style.cursor = 'pointer';
  img_element.style.borderRadius = '16px';
  img_element.style.objectFit = 'contain';
  media_type = 'jpg';

  // add event to delete button
  img_element.addEventListener('click', (evt) => {
    evt.preventDefault()
    open_media(src, media_type)
  })

  // check container children counter
  if (prev_el.childElementCount > 0) {
    // replace old element with new element
    prev_el.replaceChild(img_element, prev_el.children[0])
  } else {
    // append img element into preview container
    prev_el.appendChild(img_element)
  }

  if (prev_el.classList.contains('d-none')) {
    prev_el.classList.remove('d-none')
  }
}