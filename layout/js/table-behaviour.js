$(document).ready(function () {
  // get table columns
  let dataTable = $('table.display');

  if (dataTable != null) {
    // get the table
    var table = $('table.display').DataTable({
      "scrollX": true,
      ordering: true,
      stateSave: true,
      stateDuration: -1,
      lengthMenu: [
        [10, 50, 100, 500, -1],
        [10, 50, 100, 500, 'All'],
      ],
      dom: '<"#datatables-buttons.w-auto mb-2"B><".row g-3"<".col-sm-12 col-lg-6"f><".col-sm-12 col-lg-6 text-start"l>>ti<".pagination-right"p>',
      buttons: [
        { extend: 'excel', className: 'btn btn-outline-primary fs-12 py-1', text: 'Excel' },
        { extend: 'colvis', className: 'btn btn-outline-primary fs-12 py-1', columns: ':not(.noVis)' }
      ],
      columnDefs: [{ targets: [0, -1], className: 'noVis' }],
    });
  }

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