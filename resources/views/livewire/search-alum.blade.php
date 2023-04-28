<div>
    <div class="px-4 space-y-4 mt-8">
        <form method="get">
            <input class="border-solid border border-gray-300 p-2 w-full md:w-1/4" type="text"
                placeholder="Search Users" wire:model="term" />
        </form>
        <div wire:loading>Searching users...</div>
        <div wire:loading.remove>
      
            @if ($term == '')
                <div class="text-gray-500 text-sm">
                    Enter a term to search for users.
                </div>
            @else
                <div id="table-default" class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><button class="table-sort" data-sort="sort-name">Nom</button></th>
                                <th><button class="table-sort" data-sort="sort-city">Nom Complet</button></th>
                                <th><button class="table-sort" data-sort="sort-type">e-mail</button></th>
                                <th><button class="table-sort" data-sort="sort-type">dni</button></th>
                                <th><button class="table-sort" data-sort="sort-type">nie</button></th>
                                <th><button class="table-sort" data-sort="sort-type">pass</button></th>
                                <th><button class="table-sort" data-sort="sort-date">Date</button></th>
                                <th><button class="table-sort" data-sort="sort-quantity">Quantity</button></th>
                                <th><button class="table-sort" data-sort="sort-progress">Progress</button></th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
                            @if ($users->isEmpty())
                                <tr>
                                    <div class="text-gray-500 text-sm">
                                        No matching result was found.
                                    </div>
                                </tr>
                            @else
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="sort-name">{{ $user->nom }}</td>
                                        <td class="sort-city">{{ $user->cognom1 }}</td>
                                        <td class="sort-type">{{ $user->cognom2 }}</td>
                                        <td class="sort-score">{{ $user->dni }}</td>
                                        <td class="sort-score">{{ $user->nie }}</td>
                                        <td class="sort-score">{{ $user->pas }}</td>

                                        <td class="sort-date" data-date="1628071164">August 04, 2021</td>
                                        <td class="sort-quantity"> {{ $user->id }}</td>
                                        <td class="sort-progress" data-progress="{{ $user->id % 100 }}">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-lg-auto">{{ $user->id % 100 }}%</div>
                                                <div class="col">
                                                    <div class="progress" style="width: 5rem">
                                                        <div class="progress-bar" style="width: {{ $user->id % 100 }}%"
                                                            role="progressbar" aria-valuenow="{{ $user->id % 100 }}"
                                                            aria-valuemin="0" aria-valuemax="100"
                                                            aria-label="FaltesPossibles">
                                                            <span class="visually-hidden">{{ $user->id % 100 }}%
                                                                Complete</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
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
