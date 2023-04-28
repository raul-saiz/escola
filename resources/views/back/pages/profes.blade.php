@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Professors')
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

                    @foreach ($users as $user)
                    <tr>
                        <td class="sort-name"><a href="{{ route('profe.horario',$user->nom_c) }}">{{  $user->nom_c }}</a></td>
                        <td class="sort-city">{{  $user->nom_l }}</td>
                        <td class="sort-type">RMC Hybrid</td>
                        <td class="sort-score">100,0%</td>
                        <td class="sort-date" data-date="1628071164">August 04, 2021</td>
                        <td class="sort-quantity">74</td>
                        <td class="sort-progress" data-progress="30">
                          <div class="row align-items-center">
                            <div class="col-12 col-lg-auto">30%</div>
                            <div class="col">
                              <div class="progress" style="width: 5rem">
                                <div class="progress-bar" style="width: 30%" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" aria-label="30% Complete">
                                  <span class="visually-hidden">30% Complete</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>

                @endforeach

                 </tbody>


              </table>
            </div>

          </div>
        </div>
      <div> {{ $users->onEachSide(5)->links() }} </div>
      </div>
    </div>

  </div>


@endsection
