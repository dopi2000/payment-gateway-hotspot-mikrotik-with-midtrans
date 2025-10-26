<x-layout-master> 
 <section class="bg-gray-50">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-blue-600">
            Adeeva Grosir Hotspot
        </a>
        <div class="w-full bg-white rounded-lg shadow  md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h6 class="text-lg font-bold leading-tight text-center tracking-tight text-blue-600 md:text-xl">
                    Halaman Login Admin
                </h6>
                <form class="space-y-4 md:space-y-6" action="{{ route('validated.admin') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email Admin</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 " placeholder="name@email.email" value="{{ old('email') }}" required="">
                        @error('email')
                        <p class="text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Kata Sandi</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 " required="">
                        @error('password')
                        <p class="text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-cente">Masuk</button>
                   
                </form>
            </div>
        </div>
    </div>
    </section>
</x-layout-master>
