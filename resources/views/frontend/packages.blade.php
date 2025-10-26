<x-layout-master :title="$title">
    <section class="bg-white">
      <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
          <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-12">
              <h1 class="mb-4 text-4xl tracking-tight font-extrabold text-blue-600">Adeeva Grosir Hotspot</h1>
              <h2 class="mb-4 text-2xl tracking-tight font-extrabold text-gray-900">Paket Internet Hotspot WiFi.</h2>
              <p class="mb-5 font-light text-gray-500 sm:text-xl">Pilih paket internet hotspot sesuai kebutuhan Anda. Pilihan paket internet hotspot kami fleksibel dan murah sesuai kebutuhan Anda
                <br>
                Alamat Outlet Kami: Terminal Gamalama, Samping Ruang Tunggu, Sejajar Dengan Kedai Teh Poci.
                <br>
                Titik Akses WiFi: Adeeva Grosir Hotspot titik akses di kios Adeeva Grosir dan 4 PUTRI CELL titik akses didepan tangga masuk Pasar Gamalama.
              </p>
              @if (session('status'))
                <div id="alert-2" class="flex items-center p-4 mb-4 text-red-500 rounded-lg bg-red-50" role="alert">
                  <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                  </svg>
                  <span class="sr-only">Info</span>
                  <p class="ms-3 text-sm font-medium">
                    {{ session('status') }}
                  </p>
                  <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-2" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                  </button>
                </div>
              @endif
            @error('package')
              <div id="alert-2" class="flex items-center p-4 mb-4 text-red-500 rounded-lg bg-red-50" role="alert">
                <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <p class="ms-3 text-sm font-medium">
                  {{ $message }}
                </p>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-2" aria-label="Close">
                  <span class="sr-only">Close</span>
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                  </svg>
                </button>
              </div>
            @enderror
          </div>
          <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
              <!-- Pricing Card -->
              @foreach ($packages as $key => $package )
              <div class="flex flex-col p-6 mx-auto max-w-lg text-center text-gray-900 bg-white rounded-lg border border-gray-100 shadow  xl:p-8">
                  <h3 class="mb-4 text-2xl text-blue-600 font-semibold">{{ $package['name'] }}</h3>
                    @if ($key === 'daily')
                    <p class="font-light text-gray-500 sm:text-lg">Paket hemat untuk keperluan browsing dan scrolling sosmed anda.</p>
                    @elseif ($key === 'weekly')
                    <p class="font-light text-gray-500 sm:text-lg">Sipaling bisa mengerti anda. cocok untuk keperluan streaming video.</p>
                    @else
                    <p class="font-light text-gray-500 sm:text-lg">Paket internet komplit, menjawab semua kebutuhan internet Anda.</p>
                    @endif
                  <div class="flex justify-center items-baseline my-8">
                      <span class="mr-2 text-5xl font-extrabold text-blue-600">{{ Number::currency($package['price'], locale: 'id', precision: 0) }}</span>
                      @if ($key === 'daily')
                      <span class="text-gray-500">/Hari</span>
                      @elseif ($key === 'weekly')
                      <span class="text-gray-500">/Minggu</span>
                      @else
                      <span class="text-gray-500">/Bulan</span>
                      @endif
                  </div>
                  <!-- List -->
                  <ul role="list" class="mb-8 space-y-4 text-left">
                      <li class="flex items-center space-x-3">
                          <!-- Icon -->
                          <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                          <span>Terhubung <span class="font-semibold">{{ $package['devices'] }} </span>Perangkat</span>
                      </li>
                      <li class="flex items-center space-x-3">
                          <!-- Icon -->
                          <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                          <span>Kecepatan Internet <span class="font-semibold">{{ $package['bandwidth'] }}</span></span>
                      </li>
                      <li class="flex items-center space-x-3">
                          <!-- Icon -->
                          <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                          <span>Masa Aktif Paket: <span class="font-semibold">{{ $package['duration'] }} Hari</span></span>
                      </li>
                      <li class="flex items-center space-x-3">
                          <!-- Icon -->
                          <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                          <span>Batas Kuota <span class="font-semibold">{{ $package['description'] }}</span></span>
                      </li>
                  </ul>
                  <form action="{{ route('validated') }}" method="POST">
                    @csrf
                    <input type="hidden" name="package" value="{{ $key }}">
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Beli Paket</button>
                  </form>
              </div>
              @endforeach
          </div>

          <div class="flex justify-center gap-2 mt-4 mb-6">
            <a href="{{ session('link-hotspot-login') }}" class="flex justify-center gap-0.5 text-blue-600 text-md hover:text-blue-700 font-medium">
              <svg class="w-4 h-4 self-center text-blue-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
              </svg>
              <span class="self-center">Kembali ke Login</span>
            </a>
            <span>|</span>
            <a href="{{ route('check') }}" class="flex justify-center gap-0.5 text-blue-600 text-md hover:text-blue-700  font-medium">
              <span class="self-center">Cek Transaksi</span>
              <svg class="w-4 h-4 text-blue-800 self-center" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
              </svg>
            </a>
          </div>

      </div>
    </section>
</x-layout-master>
