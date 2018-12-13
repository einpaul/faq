@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            Question
                        </div>
                        <div class="float-right">
                            @if ($question->user->google_id)
                                <img src="{{URL::asset($question->user->avatar_original)}}" alt="profile Pic" height="45" width="45">
                            @elseif($question->user->profile)
                               -{{$question->user->profile->fname}}
                            @endif
                        </div>
                    </div>

                    <div class="card-body">

                        {{$question->body}}
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary float-right"
                           href="{{ route('questions.edit',['id'=> $question->id])}}">
                            Edit Question
                        </a>

                        {{ Form::open(['method'  => 'DELETE', 'route' => ['questions.destroy', $question->id]])}}
                        <button class="btn btn-danger float-right mr-2" value="submit" type="submit" id="submit">Delete
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><a class="btn btn-primary float-left"
                                                href="{{ route('answers.create', ['question_id'=> $question->id])}}">
                            Answer Question
                        </a></div>

                    <div class="card-body">
                        @forelse($question->answers as $answer)
                            <div class="card">
                                <div class="card-body">{{$answer->body}}</div>
                                <div class="card-footer">

                                    <div class="float-left">
                                        <a class="btn btn-primary"
                                           href="{{ route('answers.show', ['question_id'=> $question->id,'answer_id' => $answer->id]) }}">
                                            View
                                        </a>
                                    </div>
                                    <div class="float-right">
                                        @if ($answer->user->google_id)
                                            <img src="{{URL::asset($answer->user->avatar_original)}}" alt="profile Pic" height="45" width="45">
                                        @elseif($answer->user->profile)
                                           -{{$answer->user->profile->fname}}
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="card">
                                <div class="card-body"> No Answers</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
@endsection
