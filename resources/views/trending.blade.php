@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Trending</div>
                    <div class="card-body">
                        @if($trendings->count())
                            <ul>
                                @foreach($trendings as $key => $each)
                                    @if(starts_with($each['url'], '/blog/') && $each['pageTitle'] != '(not set)')
                                        <li>
                                            <div class="article">
                                                <a href="{{ $each['url'] }}" title="{{ $each['pageTitle'] }}">
                                                    {{ $each['pageTitle'] }}
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
