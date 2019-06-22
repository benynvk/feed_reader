@extends('layouts.app')
@section('content')
    <div class="col-md-12 form-group">
        <a href="{{route('feeds.index')}}">
            <button type="button" class="btn btn-default float-right">Back To List</button>
        </a>
    </div>
    <form method="POST" action="{{route('feeds.store')}}">
        @csrf
        <div class="col-md-12">
            <div class="form-group">
                <label for="title">Title <span class="text-danger">(*)</span>:</label>
                <p class="text-danger">{{ $errors->has('title') ? $errors->first('title') : '' }}</p>
                <input class="form-control" name="title" required value="{{old('title')}}">
            </div>
            <div class="form-group">
                <label for="description">Description <span class="text-danger">(*)</span>:</label>
                <p class="text-danger">{{ $errors->has('description') ? $errors->first('description') : '' }}</p>
                <textarea class="form-control" rows="10" name="description" required>{{old('description')}}</textarea>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <p class="text-danger">{{ $errors->has('category_id') ? $errors->first('category_id') : '' }}</p>
                <select name="category_id" class="form-control">
                    <option value=""></option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" {{old('category_id') ==  $category->id ? 'selected' : ''}}>
                            {{$category->title}}
                        </option>
                    @endforeach
                </select></div>
            <div class="form-group">
                <label for="link">Link:</label>
                <p class="text-danger">{{ $errors->has('link') ? $errors->first('link') : '' }}</p>
                <input class="form-control" name="link" value="{{old('link')}}">
            </div>
            <div class="form-group">
                <label for="comments">Comments:</label>
                <p class="text-danger">{{ $errors->has('comments') ? $errors->first('comments') : '' }}</p>
                <input class="form-control" name="comments" value="{{old('comments')}}">
            </div>
            <div class="form-group">
                <label for="publish_date">Publish Date <span class="text-danger">(*)</span>:</label> (Format: yyyy-mm-dd hh:ii:ss)
                <p class="text-danger">{{ $errors->has('publish_date') ? $errors->first('publish_date') : '' }}</p>
                <input type="text" class="form-control" name="publish_date" required value="{{old('publish_date')}}">
            </div>
        </div>
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
@endsection
