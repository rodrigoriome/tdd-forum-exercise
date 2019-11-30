@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a New Thread</div>
                <div class="card-body">
                    <form action="{{ route('threads.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="channel_id">Choose a Channel:</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value {{ old('channel_id') ?: 'selected' }} hidden disabled>
                                    Please select a channel
                                </option>
                                @foreach (App\Channel::all() as $channel)
                                <option {{ old('channel_id') == $channel->id ?? 'selected' }} value="{{$channel->id}}">
                                    {{$channel->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea class="form-control" id="body" name="body" rows="5" required>{{ old('body') }}
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Publish</button>
                        @if (count($errors))
                        <hr>
                        <div class="alert alert-warning mb-0" role="alert">
                            @foreach ($errors->all() as $error)
                            <p class="mb-0">{{$error}}</p>
                            @endforeach
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
