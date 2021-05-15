@forelse ($projects->chunk(2) as $chunk)
    <div class="row">
        @foreach ($chunk as $project)
        @php
        if(!is_null($project->projects)){
        @endphp
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
                        <li>
                            <a href="#" data-toggle="tooltip" data-original-title="{{$users_details->user->name}}">
                            <img alt="Claire Connors" class="avatar" src="{{asset('uploads/users/'.$users_details->user->id.'/'.$users_details->user->profile_picture)}}">
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="card-meta d-flex justify-content-between mt-3">
                        <span class="text-small">{{ Str::limit($project->description,100) }} @if(Str::limit($project->description,100)) <a href="{{route('projects.show',$project->id)}}">View more</a> @endif</span>
                    </div>
                </div>
            </div>
        </div>
        @php
        }
        @endphp
        @endforeach
    </div>
@empty
<div class="text-center">
    No Projects Found
</div>
@endforelse
{!! $projects->links() !!}
