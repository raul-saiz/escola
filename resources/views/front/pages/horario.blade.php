@extends('front.layouts.mostrar-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Horari - ' . $user->nom_c)
@section('content')

    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Professors
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">

                <div class="card">
                    <div class="card-body">
                        <div id="table-default" class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><button class="table-sort" data-sort="sort-name">Hores</button></th>
                                        <th><button class="table-sort" data-sort="sort-name">Dilluns</button></th>
                                        <th><button class="table-sort" data-sort="sort-city">Dimarts</button></th>
                                        <th><button class="table-sort" data-sort="sort-type">Dimecres</button></th>
                                        <th><button class="table-sort" data-sort="sort-score">Dijous</button></th>
                                        <th><button class="table-sort" data-sort="sort-date">Divendres</button></th>

                                    </tr>
                                </thead>
                                <tbody class="table-tbody">


                                    @for ($h = 1; $h <= 14; $h++)
                                        <tr>
                                            @for ($d = 1; $d <= 5; $d++)
                                                @if( $d ==1)
                                                <td class="sort-score">{{ $titulo_horas[$h-1]  }}
                                                @endif
                                                @if ($calendario[$h][$d] === '-')
                                                    <td class="sort-score">-</td>
                                                @elseif ( strcmp($calendario[$h][$d],'GUARDIA') === 0 || strcmp($calendario[$h][$d],'G') === 0) )
                                                    <td class="sort-score">GUARDIA</td>
                                                @else
                                                    <td class="sort-score">{!! $calendario[$h][$d] !!}</td>
                                                @endif
                                            @endfor
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
