@extends('back.layouts.pages-layout')
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

                    <div class="col">
                        <form method="post" action="{{ route('profe.salvaguardies') }}" id="assignades">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <span class="badge bg-green"><input type="submit" value="GUARDAR" name="guardar"></span>
                        </form>
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
                                        <th><button class="table-sort" >Dilluns</button></th>
                                        <th><button class="table-sort" >Dimarts</button></th>
                                        <th><button class="table-sort" >Dimecres</button></th>
                                        <th><button class="table-sort" >Dijous</button></th>
                                        <th><button class="table-sort" >Divendres</button></th>

                                    </tr>
                                </thead>
                                <tbody class="table-tbody">


                                    @for ($h = 1; $h <= 14; $h++)
                                        <tr>
                                            @for ($d = 0; $d <= 5; $d++)
                                                <td class="sort-score">
                                                    @if ($d == 0)
                                                        {{ $titulo_horas[$h - 1] }}
                                                    @else
                                                        @if (isset($assig_a_cobrir[$h][$d]))
                                                            {!! $assig_a_cobrir[$h][$d] !!}
                                                        @else
                                                            --
                                                        @endif
                                                    @endif
                                            @endfor
                                            </td>
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
