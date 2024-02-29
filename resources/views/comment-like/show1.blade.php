@extends('layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center text-danger">Post</h3>
                    <br />
                    <h2>{{ $post->title }}</h2>
                    <p>
                        {{ $post->body }}
                    </p>
                {{-- <a href="{{route('likes.store')}}">like</a> --}}
                {{-- <h4>Add comment</h4> --}}
                    {{-- <form method="post" action="{{route('likes.like')}}"> --}}
                        @csrf
                        <div class="form-group">                         
                            {{-- <input type="hidden" name="post_id" value="{{ $post->id }}" /> --}}
                        </div>
                        <div class="form-group">
                            <a href="{{url('liked/'.$post->id.'/like')}}" class="btn btn-info">like</a>
                      
                            <a href="{{url('liked/'.$post->id .'/disliked')}}"class="btn btn-danger">dislike</a>
                        </div>
                    <hr />
                    <h4>Display Comments</h4>
                    @include('comment-like.commentsDisplay', ['comments' => $post->comments, 'post_id' => $post->id])                   
                    <hr />

                    <h4>Add comment</h4>
                    <form method="post" action="{{route('comments.store')}}">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name="body"></textarea>
                            <input type="hidden" name="post_id" value="{{ $post->id }}" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-danger" value="Add Comment" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection