@extends('layouts.app')

@section('title','Project Lists')

@section('styles')
<link rel="stylesheet" href="{{asset('css/jkanban.min.css')}}">
<style>
    .error {
        color: red !important;
    }
    .show-read-more .more-text{
        display: none;
    }
</style>
@stop

@section('content')

<div class="main-content" id="project-lists">


{{-- Project add modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="addusertoprojectmodal">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Project to Users</h5>
                <button type="button" class="close btn btn-round" data-toggle="tooltip" data-dismiss="modal" aria-label="Close" >
                    <i class="fa fa-times text-white"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="users-manage" data-filter-list="form-group-users">
                    <div class="input-group input-group-round">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-filter"></i></span>
                        </div>
                        <input type="search" class="form-control filter-list-input" placeholder="Filter members" aria-label="Filter Members">
                    </div>
                    <div class="form-group-users filter-list-1618727458030" id="projectuserlist"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Project add modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="addstagemodal">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Board</h5>
                <button type="button" class="close btn btn-round" data-toggle="tooltip" data-dismiss="modal" aria-label="Close" >
                    <i class="fa fa-times text-white"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="addstageform" action="javascript:void(0)">
                    <div class="form-group">
                        <label for="boardname">Board Name</label>
                        <input type="text" id="boardname" name="boardname" class="form-control" placeholder="Board Name" autofocus>
                        <span class="error" role="alert" data-error="boardname">
                        </span>
                    </div>
                    <button type="submit" class="btn btn-primary ml-auto">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Task add modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="addtaskmodal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Task</h5>
                <button type="button" class="close btn btn-round" data-toggle="tooltip" data-dismiss="modal" aria-label="Close" >
                    <i class="fa fa-times text-white"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="addtaskform" action="javascript:void(0)">
                    <div class="form-group">
                        <label for="tasktitle">Title</label>
                        <input type="text" id="tasktitle" name="tasktitle" class="form-control" placeholder="Title">
                        <span class="error" role="alert" data-error="tasktitle">
                        </span>
                    </div>
                    <input type="hidden" name="stage_id" id="stage_id">
                    <div class="form-group">
                        <label for="taskdescription">Descrition</label>
                        <textarea id="taskdescription" name="taskdescription" class="form-control" placeholder="Description"></textarea>
                        <span class="error" role="alert" data-error="taskdescription">
                        </span>
                    </div>
                    <button type="submit" class="btn btn-primary ml-auto">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Task show modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="showtaskmodal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Task Details</h5>
                <button type="button" class="close btn btn-round" data-toggle="tooltip" data-dismiss="modal" aria-label="Close" >
                    <i class="fa fa-times text-white"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="task_id" id="task_id">
            </div>
        </div>
    </div>
</div>


<section class="section">

    <div class="card">
        <div class="card-body d-flex justify-content-between">
            <div>
                <h2 class="my-2" id="project-title" data-project-id="{{$project->id}}" contenteditable>{{$project->title}}</h2>
                <span class="text-small show-read-more"  id="project-description" data-project-id="{{$project->id}}" contenteditable>{{ $project->description }}</span>
            </div>
            <div>
                <div class="d-flex align-items-center">
                    <ul class="avatars mr-4">
                        @forelse ($project->users as $index=>$projects)
                        <li>
                          <a href="#" data-toggle="tooltip" data-original-title="{{$projects->user->name}}">
                            <img alt="Claire Connors" class="avatar" src="{{asset('uploads/users/'.$projects->user->id.'/'.$projects->user->profile_picture)}}">
                          </a>
                        </li>
                        @empty

                        @endforelse
                    </ul>
                    <button class="btn btn-primary ml-3" data-toggle="modal" data-target="#addusertoprojectmodal">
                        <i class="fa fa-plus"></i>
                      </button>
                  </div>
            </div>
        </div>
    </div>
    <div class="section-body py-3" style="height:100%;background-color: rgba(0,0,0,.1);    backdrop-filter: blur(20px);border-radius:10px;">
        <div class="">
            <button type="button" class="btn btn-light mb-1 ml-3" id="add-kanban-board" data-toggle="tooltip" data-original-title="Add New Board">
                <i class="bx bx-add-to-queue mr-50"></i> Add New Board
            </button>
        </div>

        <div id="myKanban"></div>



    </div>
</section>
</div>


@stop

@section('script')
{{-- <script src="{{asset('js/ckeditor.js')}}"></script> --}}
<script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/jkanban.min.js')}}"></script>
<script src="{{asset('js/app/projects/project.js')}}"></script>
<script>

var project_id="{{$project->id}}";
var stage_store_url="{{ route('stage.store') }}";
var list_stage = "{{ route('stage.list') }}";
var update_task_stage_url = "{{ route('tasks.updatestage') }}";
var task_store_url = "{{ route('tasks.store') }}";
var stage_delete_url = "{{ route('stage.destroy') }}";

    $('#project-title').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            var title = $(this).html();
            var id = $(this).data('project-id');
            update_project_details(id,title,"description");
            $(this).blur();
        }
    });
    $('#project-description').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            var description = $(this).html();
            var id = $(this).data('project-id');
            update_project_details(id,description,"description");
            $(this).blur();
        }
    });
    fetch_user();

    function fetch_user() {
        $.ajax({
            url : "{{ route('user.involeduser') }}",
            method : "post",
            data : {project_id:project_id},
            success : function(data) {
                $('#projectuserlist').append(data.data);
            }
        });
    }


    function update_project_details(id,title,column) {
        $.ajax({
            url : "{{ route('projects.update') }}",
            method : "post",
            data : {title:title,id:id,column:column},
            success:function(data) {
                if(data.success) {
                    toastr.success(data.msg);
                }
            }
        });
    }

    $(document).on('change','.exists',function(){
        var user = $(this);
        var user_id=$(this).val();
        $.ajax({
            url:"{{route('user.updateuserproject')}}",
            method:'post',
            data:{id:user_id,status:'remove',project_id:project_id},
            success:function(data){
                if(data.success){
                    user.prop('checked',false);
                    toastr.success(data.msg);
                }
            }
        });
    });
    $(document).on('change','.noexists',function(){
        var user = $(this);
        var user_id=$(this).val();
        $.ajax({
            url:"{{route('user.updateuserproject')}}",
            method:'post',
            data:{id:user_id,status:'add',project_id:project_id},
            success:function(data){
                if(data.success){
                    user.prop('checked',true);
                    toastr.success(data.msg);
                }
            }
        });
    });

    var maxLength = 100;
    $(".show-read-more").each(function(){
        var myStr = $(this).text();
        if($.trim(myStr).length > maxLength){
            var newStr = myStr.substring(0, maxLength);
            var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
            $(this).empty().html(newStr);
            $(this).append(' <a href="javascript:void(0);" class="read-more ml-1">READ MORE...</a>');
            $(this).append('<span class="more-text">' + removedStr + '</span>');
        }
    });
    $(".read-more").click(function(){
		$(this).siblings(".more-text").contents().unwrap();
        $(this).remove();
	});
</script>

@stop
