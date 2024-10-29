import '@nitsan/ns-gallery/Datatables.js';
$('.ns-ext-datatable').DataTable({
    "language": {
        "lengthMenu": "Display _MENU_ Records",
        "emptyTable": "No Records Available",
        "zeroRecords": "No matching Records found"
    },
});

$('.field-info-trigger').on('click', function(){
    $(this).parents('.form-group').find('.field-info-text').slideToggle();
});

$('.dataTables_length select,\ .dataTables_filter input').addClass('form-control');
