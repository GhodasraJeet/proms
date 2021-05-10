@extends('layouts.app')

@section('title','Profile Details')



@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Users <button class="btn btn-primary ml-3" data-toggle="modal" data-target="#addusermodal">
                <i class="fa fa-plus"></i>
              </button></h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Hi, {{Auth::user()->name }}</h2>
            <p class="section-lead">{{ Auth::user()->title }}
            </p>

            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                  <div class="profile-widget-header">
                    <img alt="image" src="{{ Auth::user()->profile_picture }} " class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Projects</div>
                        <div class="profile-widget-item-value">{{ Auth::user()->project }}</div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                  <form method="post" class="needs-validation" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="card-header">
                      <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{Auth::user()->name}}" id="name" name="name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{Auth::user()->title}}" id="title" name="title">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-7 col-12">
                            <label>Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{Auth::user()->email}}" name="email" id="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
    </section>
</div>

@stop

