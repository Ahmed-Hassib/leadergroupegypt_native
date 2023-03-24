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
                [10, 50, 100, 500, 1000, -1],
                [10, 50, 100, 500, 1000, 'All'],
            ],
            // dom: '<"#datatables-buttons.vstack gap-3 mb-2 ms-auto"B><".row row-cols-sm-1 row-cols-md-2 align-items-center g-3"<".col-sm-12 col-md-6"f><".col-sm-12 col-md-6 text-start"l>>tip',
            // dom: '<"#datatables-buttons.vstack gap-3 mb-2 ms-auto"B>lt<".mt-1 row row-cols-sm-1 row-cols-lg-2 g-2"<".col-auto"i><".col-auto"p>>',
            dom: '<"#datatables-buttons.w-auto mb-2"B><".row row-cols-sm-2 g-3"<f><"text-start"l>>tip',            
            buttons: [
                { extend: 'excel', className: 'btn btn-outline-primary', text: 'Excel' },
                { extend: 'colvis', className: 'btn btn-outline-primary', columns: ':not(.noVis)' },
            ],
            columnDefs: [{ targets: [0, -1], className: 'noVis' }],
        })

        table.buttons().container().appendTo($('.col-sm-6:eq(0)', table.table().container()));
    }

})