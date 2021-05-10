$(document).ready(function() {



    var stage_lists=[];

    fetch_stages(project_id);

    // Fetch All Stages
    function fetch_stages(projectid) {

        $('#myKanban').html('');
        var data = $.parseJSON($.ajax({
            url : list_stage+"/"+projectid,
            async : false,
            method : 'GET',
            dataType : "json"
        }).responseText);
        stage_lists=data.data;

        var kanban_curr_el, kanban_curr_item_id, kanban_item_title, kanban_data, kanban_item, kanban_users;

        var kanban_board_data = [];
        $.each(stage_lists,function(key,value){
            var smalls=[];
            $.each(value.tasks,function(key,value){
                smalls.push({
                    id:value.id,
                    title:value.title,
                    border:"success",
                    dueDate:"MAr 10"
                });
            });
            kanban_board_data.push({
                id:'kanban-board-'+value.id,
                title:value.name,
                stageid:value.id,
                item:smalls
            });
        });

    var KanbanExample = new jKanban({
      element: "#myKanban",
      buttonContent: "+",
      click: function(el) {
            var task_id=$(el).attr('data-eid');
            $('#showtaskmodal #task_id').val(task_id);
            $('#showtaskmodal').modal('show');
      },

      addItemButton: false,
      boards: kanban_board_data,
      dropEl: function(el, target, source, sibling){
        var old_stage_id = $(source).parent().attr('data-stage-id');
        var new_stage_id = $(target).parent().attr('data-stage-id');
        var taskid = $(el).attr('data-eid');
        update_task_stage(old_stage_id,new_stage_id,taskid)
      },
      dragBoard : function (el, source) {
          console.log(el,source);
      },
      dragendBoard     : function (el) {
          console.log("new",el);
      },
    });


    // Add html for Custom Data-attribute to Kanban item
    var board_item_id, board_item_el;
    // Kanban board loop
    for (kanban_data in kanban_board_data) {
      // Kanban board items loop
        var stageid=kanban_board_data[kanban_data].stageid;
        var ownid=kanban_board_data[kanban_data].id;
        $('[data-id='+ownid+']').attr('data-stage-id',stageid);
        $('[data-id='+ownid+']').prepend("<div class='d-flex justify-content-center my-2'><button class='btn btn-custom-kanban' id='addtaskbtn' data-stage-id="+stageid+"><i class='fa fa-plus'></i></button></div>");
        var kanban_dropdown=
        `<div class="dropdown"><div class="dropdown-toggle cursor-pointer" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></div>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
        <button class="dropdown-item"><i class="fa fa-copy mr-4"></i>Settings</button>
        <button class="dropdown-item kanban-stage-delete" data-stage-id="${stageid}" id="kanban-stage-delete"><i class="fa fa-trash text-danger mr-4"></i>Delete</button>
        </div></div>`;
        $('[data-id='+ownid+'] header').append(kanban_dropdown);

        for (kanban_item in kanban_board_data[kanban_data].item) {

        var board_item_details = kanban_board_data[kanban_data].item[kanban_item]; // set item details
        board_item_id = $(board_item_details).attr("id"); // set 'id' attribute of kanban-item
        // console.log(board_item_id);
        (board_item_el = KanbanExample.findElement(board_item_id)), // find element of kanban-item by ID
          (board_item_users = board_item_dueDate = board_item_comment = board_item_attachment = board_item_image = board_item_badge =
            " ");

        // check if users are defined or not and loop it for getting value from user's array
        if (typeof $(board_item_el).attr("data-users") !== "undefined") {
          for (kanban_users in kanban_board_data[kanban_data].item[kanban_item].users) {
            board_item_users +=
              '<li class="avatar pull-up my-0">' +
              '<img class="media-object rounded-circle" src=" ' +
              kanban_board_data[kanban_data].item[kanban_item].users[kanban_users] +
              '" alt="Avatar" height="24" width="24">' +
              "</li>";
          }
        }
        // check if dueDate is defined or not
        if (typeof $(board_item_el).attr("data-dueDate") !== "undefined") {
          board_item_dueDate =
            '<div class="kanban-due-date d-flex align-items-center mr-50">' +
            '<i class="bx bx-time-five font-size-small mr-25"></i>' +
            '<span class="font-size-small">' +
            $(board_item_el).attr("data-dueDate") +
            "</span>" +
            "</div>";
        }
        // check if comment is defined or not
        if (typeof $(board_item_el).attr("data-comment") !== "undefined") {
          board_item_comment =
            '<div class="kanban-comment d-flex align-items-center mr-50">' +
            '<i class="bx bx-message font-size-small mr-25"></i>' +
            '<span class="font-size-small">' +
            $(board_item_el).attr("data-comment") +
            "</span>" +
            "</div>";
        }
        // check if attachment is defined or not
        if (typeof $(board_item_el).attr("data-attachment") !== "undefined") {
          board_item_attachment =
            '<div class="kanban-attachment d-flex align-items-center">' +
            '<i class="bx bx-link-alt font-size-small mr-25"></i>' +
            '<span class="font-size-small">' +
            $(board_item_el).attr("data-attachment") +
            "</span>" +
            "</div>";
        }
        // check if Image is defined or not
        if (typeof $(board_item_el).attr("data-image") !== "undefined") {
          board_item_image =
            '<div class="kanban-image mb-1">' +
            '<img class="img-fluid" src=" ' +
            kanban_board_data[kanban_data].item[kanban_item].image +
            '" alt="kanban-image">';
          ("</div>");
        }
        // check if Badge is defined or not
        if (typeof $(board_item_el).attr("data-badgeContent") !== "undefined") {
          board_item_badge =
            '<div class="kanban-badge">' +
            '<div class="badge-circle badge-circle-sm badge-circle-light-' +
            kanban_board_data[kanban_data].item[kanban_item].badgeColor +
            ' font-size-small font-weight-bold">' +
            kanban_board_data[kanban_data].item[kanban_item].badgeContent +
            "</div>";
          ("</div>");
        }
        // add custom 'kanban-footer'
        if (
          typeof (
            $(board_item_el).attr("data-dueDate") ||
            $(board_item_el).attr("data-comment") ||
            $(board_item_el).attr("data-users") ||
            $(board_item_el).attr("data-attachment")
          ) !== "undefined"
        ) {
          $(board_item_el).append(
            '<div class="kanban-footer d-flex justify-content-between mt-1">' +
              '<div class="kanban-footer-left d-flex">' +
              board_item_dueDate +
              board_item_comment +
              board_item_attachment +
              "</div>" +
              '<div class="kanban-footer-right">' +
              '<div class="kanban-users">' +
              board_item_badge +
              '<ul class="list-unstyled users-list m-0 d-flex align-items-center">' +
              board_item_users +
              "</ul>" +
              "</div>" +
              "</div>" +
              "</div>"
          );
        }
        // add Image prepend to 'kanban-Item'
        if (typeof $(board_item_el).attr("data-image") !== "undefined") {
          $(board_item_el).prepend(board_item_image);
        }
    }

    }


    }


// Add new kanban board
    //---------------------
    // var addBoardDefault = document.getElementById("add-kanban");
    // var i = 1;
    // addBoardDefault.addEventListener("click", function() {
    //   KanbanExample.addBoards([
    //     {
    //       id: "kanban-" + i, // generate random id for each new kanban
    //       title: "Default Title"
    //     }
    //   ]);
    //   i++;
    //   dropdown();
    // });




    // Delete kanban board
    //---------------------
    $(document).on("click", ".kanban-delete", function(e) {
      var $id = $(this)
        .closest(".kanban-board")
        .attr("data-id");
      addEventListener("click", function() {
        KanbanExample.removeBoard($id);
      });
    });

    // Kanban board dropdown
    // ---------------------



    // Kanban-overlay and sidebar hide
    // --------------------------------------------
    $(
      ".kanban-sidebar .delete-kanban-item, .kanban-sidebar .close-icon, .kanban-sidebar .update-kanban-item, .kanban-overlay"
    ).on("click", function() {
      $(".kanban-overlay").removeClass("show");
      $(".kanban-sidebar").removeClass("show");
    });

    // Updating Data Values to Fields
    // -------------------------------
    $(".update-kanban-item").on("click", function(e) {
      // var $edit_title = $(".edit-kanban-item .edit-kanban-item-title").val();
      // $(kanban_curr_el).txt($edit_title);
      e.preventDefault();
    });

    // Delete Kanban Item
    // -------------------



    // Making Title of Board editable
    // ------------------------------
    // $(".kanban-title-board").on("mouseenter", function() {
    //   $(this).attr("contenteditable", "true");
    //   $(this).addClass("line-ellipsis");
    // });


    // $('.kanban-title-board').on('')

    // select default bg color as selected option
    $("select").addClass($(":selected", this).attr("class"));

    // change bg color of select form-control
    $("select").change(function() {
      $(this)
        .removeClass($(this).attr("class"))
        .addClass($(":selected", this).attr("class") + " form-control");
    });










    $(document).on('click','#add-kanban-board',function(){
        $('#addstageform').trigger("reset");
        $('#addstagemodal').modal('show');
    });

    // Board Validation
    $('#addstageform').validate({
        rules: {
            boardname: {
                required : true,
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
        ,submitHandler: function (form) {
            save_stage(form);
        }
    });

    // Add Board
    function save_stage(form) {
        var data = $('#addstageform').serialize()+'&project_id='+project_id;
        $.ajax({
            url : stage_store_url,
            method : 'post',
            data : data ,
            success : function(data) {
                if(data.success)
                {
                    $('#addstagemodal').modal('hide');
                    toastr.success(data.msg);
                    fetch_stages(project_id);
                }
                else
                {
                    toastr.error(data.msg);
                }
                $('#addstageform').trigger("reset");
            },
            error:function(error){
                let errors = error.responseJSON.errors;
                for(let key in errors)
                {
                    let errorDiv = $(`[data-error="${key}"]`);
                    console.log(errorDiv);
                    if(errorDiv.length )
                    {
                        errorDiv.text(errors[key][0]);
                    }
                }
            }
        });
    }


    // Update stage task
    function update_task_stage(old_stage_id,new_stage_id,taskid) {
        // alert(update_task_stage_url);
        $.ajax({
            url : update_task_stage_url,
            method : 'POST',
            data : {old_stage_id:old_stage_id,new_stage_id:new_stage_id,taskid:taskid},
            success : function(data) {
                if(data.success) {
                    toastr.success(data.msg);
                }
                else {
                    toastr.success("Something wrong try again");
                }
            }
        });
    }


    // Open add task mmodel
    $(document).on('click','#addtaskbtn',function(){
        $('#addtaskform').trigger("reset");
        $('#stage_id').val($(this).attr('data-stage-id'));
        $('#addtaskmodal').modal('show');
    });

    // Task store Validation
    $('#addtaskform').validate({
        rules: {
            tasktitle: {
                required : true,
            },
            taskdescription: {
                required : true,
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
        ,submitHandler: function (form) {
            taskstore();
        }
    });

    function taskstore()
    {
        var data = $('#addtaskform').serialize()+'&project_id='+project_id;
        $.ajax({
            url : task_store_url,
            method : 'post',
            data : data ,
            success : function(data) {
                if(data.success)
                {
                    $('#addtaskmodal').modal('hide');
                    toastr.success(data.msg);
                    fetch_stages(project_id);
                }
                else
                {
                    toastr.success(data.msg);
                }
                $('#addtaskform').trigger("reset");
            },
            error:function(error){
                let errors = error.responseJSON.errors;
                for(let key in errors)
                {
                    let errorDiv = $(`[data-error="${key}"]`);
                    console.log(errorDiv);
                    if(errorDiv.length )
                    {
                        errorDiv.text(errors[key][0]);
                    }
                }
            }
        });
    }


    // Delete Stage
    $(document).on('click','#kanban-stage-delete',function(){
        var stage_id=$(this).attr('data-stage-id');
        $.ajax({
            url : stage_delete_url+'/'+stage_id,
            method : 'GET',
            success : function(data) {
                toastr.success(data.msg);
                fetch_stages(project_id);
            }
        });
    });


  });
