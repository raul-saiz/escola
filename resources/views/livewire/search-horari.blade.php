<div  class="container-x3">

    <div class="px-4 space-y-4 mt-8">
        <form method="get">
            <input class="border-solid border border-gray-300 p-2 w-full md:w-1/4" type="text"
                placeholder="Busca professors" wire:model="term" />
        </form>
        <div wire:loading>Buscant professors ...</div>
        <div wire:loading.remove>

            @if ($term == '')
                <div class="text-gray-500 text-sm">
                    Introdueix el COGNOM ( o primeres lletres ) del professor a buscar.
                </div>
            @else
                <div id="table-default" class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><button class="table-sort" data-sort="sort-name">Id XTEC</button></th>
                                <th><button class="table-sort" data-sort="sort-name">Nom llarg</button></th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
                            @if ($users->isEmpty())
                                <tr>
                                    <div class="text-gray-500 text-sm">
                                        No existeix cap professor amb aquest criteri.
                                    </div>
                                </tr>
                            @else
                                @foreach ($users as $user)
                                    <tr>

                                            <td class="sort-name"><a href="{{ route('profe.horario',$user->nom_c) }}">{{ $user->nom_c }} </a></td>
                                            <td class="sort-city"><a href="{{ route('profe.horario',$user->nom_c) }}">{{ $user->nom_l }}</a></td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

            @endif
        </div>
    </div>
    <div class="px-4 mt-4">
        {{ $users->links() }}
    </div>
</div>
