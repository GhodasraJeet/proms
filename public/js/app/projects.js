$(document).ready(function(){

    var current_page = 1;
    $('#add_project_form').validate({
        rules: {
            project_title: {
                required : true
            },
            project_description: {
                required : true
            }
        },
        messages: {
            project_title: 'The title field is required.',
            project_description: 'The description field is required.'
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
        ,submitHandler: function (form) {
            save_project(form);
        }
    });

    function save_project(data){
        var url = $(data).attr('action');
        var data = $('#add_project_form').serialize();
        $.ajax({
            url : url,
            method : 'post',
            data : data ,
            success : function(data) {
                if(data.success)
                {
                    $('#addprojectmodal').modal('hide');
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

     // Pagination and search
     $(document).on('click', '.pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        current_page = page;
        $('#hidden_page').val(page);
        $('li').removeClass('active');
        $(this).parent().addClass('active');
        fetch_project(page);
    });

    function fetch_project(page,search='')
    {
        $.ajax({
            url:project_list_url,
            method: 'post',
            data:{page:page,search:search},
            success:function(data)
            {
                $('#project-lists-pagination').html('');
                $('#project-lists-pagination').html(data);
            }
        });
    }

    $(document).on('keyup','#project-search',function(){
        var search = $(this).val().trim();
        fetch_project(current_page,search);
    });



});

