toastr.options.preventDuplicates = true;

$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
});


$(function(){
    //get all files
    var table =  $('#files-table').DataTable({
        processing:true,
        info:true,
        "pageLength":5,
        "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
        columns:[
            {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'name', name:'name'},
            {data:'format', name:'format'},
            {data:'size', name:'size'},
            {data:'actions', name:'actions', orderable:false, searchable:false},
        ]

    }).on('draw', function(){
        $('input[name="file_checkbox"]').each(function(){this.checked = false;});
        $('input[name="main_checkbox"]').prop('checked', false);
        $('button#deleteAllBtn').addClass('d-none');
    });

    $(document).on('click','#editFileBtn', function(){
        var file_id = $(this).data('id');
        var name = $(this).closest('tr').find('td:eq(2)').text();
        $('.editFileName').find('form')[0].reset();
        $('.editFileName').find('span.error-text').text('');

        $('.editFileName').modal('show');
        $('.editFileName').find('input[name="fileId"]').val(file_id);
        $('.editFileName').find('input[name="fileName"]').val(name);

    });

    //update file name
    $('#update-file-name-form').on('submit', function(e){
        e.preventDefault();
        var form = this;
        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:new FormData(form),
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend: function(){
                $(form).find('span.error-text').text('');
            },
            success: function(data){
                if(data.isRenamed == false){
                    $(form).find('span.'+'_error').text('Something went wrong. Please try again');
                }else{
                    location.reload();
                    $('.editFileName').modal('hide');
                    $('.editFileName').find('form')[0].reset();
                    toastr.success('File renamed successfully !');
                }
            }
        });
    });

    //delete file
    $(document).on('click','#deleteFileBtn', function(){
        var file_id = $(this).data('id');
        var url = 'delete';

        swal.fire({
            title:'Are you sure?',
            html:'You want to <b>delete</b> this file',
            showCancelButton:true,
            showCloseButton:true,
            cancelButtonText:'Cancel',
            confirmButtonText:'Yes, Delete',
            cancelButtonColor:'#556ee6',
            confirmButtonColor:'#d33',
            width:300,
            allowOutsideClick:false
        }).then(function(result){
            if(result.value){
                $.post(url,{fileIds:[file_id]}, function(data){
                    if(data.isDeleted == true){
                        location.reload();
                        toastr.success('File deleted successfully');
                    } else {
                        toastr.error('Something went wrong. Please try again');
                    }
                },'json');
            }
        });
    });

    //to select checkboxes if main is checked
    $(document).on('click','input[name="main_checkbox"]', function(){
        if(this.checked){
            $('input[name="file_checkbox"]').each(function(){
                this.checked = true;
            });
        }else{
            $('input[name="file_checkbox"]').each(function(){
                this.checked = false;
            });
        }
        toggledeleteAllBtn();
    });

    // select main checkbox if all below are selected
    $(document).on('change','input[name="file_checkbox"]', function(){

        if( $('input[name="file_checkbox"]').length == $('input[name="file_checkbox"]:checked').length ){
            $('input[name="main_checkbox"]').prop('checked', true);
        }else{
            $('input[name="main_checkbox"]').prop('checked', false);
        }
        toggledeleteAllBtn();
    });

    function toggledeleteAllBtn(){
        if( $('input[name="file_checkbox"]:checked').length > 0 ){
            $('button#deleteAllBtn').text('Delete ('+$('input[name="file_checkbox"]:checked').length+')').removeClass('d-none');
        }else{
            $('button#deleteAllBtn').addClass('d-none');
        }
    }

    $(document).on('click','button#deleteAllBtn', function(){
        var checkedFiles = [];
        $('input[name="file_checkbox"]:checked').each(function(){
            checkedFiles.push($(this).data('id'));
        });

        var url = 'delete';
        if(checkedFiles.length > 0){
            swal.fire({
                title:'Are you sure?',
                html:'You want to delete <b>('+checkedFiles.length+')</b> files',
                showCancelButton:true,
                showCloseButton:true,
                confirmButtonText:'Yes, Delete',
                cancelButtonText:'Cancel',
                confirmButtonColor:'#556ee6',
                cancelButtonColor:'#d33',
                width:300,
                allowOutsideClick:false
            }).then(function(result){
                if(result.value){
                    $.post(url,{fileIds:checkedFiles},function(data){
                        if(data.isDeleted == true){
                            location.reload();
                            toastr.success('File deleted successfully');
                        }
                    },'json');
                }
            })
        }
    });

});
