
let deleted_piece_name_in_modal = document.querySelector('#deleted-piece-name');
let deleted_piece_url_in_modal = document.querySelector('#deleted-piece-url');

function confirm_delete_piece(btn, will_back = null) {
  // get piece info
  let piece_id = btn.dataset.pieceId;
  let piece_name = btn.dataset.pieceName;
  let page_title = btn.dataset.pageTitle;
  // prepare url
  let url = will_back == null ? `?do=delete-piece&piece-id=${piece_id}` : `?do=delete-piece&piece-id=${piece_id}&back=true`;
  // put it into the modal
  deleted_piece_name_in_modal.textContent = `'${piece_name}'`;
  deleted_piece_url_in_modal.href = url;
}

function get_sources(dir_select, company_id, location, box) {
  // get direction id
  let dir_id = dir_select.value;
  // get direction name
  let dir_name = dir_select.options[dir_select.selectedIndex].textContent;
  // json file name
  let json_file_name = "";
  // get all pieces data ..
  $.get(`../requests/index.php?do=get-source&dir-id=${dir_id}&company=${company_id}`, (data) => {
    // console.log(data);
    // assign json file name to the variable
    json_file_name = $.parseJSON(data);

    // get data from json file
    $.ajax({
      url: `${location}/${json_file_name}`,
      dataType: 'json',
      cache: false,
      success: function (data, status) {
        for (let i = 0; i < box.length; i++) {
          put_data_into_select(data, status, box[i], 'source', dir_name.trim());
        }
      },
      error: function (xhr, textStatus, err) {
        // for error message
      }
    })
  });
}

function put_data_into_select(data, status, box, type, ...fields) {
  // check the status
  if (status === "success") {
    var select_box = document.getElementById(box);
    // remove all sources children
    select_box.innerHTML = "";

    switch (type) {
      case 'source':
        // check the select box
        if (box == 'sources') {
          default_text = `اختر المصدر`;
        } else {
          default_text = `اختر المصدر البديل`;
        }
        default_option = new Option(default_text, 'default');
        default_option.setAttribute('disabled', 'disabled');
        // append to select box
        select_box.appendChild(default_option);

        // check if source data has pieces or not
        if (data.length == 0) {
          console.log(fields)

          option = new Option(`${fields[0]}`, 0, true, true);
          select_box.appendChild(option);
        } else {
          // loop on data result to display the data
          for (let i = 0; i < data.length; i++) {
            option = new Option(`${data[i]["ip"]} - ${data[i]["full_name"]}`, data[i]["id"], false, false);
            select_box.appendChild(option);
          }
        }
        break;

      case 'model':
        select_box.innerHTML = '';
        default_option = new Option('اختر موديل الجهاز', 'default', true, true);
        default_option.setAttribute('disabled', 'disabled');
        // append to select box
        select_box.appendChild(default_option);

        // check if source data has pieces or not
        if (data.length > 0) {
          // loop on data result to display the data
          for (let i = 0; i < data.length; i++) {
            option = new Option(`${data[i]["model_name"]}`, data[i]["model_id"], false, false);
            select_box.appendChild(option);
          }
        }
        break;

      default:
        break;
    }
  }
}

function ping(ip) {
  // loader
  let loader = document.querySelector('#ping-loader');
  // status container
  let status_msg = document.querySelector("#ping-status");
  let status_msg_parent = status_msg.parentElement;
  // check ip format 
  if (ip != '0.0.0.0' && /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ip)) {
    // get data from json file
    $.ajax({
      url: `../requests/index.php?do=ping&ip=${ip}`,
      dataType: 'json',
      cache: false,
      success: function (data, status) {
        loader.classList.add('d-none')
        // change direction of parent
        status_msg_parent.style.direction = 'ltr';
        // clear default status msg
        status_msg.textContent = '';
        // loop on data
        for (let i = 0; i < data['output'].length; i++) {
          const element = data['output'][i];
          
          if (element != "") {
            status_msg.innerHTML += `${element}<br>`;
          }
        }
      },
      error: function (xhr, textStatus, err) {
        // for error message
      }
    })
  }
}

function reset_modal() {
  // loader
  let loader = document.querySelector('#ping-loader');
  // status container
  let status_msg = document.querySelector("#ping-status");

  loader.classList.remove('d-none');
  status_msg.innerHTML = '';
}