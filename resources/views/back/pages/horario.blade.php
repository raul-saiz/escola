@extends('back.layouts.pages-layout')
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
                                        <th><button class="table-sort" data-sort="sort-name">Nom</button></th>
                                        <th><button class="table-sort" data-sort="sort-city">Nom Complet</button></th>
                                        <th><button class="table-sort" data-sort="sort-type">e-mail</button></th>
                                        <th><button class="table-sort" data-sort="sort-score">Score</button></th>
                                        <th><button class="table-sort" data-sort="sort-date">Date</button></th>
                                        <th><button class="table-sort" data-sort="sort-quantity">Quantity</button></th>
                                        <th><button class="table-sort" data-sort="sort-progress">Progress</button></th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody">


                                    <tr>
                                        <td class="sort-name">{{ $user->nom_c }} </td>
                                        <td class="sort-city">{{ $user->nom_l }}</td>
                                        <td class="sort-type"></td>
                                        <td class="sort-score">100,0%</td>
                                        <td class="sort-date" data-date="1628071164">August 04, 2021</td>
                                        <td class="sort-quantity">74</td>
                                        <td class="sort-progress" data-progress="30">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-lg-auto">30%</div>
                                                <div class="col">
                                                    <div class="progress" style="width: 5rem">
                                                        <div class="progress-bar" style="width: 30%" role="progressbar"
                                                            aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"
                                                            aria-label="30% Complete">
                                                            <span class="visually-hidden">30% Complete</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @foreach ($horas as $hora)
                                        <tr>
                                            <td class="sort-name">{{ $hora->dia }} </td>
                                            <td class="sort-city">{{ $hora->hora }}</td>
                                            <td class="sort-type">{{ $hora->aula }}</td>
                                            <td class="sort-score">{{ $hora->module }}</td>
                                            <td class="sort-score">{{ $hora->curso }}</td>
                                            <td class="sort-score">{{ $hora->module }}</td>
                                            <td class="sort-score">{!! $calendario[$hora->hora][$hora->dia] !!}</td>

                                        </tr>
                                    @endforeach



                                </tbody>


                            </table>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div id="table-default" class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><button class="table-sort" data-sort="sort-name">Dilluns</button></th>
                                        <th><button class="table-sort" data-sort="sort-city">Dimarts</button></th>
                                        <th><button class="table-sort" data-sort="sort-type">Dimecres</button></th>
                                        <th><button class="table-sort" data-sort="sort-score">Dijous</button></th>
                                        <th><button class="table-sort" data-sort="sort-date">Divendres</button></th>

                                    </tr>
                                </thead>
                                <tbody class="table-tbody">

                                    {{--             <tr>
                                        <td class="sort-score">{!! $calendario[2][1] !!}</td>
                                        <td class="sort-score">{!! $calendario[3][2] !!}</td>
                                        <td class="sort-score">{!! $calendario[11][3] !!}</td>
                                        <td class="sort-score">{!! $calendario[14][4] !!}</td>
                                        <td class="sort-score">{!! $calendario[7][5] !!}</td>
                                    </tr>
                                    <tr>
                                        @for ($d = 1; $d < 6; $d++)
                                            <td class="sort-score">{!! $calendario[7][5] !!}</td>
                                        @endfor
                                    </tr> --}}
                                    @for ($h = 1; $h <= 14; $h++)
                                        <tr>
                                            @for ($d = 1; $d <= 5; $d++)
                                                @if ($calendario[$h][$d] == '-')
                                                    <td class="sort-score">-
                                                        <form method="post"
                                                            action="{{ route('profe.horario', $user->nom_c) . '/add' }}">
                                                            <input type="hidden" name="_token"
                                                                value="<?php echo csrf_token(); ?>">
                                                            <input type="hidden" name="hora"
                                                                value="{{ $h }}">
                                                            <input type="hidden" name="dia"
                                                                value="{{ $d }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $user->nom_c }}">
                                                            <span class="badge bg-green"><input type="submit"
                                                                    value="+" name="add"></span>
                                                            <span class="badge bg-red"><input type="submit"
                                                                    value="-" name="delete"></span>

                                                        </form>
                                                    </td>
                                                @elseif ( Str::startsWith($calendario[$h][$d], '---') )
                                                    <td class="sort-score">GUARD
                                                        <form method="post"
                                                            action="{{ route('profe.horario', $user->nom_c) . '/add' }}">
                                                            <input type="hidden" name="_token"
                                                                value="<?php echo csrf_token(); ?>">
                                                            <input type="hidden" name="hora"
                                                                value="{{ $h }}">
                                                            <input type="hidden" name="dia"
                                                                value="{{ $d }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $user->nom_c }}">
                                                            <span class="badge bg-green"><input type="submit"
                                                                value="+" name="add"></span>
                                                            <span class="badge bg-red"><input type="submit"
                                                                    value="-" name="delete"></span>

                                                        </form>
                                                    </td>
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
