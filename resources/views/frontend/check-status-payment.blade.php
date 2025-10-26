<x-layout-master :title="$title"> 
<section class="bg-gray-50">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <p class="flex items-center mb-6 text-2xl font-semibold text-blue-600">
            Adeeva Grosir Hotspot    
        </p>
        <div class="w-full p-6 bg-white rounded-lg shadow md:mt-0 sm:max-w-md sm:p-8">
            <h2 class="mb-1 text-center text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                Cek Transaksi
            </h2>
            <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" action="{{ route('payment.check') }}" method="POST">
                @csrf
                <div>
                    <label for="order_id" class="block mb-2 text-sm font-medium text-gray-900 ">Order ID</label>
                    <input type="text" name="order_id" id="order_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="Ketikan order id anda disini." required="">
                    @error('order_id')
                        <p class="text-sm font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cek Transaksi</button>
            </form>
        </div>
    </div>
    </section>
</x-layout-master>
