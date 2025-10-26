<x-layout-master :title="$title"> 

    <div class="max-w-screen-xl mx-auto px-4 md:px-8 mt-10 mb-4" >
        <div class="items-start justify-between md:flex">
            <div class="max-w-lg">
                <h3 class="text-gray-800 text-xl font-bold sm:text-2xl">Daftar Transaksi</h3>
                <div class="mt-2">
                    <p class="text-gray-800">Jumlah Transaksi:
                        <span class="text-sm font-semibold">{{ $total_order }}</span>
                    </p>
                    <p class="text-gray-800">Jumlah Pendapatan:
                        <span class="text-sm font-semibold">{{ Number::currency($total_price, locale: 'id', precision: 0) }}</span>
                    </p>
                </div>
            </div>
            @if (strpos(url()->current(), 'pdf') == false)
            <div class="mt-3 md:mt-0">
            <a href="{{ route('logout') }}" class="inline-block px-4 py-2 text-white duration-150 font-medium bg-blue-600 rounded-lg hover:bg-blue-500 active:bg-blue-700 md:text-sm">Keluar</a>
            <a href="{{ route('view.pdf') }}" target="_blank" class="inline-block px-4 py-2 text-gray-700 duration-150 font-medium bg-gray-200 rounded-lg hover:bg-gray-300 active:bg-gray-200 hover:text-gray-500 md:text-sm">Export PDF</a>
            </div>
            @endif
        </div>
        <div class="mt-7 shadow-sm border rounded-lg overflow-x-auto">
            <table class="w-full table-auto text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium border-b">
                    <tr>
                        <th class="py-1 px-3">Order ID</th>
                        <th class="py-1 px-3">Pengguna</th>
                        <th class="py-1 px-3">Nama Paket</th>
                        <th class="py-1 px-3">Harga</th>
                        <th class="py-1 px-3">Status</th>
                        <th class="py-1 px-3">Tgl. Transaksi</th>
                        <th class="py-1 px-3">Bandwidth</th>
                    </tr>
                </thead>
                @forelse ($orders as $order )
                <tbody class="text-gray-600 divide-y">
                    <tr>
                        <td class="flex items-center gap-x-3 py-3 px-6 whitespace-nowrap">
                            {{ $order->order_id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <span class="block text-gray-700 text-sm font-medium">Username: {{ $order->username }}</span>
                                <span
                                class="block text-gray-700 text-xs">Password: {{ $order->password }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $order->package_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ Number::currency($order->price, locale: 'id', precision: 0) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($order->status === "sukses")
                            <span class="py-2 px-3 rounded-full font-semibold text-xs uppercase text-green-600 bg-green-100">{{ $order->status }}</span> 
                            @elseif ($order->status === "pending")
                            <span class="py-2 px-3 rounded-full font-semibold text-xs uppercase text-blue-600 bg-blue-100">{{ $order->status }}</span> 
                            @else
                            <span class="py-2 px-3 rounded-full font-semibold text-xs uppercase text-red-600 bg-red-100">{{ $order->status }}</span> 
                            @endif 
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $order->created_at->format('d/M/Y H:i:s')}}
                        </td>
                        <td class="text-right px-6 whitespace-nowrap">
                            {{ $order->bandwidth }}
                        </td>
                    </tr>
                </tbody>
                @empty
                 <div class="mt-10 text-center">
                    <span>Daftar Transaksi Tidak Ada</span>
                 </div>
                @endforelse
            </table>
            @if (!request()->is('view/pdf'))
            <div class="flex justify-center my-4">
                {{ $orders->links() ?? 0 }}
            </div>
            @endif
        </div>
    </div>
</x-layout-master>
