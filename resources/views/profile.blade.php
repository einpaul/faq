@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">My Profile</div>

                    <div class="card-body ">
                        <div>
                            @if (Auth::user()->google_id)
                                <img src="{{URL::asset($data['user']->avatar_original)}}" alt="profile Pic" height="200" width="200">
                            @endif
                        </div>
                        <span class="font-weight-bold">First Name:</span> {{($data['profile']->fname)}}</br>
                        <span class="font-weight-bold">Last Name: </span>{{($data['profile'])->lname}}</br>
                        <span class="font-weight-bold">Email: </span>{{($data['profile'])->user->email}}</br>
                        <span class="font-weight-bold">Body: </span>{{($data['profile'])->body}}</br>
                        <span class="font-weight-bold">Type: </span>{{($data['profile'])->user->type}}</br>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-success float-right" href="{{ route('profile.edit', ['profile_id' => ($data['profile']->id),'user_id' => ($data['profile']->user->id) ])}}">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
