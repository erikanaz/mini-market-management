<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @hasrole('PegawaiGudang')
                    <x-primary-button tag="a" href="{{ route('transactions.create') }}">Tambah Data Produk</x-primary-button>
                    @endhasrole

                    <x-table>
                        <x-slot name="header">
                            <tr class="py-10">
                                <th scope="col">No</th>
                                <th scope="col">Tanggal Transaksi</th>
                                <th scope="col">User</th>
                                <th scope="col">Cabang</th>
                                <th scope="col">Total Harga</th>
                                @hasrole('PegawaiGudang')
                                <th scope="col">Aksi</th>
                                @endhasrole
                            </tr>
                        </x-slot>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->transaction_date }}</td>
                                <td>{{ $transaction->user_id }}</td>
                                <td>{{ $transaction->branch_id }}</td>
                                <td>{{ $transaction->total_price }}</td>
                                @hasrole('PegawaiGudang')
                                <td>
                                    <x-primary-button tag="a"
                                        href="{{ route('transactions.edit', $transaction->id) }}">Edit</x-primary-button>
                                    <x-danger-button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-stock-deletion')"
                                        x-on:click="$dispatch('set-action', '{{ route('transactions.destroy', $transaction->id) }}')">{{ __('Delete') }}</x-danger-button>
                                </td>
                                @endhasrole
                            </tr>
                        @endforeach
                    </x-table>

                    <x-modal name="confirm-user-deletion" focusable maxWidth="xl">
                        <form method="post" x-bind:action="action" class="p-6">
                            @method('delete')
                            @csrf
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Apakah anda yakin akan menghapus data?') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Setelah proses dilaksanakan. Data akan dihilangkan secara permanen.') }}
                            </p>
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>
                                <x-danger-button class="ml-3">
                                    {{ __('Delete!!!') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </x-modal>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>