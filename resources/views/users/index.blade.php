@extends('layouts.app')

@section('title','User Lists')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<style>
    .error {
        color: red !important;
    }
</style>
@stop

@section('content')

    <div class="main-content" id="user-lists">

        {{-- Project add modal --}}
        <div class="modal fade" tabindex="-1" role="dialog" id="addusermodal">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add User</h5>
                  <button type="button" class="close btn btn-round" data-toggle="tooltip" data-dismiss="modal" aria-label="Close" >
                    <i class="fa fa-times text-white"></i>
                  </button>
                </div>
                <!--end of modal head-->

                <div class="modal-body">
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="team-add-details" role="tabpanel">
                      <h6 class="mb-4">User Details</h6>
                      <form action="{{ route('users.store') }}" method="post" id="add_user_form" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-3">Name</label>
                            <div class="col-9">
                                <input class="form-control col" type="text" placeholder="Name" name="user_name" id="user_name">
                                <span class="error" role="alert" data-error="user_name">
                                </span>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-3">Email</label>
                            <div class="col-9">
                                <input class="form-control col" type="email" placeholder="Email" name="user_email" id="user_email">
                                <span class="error" role="alert" data-error="user_email">
                                </span>
                            </div>
                          </div>
                        <div class="form-group row">
                        <label class="col-3">Title</label>
                        <div class="col-9">
                            <input class="form-control col" type="text" placeholder="Title" name="user_title" id="user_title">
                            <small class="text-muted w-100 d-block">Ex.: Project Manager,Web Developer, Backend Developer</small>
                            <span class="error" role="alert" data-error="user_title">
                            </span>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-3">Profile Picture</label>
                        <div class="col-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="user_profile" id="user_profile">
                                <label class="custom-file-label" for="user_profile">Choose file</label>
                            </div>
                        </div>
                      </div>
                      <div class="form-group form-check">
                          <div class="row">
                            <div class="col-3"></div>
                            <div class="col-9">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="send" type="checkbox"> Send a email on user account with email and password.
                                  </label>
                            </div>
                          </div>

                      </div>
                      <button role="button" class="btn btn-primary float-right" type="submit">
                        Done
                      </button>
                    </form>
                    </div>
                  </div>
                </div>
                <!--end of modal body-->

              </div>
            </div>
        </div>

        <section class="section">
            <div class="section-header">
                <h1>Users <button class="btn btn-primary ml-3" data-toggle="modal" data-target="#addusermodal">
                    <i class="fa fa-plus"></i>
                  </button></h1>
            </div>
            <div class="section-body">
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="search" class="form-control  filter-list-input" placeholder="Filter Users" aria-label="Filter Users">
                            <div class="input-group-append ">
                                <button class="btn btn-primary text-light input-group-text">
                                  <i class="fas fa-filter"></i>
                                </button>
                              </div>
                          </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped text-center" id="dataTableUserList">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Email</th>
                                        <th>profile_picture</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </section>
    </div>

@stop


@section('script')
{{-- <script src="{{asset('js/ckeditor.js')}}"></script> --}}
<script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>

    var user_add_url = "{{ route('users.store') }}", user_list_url = "{{ route('users.list') }}";
</script>
<script src="{{ asset('js/app/users/users.js') }}"></script>

@stop
