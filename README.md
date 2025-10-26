
# Gerbang Pembayaran dan Pembuatan Voucher Otomatis Dengan Midtrans
Aplikasi ini dibuat untuk gerbang pembayaran dan pembuatan voucher hotspot WiFi pada mikrotik yang di integrasikan dengan gerbang pembayaran midtrans sebagai penyedia jasa gerbang pembayaran yang digunakan dalam aplikasi ini. Aplikasi ini dibuat menggunkan framework laravel. Aplikasi ini bebas digunakan terkhusus untuk pengusaha rt/rw net serta dimodifikasi atau dikembangkan lebih jauh. developer secara terbuka untuk kolaborasi dalam pengembangan aplikasi ini.

[![N|Solid](https://raw.githubusercontent.com/laravel/art/d5f5e725c27f877ed032225fe0b00afee9337d0f/laravel-logo.svg)](https://laravel.com/)


## Persyaratan : 

- Laravel 12.x.x atau terbaru
- Tailwind CSS 4.x.x atau terbaru
- NodeJs 22.x atau yang terbaru
- mysql 8.x atau sqlite
- Memilik akun midtrans
- Memiliki domain publik

## Fitur

- Halaman Admin
- Cek status transaksi



## Cara penggunaan dan Konfigurasi
  - Konfigurasi pada file .env  dengan menambahkan variabel berikut :
     ### Konfigurasi untuk akun midtrans
    ```sh
    MIDTRANS_MERCHANT_ID=isi dengan merchant id dari akun midtrans anda
    MIDTRANS_CLIENT_KEY=isi dengan client key dari akun midtrans anda
    MIDTRANS_SERVER_KEY=isi dengan server key dari akun midtrans anda
    MIDTRANS_IS_PRODUCTION=false // masih tahap pegembangan set ke false tapi sudah tahap production set ke true
    MIDTRANS_IS_SANITIZED=true
    MIDTRANS_IS_3DS=true
    ```
    Note: pada akun midtrans memiliki dua enviroment. jika masih tahap pengembangan gunakan enviroment sandbox pada midtrans dan gunakan server key dan client key pada mode sandbox. jika tahap penggunaan aplikasi ke customer,  maka ganti server key dan client key dengan menggunakan enviroment production.
    agar status pembayaran user dapat diupdate secara real time. maka set pada akun midtrans anda di menu settings>payment>notification url seperti berikut:
    https://nama_domain.com/callback. ini bertujuan untuk menerima callback dari midtrans. bisa disetting pada mode production atau sandbox.
     ### Konfigurasi untuk perangkat mikrotik anda
    ```sh
    MIKROTIK_HOST =ip address mikrotik anda
    MIKROTIK_USERNAME=username anda
    MIKROTIK_PASSWORD= password anda
    MIKROTIK_PORT=8728
    ```
    Note:Di mikrotik anda jangan lupa, pada menu IP>hostpot>users profile.
    untuk membuat user profile dengan sesuai paket yang dijual. pada aplikasi ini secara default saya buat 3, yaitu : paket-harian, paket-mingguan, dan paket bulanan dengan konfigurasi masing-masing user profile sesuai dengan konfigurasi paket yang anda tawarkan.
## Instalasi dan Pemasangan
Salin repository ini menggunakan git ke folder anda serta jalanakan perintah ini pada terminal
```sh
git clone https://github.com/dopi2000/payment-gateway-hotspot-mikrotik-with-midtrans.git
composer install
```
Langkah selanjutnya buat dulu file .env 
  ```
  cp .env.example .env
  
  ```

## Tahap Deployment dan Hosting.

Pada tahap ini, untuk hostingan saya menggunakan home server pribadi. Tujuanya agar aplikasi ini dapat berkomunikasi dengan perangkat mikrotik dan tentu saja gratis tanpa menggunakan VPS atau hostingan berbayar. kalau anda menggunakan VPS atau hostingan maka diusahakan aplikasi ini bisa berkomunikasi pada perangkat mikrotik dalam satu jaringan menggunakan vpn.

Home server yang saya gunakan mengunakan stb indihome bekas dengan merek Fiberhome HG-680-P kemdian saya instalakan armbian dan CasaOS.

 #### Cara deployment mengunakan docker.
- Pastikan docker sudah terinstall pada perangkat anda.
- Copykan Aplikasi ini ke folder home server anda. terserah lokasinya folder dimana saja jangan lupa dengan file .env karena secara otomatis linux akan menganggap file tersebut tersembunyi. dan atur file .env pada variabel APP_ENV=production dan  APP_DEBUG=false
 - ganti izin file seperti perintah berikut 
    ```
    sudo chmod -R 755 bootstrap/cache storage public
    ```
    jika aplikasi  ketika webserver mengeksekusi  dan terkendala masalah izin file maka untuk  sementara izin file ganti dengan angka 755 dengan 777 
 - Masuk pada folder aplikasi ini dan jalankan perintah berikut.
      ```
      docker compose up --build -d
      ```
- Tunggu proses penginstallan selesai
- Jika sudah selesai jalankan perintah berikut
  ```
  docker exec paymentloginhotspot php artisan key:generate
  docker exec paymentloginhotspot php artisan migrate
  docker exec paymentloginhotspot php artisan db:seed --force
  docker exec paymentloginhotspot php artisan optimize
  ```
- Untuk akses aplikasi ini pada IP address dari home server anda

Note: untuk yang diinstall lewat docker compose adalah image php-fpm versi 8.4, kemudian nginx:alpine pada port 80, mysql:8.0 pada port 3306, dan arm64v8/phpmyadmin pada port 808. Jika anda install pada perangkat yang bukan beraksitektur ARM maka ganti nama image untuk yang beraksitetur yang bukan ARM pada file docker-compose.yml dibagian image. untuk nomor port bisa anda kostumisasi pada file docker-compose.yml.

# Tambahan

Untuk mengkases halaman admin pada url http://ip_address/login atau http:/nama_domain/login. Untuk username dan password default:

- ## Username : admin@email.com
- ## Password : admin

Untuk mengakses halaman phpmyadmin pada url  http://ip_address:808 atau http:/nama_domain:808

- ## Username : root
- ## Password : root


 pada file middleware di lokasi folder app/http/middleware/HotspotAccessAllowedMiddleware.php
 
         $allowedIps = [
            '10.10.10.0/24',
            '20.20.20.0/24',
        ];
pada variabel di atas sesuaikan dengan rentang IP yang anda atur pada mikrotik anda kemudian pada baris kode berikut

        if(!$isValidRequest) {
            $clientIp = $request->ip();
            if(IpUtils::checkIp($clientIp, $allowedIps)) {
                    $isValidRequest = true;
              if(IpUtils::checkIp($clientIp, '10.10.10.0/24')) {
                  session()->put('link-hotspot-login', 'http://nama_domain/login');
                } else {
                  session()->put('link-hotspot-login', 'http://nama_domain/login');
              }
            }
        }
sesuiakan dengan nama domain yang anda atur di mikrotik.