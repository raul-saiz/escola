@extends('front.layouts.mostrar-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'GUARDIES ')
@section('content')

    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Horari Guardies
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
                        <div id="table-default" class="table table-striped table-hover table-reflow">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><button class="table-sort" >Hores</button></th>
                                        <th><button class="table-sort" >Profe</button></th>
                                        <th><button class="table-sort" >Aula</button></th>
                                        <th><button class="table-sort" >Tasca</button></th>
                                        <th><button class="table-sort" >Grup</button></th>
                                        <th><button class="table-sort" >Mòdul</button></th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody">
                                    @for ($h = 1; $h <= 14; $h++)
                                        <tr>
                                            @for ($d = 0; $d <= 5; $d++)
                                                    @if ($d == 0)
                                                    <td class="sort-score">
                                                        {{ $titulo_horas[$h - 1] }}
                                                    </td>
                                                    @else
                                                        @if ($d == $day && isset($asignados[$h][$d]))

                                                            @for($i = 1; $i <=  sizeof($asignados[$h][$d]); $i++)
                                                                @if($i >1)
                                                                    <tr><td></td>
                                                                @endif
                                                                <td>{{ $asignados[$h][$d] [$i] [1]}}</td>
                                                                <td>{{ $asignados[$h][$d] [$i] [3]}}</td>
                                                                <td>{{ $asignados[$h][$d] [$i] [2]}}</td>
                                                                <td>{{ $asignados[$h][$d] [$i] [4]}}</td>
                                                                <td>{{ $asignados[$h][$d] [$i] [0]}}</td>
                                                                @if($i >1)
                                                                    </tr>
                                                                @endif
                                                            @endfor
                                                        @elseif( $d == $day)
                                                           <td>--</td>
                                                           <td>--</td>
                                                           <td>--</td>
                                                           <td>--</td>
                                                        @endif
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
