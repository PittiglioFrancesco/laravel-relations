@extends('layouts.app')

@section('content')
    <div class="container">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $errors }}</li>
                @endforeach
            </ul>
        @endif
        <form action="{{route('admin.posts.update', $post->id)}}" method="post">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="titolo" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="titolo" name="title" value="{{ old('title', $post->title)}}">
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Descrizione</label>
                <textarea class="form-control" name="content" id="desc" cols="30" rows="10">{{ old('content', $post->content)}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection