@extends('layouts.app')
@section('content')
    <div class="col-md-12 form-group">
        <a href="{{route('feeds.index')}}">
            <button type="button" class="btn btn-default float-right">Back To List</button>
        </a>
    </div>
    @if (session('success'))
        <div class="col-md-12 form-group">
            <div class="alert alert-success" role="alert">
                {!! session('success') !!}
            </div>
        </div>
    @endif
    <div class="col-md-12">
        <div class="form-group">
            <label for="ID">ID:</label>
            <span>{{$feed->id}}</span>
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <span>{{$feed->title}}</span>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <p class="box-desc">{!! $feed->description !!}</p>
        </div>
        <div class="form-group">
            <label for="link">Link:</label>
            <a href="{{$feed->link}}">{{$feed->link}}</a>
        </div>
        <div class="form-group">
            <label for="comments">Comments:</label>
            <span>{{$feed->comments}}</span>
        </div>
        <div class="form-group">
            <label for="publish_date">Publish Date:</label>
            <span>{{$feed->publish_date}}</span>
        </div>
    </div>
    <div class="col-md-12 text-center">
        <a href="{{route('feeds.edit', $feed->id)}}">
            <button type="button" class="btn btn-success">Edit</button>
        </a>
        <form method="post" action="{{route('feeds.destroy', $feed->id)}}" class="form-inline">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger btn-delete-feed">Delete</button>
        </form>
    </div>
@endsection
