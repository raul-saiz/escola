<div  class="container-x3">
    <div class="px-4 space-y-4 mt-8">
        <form method="get">
            <input class="border-solid border border-gray-300 p-2 w-full md:w-1/4" type="text"
                placeholder="Busca professors de baixa" wire:model="term" />
        </form>
        <div wire:loading>Buscant professors ...</div>
        <div wire:loading.remove>

            @if ($term == '')
                <div class="text-gray-500 text-sm">
                    MODIFICACIO BAIXA : Introdueix el IDENTIFICADOR MAIL de professor de la següent LLISTA .
                </div>
            @else
                <div id="table-default" class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><button class="table-sort" data-sort="sort-name">Nom</button></th>
                                <th><button class="table-sort" data-sort="sort-name">Data inici</button></th>
                                <th><button class="table-sort" data-sort="sort-name">Data Fi</button></th>
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
                                        <td class="sort-name"><a href="{{ route('profe.baixaform',$user->profe) }}">{{ $user->profe }} </a></td>
                                        <td class="sort-city">{{ $user->datain }}</td>
                                        <td class="sort-city">{{ $user->dataout }}</td>
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
