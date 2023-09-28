// table words in arabic
let table_words_ar = {
  "emptyTable": "لا توجد بيانات للعرض",
  "info": "عرض _START_ الي _END_ من _TOTAL_ صف",
  "infoEmpty": "عرض 0 الي 0 من 0 صف",
  "infoFiltered": "(تم البحث من خلال _MAX_ صف)",
  "lengthMenu": "عرض _MENU_ صفوف",
  "loadingRecords": "جارى تحميل البيانات...",
  "search": "البحث",
  "zeroRecords": "لا توجد بيانات متطابقة للبحث المطلوب",
  "paginate": {
    "first": "الاول",
    "last": "الاخير",
    "next": "التالى",
    "previous": "السابق"
  },
}

// table words in english
let table_words_en = {
  "emptyTable": "no data to show",
  "info": "show _START_ to _END_ from _TOTAL_ entries",
  "infoEmpty": "show 0 to 0 from 0 entries",
  "infoFiltered": "search was happened in _MAX_ entries",
  "lengthMenu": "show _MENU_ entries",
  "loadingRecords": "data loading...",
  "search": "search",
  "zeroRecords": "there is no data with your search words",
  "paginate": {
    "first": "first",
    "last": "last",
    "next": "next",
    "previous": "previous"
  },
}

// buttons words in arabic
var btn_words_ar = {
  excel: 'تحميل الجدول',
  colVis: 'رؤية الأعمدة'
}

// buttons words in english
var btn_words_en = {
  excel: 'excel',
  colVis: 'col visible'
}

$(document).ready(function () {
  // get table columns
  let dataTable = $('table.display');
  var lang = 'ar';

  if (location.pathname.includes('website')) {
    // get language
    if (localStorage['lang'] != null) {
      lang = localStorage['lang'] == 'ar' ? 'ar' : 'en';
    }
  } else if (location.pathname.includes('sys_tree')) {
    // get language
    if (localStorage['systemLang'] != null) {
      lang = localStorage['systemLang'] == 'ar' ? 'ar' : 'en';
    }
  }
  // check lang
  let curr_table_arr = lang == 'ar' ? table_words_ar : table_words_en;
  let curr_btn_arr = lang == 'ar' ? btn_words_ar : btn_words_en;

  if (dataTable != null) {
    // get the table
    var table = $('table.display').DataTable({
      "scrollX": true,
      autoWidth: false,
      ordering: true,
      stateSave: true,
      stateDuration: -1,
      lengthMenu: [
        [10, 50, 100, 500, -1],
        [10, 50, 100, 500, 'All'],
      ],
      dom: '<"#datatables-buttons.w-auto mb-2"B><".row g-3"<".col-sm-12 col-lg-6"f><".col-sm-12 col-lg-6 text-start"l>>tip',
      buttons: [
        { extend: 'excel', className: 'btn btn-outline-primary fs-12 py-1', text: curr_btn_arr.excel },
        { extend: 'colvis', className: 'btn btn-outline-primary fs-12 py-1', columns: ':not(.noVis)', text: curr_btn_arr.colVis }
      ],
      columnDefs: [
        { targets: [0, 1, -1], className: 'noVis' },
        { className: 'dt-justify fs-12', targets: '_all' },
      ],

      "language": curr_table_arr
    });
  }

  let dataTable_container = $("#datatables-buttons");
  dataTable_container.css('direction', 'ltr')

  // select all data tables controls
  let dataTable_control_btn = $('.dt-buttons button');
  // loop on it
  dataTable_control_btn.each(function () {
    if (dataTable_control_btn.hasClass('btn-secondary')) {
      dataTable_control_btn.removeClass('btn-secondary')
    }
  })

  // get previous button
  let prev_btn = $('button.scroll-prev');
  // add click event
  prev_btn.click(function () {
    // get scroll value
    let scroll_value = $('.dataTables_scrollBody').scrollLeft();
    $('.dataTables_scrollBody').scrollLeft(scroll_value - 150)
  })

  // get next button
  let next_btn = $('button.scroll-next');
  // add click event
  next_btn.click(function () {
    // get scroll value
    let scroll_value = $('.dataTables_scrollBody').scrollLeft();
    $('.dataTables_scrollBody').scrollLeft(scroll_value + 150)
  })

});


function show_hide_extra_data(btn, index) {
  // get parent tr
  let parent_tr = btn.parentElement;
  // toggle class of parent element
  parent_tr.classList.toggle('dt-hasChild');
  // check if parent has child
  if (parent_tr.classList.contains('dt-hasChild')) {
    // create a tr
    let tr = document.createElement('tr');
    tr.id = `row_${index}`;
    // create a td
    let td = document.createElement('td');
    td.colSpan = "6";
    // create tr content
    let tr_content = create_tr_content(pcs_data_tables[index]);
    // append dl into td
    td.appendChild(tr_content);
    // append td into tr
    tr.appendChild(td);
    // append row of details
    parent_tr.parentElement.insertBefore(tr, parent_tr.nextElementSibling);
  } else {
    if (document.querySelector(`#row_${index}`) != null) {
      // remove row
      document.querySelector(`#row_${index}`).remove();
    }
  }
}

function create_tr_content(content) {
  // create a span container
  let main_span = document.createElement('span');
  main_span.className = "datatables_row_details";
  // create a span for type
  let type_span = document.createElement('span');
  type_span.textContent = `${lang.type} : ${content['type'] == null ? lang.not_assign : content['type']}`;

  // create a span for internet
  let internet_span = document.createElement('span');
  internet_span.textContent = `${lang.internet_src} : ${content['internet_source'] == null || content['internet_source'] == '' ? lang.not_assign : content['internet_source']}`;

  // create a span for notes
  let notes_span = document.createElement('span');
  notes_span.textContent = `${lang.notes} : ${content['notes']}`;

  // create a span for visit_time
  let visit_time_span = document.createElement('span');
  visit_time_span.textContent = `${lang.visit_time} : ${content['visit_time'] == 0 ? lang.not_assign : content['visit_time_name']}`;

  // create a span for direction_name
  let direction_name_span = document.createElement('span');
  direction_name_span.textContent = `${lang.direction_name} : ${content['direction_name'] == '' ? lang.not_assign : content['direction_name']}`;

  // create a span for source_name
  let source_name_span = document.createElement('span');
  source_name_span.textContent = `${lang.source_name} : ${content['source_name'] == '' ? lang.not_assign : content['source_name']}`;

  // create a span for alt_source_name
  let alt_source_name_span = document.createElement('span');
  alt_source_name_span.textContent = `${lang.alt_source_name} : ${content['alt_source_id'] == -1 ? lang.not_assign : content['alt_source_name']}`;

  // create a span for device_type_name
  let device_type_name_span = document.createElement('span');
  device_type_name_span.textContent = `${lang.device_type_name} : ${content['device_id'] == null || content['device_id'] <= 0 ? lang.not_assign : content['device_name']}`;

  // create a span for model_name
  let model_name_span = document.createElement('span');
  model_name_span.textContent = `${lang.model_name} : ${content['device_id'] <= 0 ? lang.not_assign : content['model_name']}`;

  // create a span for conn_name
  let conn_name_span = document.createElement('span');
  conn_name_span.textContent = `${lang.conn_name} : ${content['connection_type'] == 0 ? lang.not_assign : content['conn_name']}`;

  // create a span for ip
  let ip_span = document.createElement('span');
  // ip_span.dir = content['ip'] == '0.0.0.0' ? "rtl" : "ltr";
  ip_span.textContent = `${lang.ip} : ${content['ip'] == '0.0.0.0' ? lang.not_assign : content['ip']}`;

  // create a span for port
  let port_span = document.createElement('span');
  // port_span.dir = content['port'] == 0 ? "rtl" : "ltr";
  port_span.textContent = `${lang.port} : ${content['port'] == 0 ? lang.not_assign : content['port']}`;

  // create a span for mac
  let mac_span = document.createElement('span');
  // mac_span.dir = content['mac'] == null || content['mac'] == '' ? "rtl" : "ltr";
  mac_span.textContent = `${lang.mac} : ${content['mac'] == null || content['mac'] == '' ? lang.not_assign : content['mac']}`;

  // create a span for username
  let username_span = document.createElement('span');
  username_span.textContent = `${lang.username} : ${content['username'] == '' || content['username'] == null ? lang.not_assign : content['username']}`;

  // create a span for ssid
  let ssid_span = document.createElement('span');
  ssid_span.textContent = `${lang.ssid} : ${content['ssid'] == '' || content['ssid'] == null ? lang.not_assign : content['ssid']}`;

  // create a span for freq
  let freq_span = document.createElement('span');
  freq_span.textContent = `${lang.freq} : ${content['frequency'] == 0 || content['frequency'] == null ? lang.not_assign : content['frequency']}`;

  // create a span for wave
  let wave_span = document.createElement('span');
  wave_span.textContent = `${lang.wave} : ${content['wave'] == 0 || content['wave'] == null ? lang.not_assign : content['wave']}`;

  // append all spans
  main_span.appendChild(type_span);
  main_span.appendChild(internet_span);
  main_span.appendChild(notes_span);
  main_span.appendChild(direction_name_span);
  main_span.appendChild(source_name_span);
  main_span.appendChild(alt_source_name_span);
  main_span.appendChild(device_type_name_span);
  main_span.appendChild(model_name_span);
  main_span.appendChild(conn_name_span);
  main_span.appendChild(ip_span);
  main_span.appendChild(port_span);
  main_span.appendChild(mac_span);
  main_span.appendChild(username_span);
  main_span.appendChild(ssid_span);
  main_span.appendChild(freq_span);
  main_span.appendChild(wave_span);
  return main_span;
}