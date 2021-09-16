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
        </div>

        <form action="{{ route('admin.posts.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="titolo" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="titolo" name="title" value="{{ old('title')}}">
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Categoria</label>
                <select name="category_id" id="category">
                    <option value="">-- Seleziona una categoria--</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}"
                            @if($category->id == old('category_id'))
                            selected
                            @endif
                            >
                            {{$category->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Descrizione</label>
                <textarea class="form-control" name="content" id="desc" cols="30" rows="10" value="{{ old('content')}}"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection