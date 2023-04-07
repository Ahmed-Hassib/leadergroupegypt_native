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
        { extend: 'excel', className: 'btn btn-outline-primary', text: 'Excel' },
        { extend: 'colvis', className: 'btn btn-outline-primary', columns: ':not(.noVis)' }
      ],
      columnDefs: [{ targets: [0, -1], className: 'noVis' }],
    });
  }

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