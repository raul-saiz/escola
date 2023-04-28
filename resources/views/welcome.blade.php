@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'SEARCHING')
@section('content')
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div x-4>
                    <div class="col">
                        @livewire('search-alum')
                    </div>
                </div>
            </div>
        </div>
        {{-- <div> {{ $users->onEachSide(5)->links() }} </div> --}}
    </div>
@endsection
