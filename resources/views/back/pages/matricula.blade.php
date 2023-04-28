@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Matricula - ' . $user->nom_c)
@section('content')

    <div class="mb-3">
        <div class="form-label">Modul</div>
        <select class="form-select">
            @foreach ($modulos as $modul)
                <option value="{{ $modul }}">{{ $modul }}</option>
            @endforeach
        </select>
    </div>

    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div x-4>
                    <div class="col">
                        @livewire('matricula-alum')
                    </div>
                </div>
            </div>
        </div>
        {{-- <div> {{ $users->onEachSide(5)->links() }} </div> --}}
    </div>

@endsection
