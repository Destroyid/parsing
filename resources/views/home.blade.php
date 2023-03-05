@extends('layout')

@section('content')
    @if(count($post_l))
        <div class = "block">
            <div class="block1">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th scope="col">News</th>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($post_l as $use)
                        <tr>
                            <td>{{ $use->text }}</td>
                            <td>{{ $use->date }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div><!-- ./table-responsive -->

            <div class="block2">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th scope="col">N</th>
                        <th scope="col">News</th>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($post_r as $use)
                        <tr>
                            <td>{{++$j}}</td>
                            <td>{{ $use->text }}</td>
                            <td>{{ $use->date }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div><!-- ./table-responsive -->
        </div>

        <img height="186" src="{{$img}}">

        <div class = "mx">
            {!! $post_l->appends(['s' => request()->s])->links() !!}
        </div>

    @else
        <p>Новости не найдено...</p>
    @endif
@endsection
