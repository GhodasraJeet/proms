@extends('layouts.app')

@section('title','Project Lists')

@section('styles')
<style>
    .error {
        color: red !important;
    }
</style>
@stop

@section('content')

    <div class="main-content" id="project-lists">

        {{-- Project add modal --}}
        <div class="modal fade" tabindex="-1" role="dialog" id="addprojectmodal">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add Project</h5>
                  <button type="button" class="close btn btn-round" data-toggle="tooltip" data-dismiss="modal" aria-label="Close" >
                    <i class="fa fa-times text-white"></i>
                  </button>
                </div>
                <!--end of modal head-->
                <ul class="nav nav-tabs nav-fill" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="team-add-details-tab" data-toggle="tab" href="#team-add-details" role="tab" aria-controls="team-add-details" aria-selected="true">Details</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="team-add-members-tab" data-toggle="tab" href="#team-add-members" role="tab" aria-controls="team-add-members" aria-selected="false">Members</a>
                  </li>
                </ul>
                <div class="modal-body">
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="team-add-details" role="tabpanel">
                      <h6 class="mb-4">Project Details</h6>
                      <form action="{{ route('projects.store') }}" method="post" id="add_project_form">
                      <div class="form-group row">
                        <label class="col-3">Title</label>
                        <div class="col-9">
                            <input class="form-control col" type="text" placeholder="Title" name="project_title" id="project_title">
                            <span class="error" role="alert" data-error="project_title">
                            </span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-3">Description</label>
                        <div class="col-9">
                            <textarea name="project_description" id="project_description" ></textarea>
                        </div>
                      </div>
                      <button role="button" class="btn btn-primary float-right" type="submit">
                        Done
                      </button>
                    </form>
                    </div>
                    <div class="tab-pane fade" id="team-add-members" role="tabpanel">
                      <div class="users-manage" data-filter-list="form-group-users">
                        <div class="mb-3">
                        </div>
                        <div class="input-group input-group-round">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">filter_list</i>
                            </span>
                          </div>
                          <input type="search" class="form-control filter-list-input" placeholder="Filter members" aria-label="Filter Members">
                        </div>
                        <div class="form-group-users filter-list-1618727458030"><div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="user-manage-1" checked="">
                            <label class="custom-control-label" for="user-manage-1">
                              <span class="d-flex align-items-center">
                                <img alt="Claire Connors" src="{{ asset('image/1.png') }}" class="avatar mr-2">
                                <span class="h6 mb-0 SPAN-filter-by-text" data-filter-by="text">Claire Connors</span>
                              </span>
                            </label>
                          </div><div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="user-manage-2" checked="">
                            <label class="custom-control-label" for="user-manage-2">
                              <span class="d-flex align-items-center">
                                <img alt="Marcus Simmons" src="{{ asset('image/1.png') }}" class="avatar mr-2">
                                <span class="h6 mb-0 SPAN-filter-by-text" data-filter-by="text">Marcus Simmons</span>
                              </span>
                            </label>
                          </div><div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="user-manage-4" checked="">
                            <label class="custom-control-label" for="user-manage-4">
                              <span class="d-flex align-items-center">
                                <img alt="Harry Xai" src="{{ asset('image/1.png') }}" class="avatar mr-2">
                                <span class="h6 mb-0 SPAN-filter-by-text" data-filter-by="text">Harry Xai</span>
                              </span>
                            </label>
                          </div><div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="user-manage-8">
                            <label class="custom-control-label" for="user-manage-8">
                              <span class="d-flex align-items-center">
                                <img alt="David Whittaker" src="{{ asset('image/1.png') }}" class="avatar mr-2">
                                <span class="h6 mb-0 SPAN-filter-by-text" data-filter-by="text">David Whittaker</span>
                              </span>
                            </label>
                          </div><div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="user-manage-12">
                            <label class="custom-control-label" for="user-manage-12">
                              <span class="d-flex align-items-center">
                                <img alt="Kenny Tran" src="{{ asset('image/1.jpg') }}" class="avatar mr-2">
                                <span class="h6 mb-0 SPAN-filter-by-text" data-filter-by="text">Kenny Tran</span>
                              </span>
                            </label>
                          </div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--end of modal body-->

              </div>
            </div>
          </div>

        <section class="section">
            <div class="section-header">
                    <h1>Projects <button class="btn btn-primary ml-3" data-toggle="modal" data-target="#addprojectmodal">
                        <i class="fa fa-plus"></i>
                      </button></h1>


            </div>
            <div class="section-body">
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="input-group">

                            <input type="search" class="form-control  filter-list-input" placeholder="Filter projects" aria-label="Filter Projects">
                            <div class="input-group-append ">
                                <button class="btn btn-primary text-light input-group-text">
                                  <i class="fas fa-filter"></i>
                                </button>
                              </div>

                          </div>
                    </div>
                </div>
                @forelse ($projects->chunk(2) as $chunk)
                    <div class="row">
                        @foreach ($chunk as $project)
                        {{-- @dd($project->users) --}}
                        <div class="col-md-6">
                            <div class="card card-project shadow" style="max-width:30rem">
                                <div class="card-body">
                                    <div class="dropdown card-options">
                                        <button class="btn-options" type="button" id="project-dropdown-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Share</a>
                                        </div>
                                    </div>
                                    <div class="card-title">
                                        <a href="{{route('projects.show',$project->id)}}"><h5>{{ $project->title }}</h5></a>
                                    </div>
                                    <ul class="avatars">
                                        @foreach ($project->users as $users_details)
                                        {{-- @dd($users_details->user->name) --}}
                                        {{-- @foreach ($users_details->user as $user) --}}
                                        <li>
                                            <a href="#" data-toggle="tooltip" data-original-title="{{$users_details->user->name}}">
                                            <img alt="Claire Connors" class="avatar" src="{{asset('uploads/users/'.$users_details->user->id.'/'.$users_details->user->profile_picture)}}">
                                            </a>
                                        </li>
                                        {{-- @endforeach --}}
                                        @endforeach
                                    </ul>
                                    <div class="card-meta d-flex justify-content-between mt-3">
                                        <span class="text-small">{{ Str::limit($project->description,100) }} @if(Str::limit($project->description,100)) <a href="{{route('projects.show',$project->id)}}">View more</a> @endif</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @empty
                <div class="text-center">
                    No Found
                </div>
                @endforelse

            </div>
        </section>
    </div>

@stop


@section('script')
{{-- <script src="{{asset('js/ckeditor.js')}}"></script> --}}
<script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script>
    CKEDITOR.replace( 'project_description' );
    var project_add_url = "{{ route('projects.store') }}";
</script>
<script src="{{ asset('js/app/projects.js') }}"></script>

@stop
