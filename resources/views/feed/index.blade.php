@extends('layouts.app')
@section('content')
    @if (session('success'))
        <div class="col-md-12 form-group">
            <div class="alert alert-success" role="alert">
                {!! session('success') !!}
            </div>
        </div>
    @endif
    <div class="col-md-12 form-group">
        <form class="form-inline" action="" method="get">
            <div class="form-group">
                <label>Category:</label>
                <select name="category_id" class="form-control">
                    <option value="">Select to filter</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}"
                                {{$categoryID == $category->id ? 'selected' : ''}}>
                            {{$category->title}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-info">Search</button>
            <a href="{{route('feeds.create')}}" class="float-right">
                <button type="button" class="btn btn-success">Create New</button>
            </a>
        </form>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Title</th>
                <th class="text-center">Category</th>
                <th class="text-center">Publish Date</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($feeds as $feed)
                <tr>
                    <td class="text-center align-middle">{{$feed->id}}</td>
                    <td class="align-middle"><a href="{{route('feeds.show', $feed->id)}}">{{$feed->title}}</a></td>
                    <td class="align-middle">{{$feed->category->title?? ''}}</td>
                    <td class="text-center align-middle">{{$feed->publish_date}}</td>
                    <td class="text-center align-middle">
                        <form method="post" action="{{route('feeds.destroy', $feed->id)}}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-delete-feed">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <div>
                <i>Showing {{$feeds->total() > 0 ? ($feeds->currentPage() - 1) * $feeds->perPage() + 1 : 0}}
                    to {{$feeds->lastPage() > $feeds->currentPage() ? $feeds->currentPage() * $feeds->perPage() : $feeds->total()}}
                    of {{$feeds->total()}} entries </i>
            </div>
            {{$feeds->appends(request()->input())->links()}}
        </div>
    </div>
@endsection
