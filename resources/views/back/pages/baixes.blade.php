@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Absències')
@section('content')

    <div class="container-x3">
        <div class="card">
            <div class="card-body">
                <div x-4>
                    <div class="col">
                        @livewire('search-baixa')
                    </div>
                </div>
                <div id="table-default" class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><button class="table-sort" data-sort="sort-name">Nom</button></th>
                                <th><button class="table-sort" data-sort="sort-city">Data inici</button></th>
                                <th><button class="table-sort" data-sort="sort-type">Data fi</button></th>
                                <th><button class="table-sort" data-sort="sort-type">tasca</button></th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
                            @if (isset($users))
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="sort-name">{{ $user->profe }}</td>
                                        <td class="sort-city">{{ $user->datain }}</td>
                                        <td class="sort-type">{{ $user->dataout }}</td>
                                        <td class="sort-type">{{ $user->tasca }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="sort-name">--</td>
                                    <td class="sort-city">--</td>
                                    <td class="sort-type">--</td>
                                    <td class="sort-type">--</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            @if (isset($users))
                {{ $users->onEachSide(15)->links() }}
            @endif
        </div>
    </div>

    <div class="container-x3">
        <div class="card">
            <div class="card-body">
                <div x-4>
                    <div class="col">
                        @livewire('search-profe')
                    </div>
                </div>
            </div>
        </div>
        <div>
            @if (isset($users))
             {{ $users->onEachSide(10)->links() }}
            @endif
        </div>
    </div>
@endsection
