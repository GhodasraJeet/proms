    $('#dataTableUserList').DataTable({
        "columns": [
            {data: 'name', "name": "name"},
            {data: 'title', "name": "title"},
            {data: 'email', name: 'email'},
            {data:'profile_picture',"name":"profile_picture"},
            {data: 'status', name: 'status',render: {_: 'display', sort: 'status'}},
            {data: "action", "name": "action", "className": "text-center"}
        ],
        "processing": true,
        "responsive": true,
        'language': {
            'loadingRecords': '&nbsp;',
            "emptyTable": "No Records Found...",
            'processing': '<div id="loader-div"><div id="loader"></div></div>'
        },
        "iDisplayLength": 10,
        "serverSide": true,
        "ajax": {
            url: user_list_url,
            dataType: "json",
        },
        "order": [[0, "desc"]], //Set Default Column Tobe Sorted
        "columnDefs": [

            {
                "targets": [5,4,3],
                "searchable": false,
                "bSortable": false,
                "visible":true
            },
            {
                "targets": [0,1,2],
                "searchable": true,
                "bSortable": true
            }
        ],

        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": true
    });


    $(document.body).on('click', '#search_filter', function (event) {
        $('#dataTableUserList').DataTable().ajax.reload();
    });

    $(document.body).on('click', '#reset_filter', function (event) {
        $('#filterStatus').val(null);
        $('#dataTableUserList').DataTable().ajax.reload();
    });



$('#add_user_form').validate({
    rules: {
        user_name: {
            required : true
        },
        user_email: {
            required : true
        },
        user_title: {
            required : true
        }
    },
    messages: {
        user_name: 'The name field is required.',
        user_email: 'The email field is required.',
        user_title: 'The title field is required.'
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
    ,submitHandler: function (form) {
        save_user(form);
    }
});

function save_user(data){
    var url = $(data).attr('action');
    var data = $('#add_user_form').serialize();
    $.ajax({
        url : url,
        method : 'post',
        data : data ,
        success : function(data) {
            if(data.success)
            {
                $('#addusermodal').modal('hide');
                toastr.success(data.msg);
            }
            else
            {
                toastr.success("Something Wrong");
            }
        },
        error:function(error){
            let errors = error.responseJSON.errors;
            for(let key in errors)
            {
                let errorDiv = $(`[data-error="${key}"]`);
                if(errorDiv.length )
                {
                    errorDiv.text(errors[key][0]);
                }
            }
        }
    });
}
