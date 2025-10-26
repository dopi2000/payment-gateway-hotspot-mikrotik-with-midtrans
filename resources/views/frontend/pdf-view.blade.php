<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    
    <style>
        /* 1. SISIPKAN CSS TAILWIND YANG SUDAH DI-COMPILE DI SINI */
        /* Pastikan di Controller, Anda mengirimkan variabel $tailwind_css */
        {!! $tailwind_css !!}

        /* 2. STYLE DASAR & RESET KHUSUS PDF */
        body { 
            font-family: sans-serif; 
            margin: 0; 
            padding: 0; 
            font-size: 10pt; 
            color: #374151; /* text-gray-700 */
        }
        .container { 
            width: 100%; 
            margin: 0 auto; 
            padding: 20px; 
        }
        
        /* 3. TATA LETAK KOLOM: WAJIB MENGGUNAKAN TABEL (Ganti Flexbox) */
        .header-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
        }
        .header-table td { 
            padding: 0; 
            vertical-align: top;
        }
        
        /* 4. STYLING TABEL DATA UTAMA */
        .data-table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 9pt; 
        }
        .data-table thead tr { 
            background-color: #f9fafb; /* bg-gray-50 */
            color: #4b5563; /* text-gray-600 */
            font-weight: 500;
            border-bottom: 1px solid #e5e7eb;
        }
        .data-table th, .data-table td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        
        /* 5. STYLING STATUS (Disesuaikan dari Tailwind classes) */
        .status { padding: 4px 8px; border-radius: 9999px; font-weight: bold; font-size: 8pt; text-transform: uppercase; display: inline-block; }
        .status-sukses { background-color: #d1fae5; color: #047857; } /* green-100 / green-600 */
        .status-pending { background-color: #dbeafe; color: #1d4ed8; } /* blue-100 / blue-600 */
        .status-gagal { background-color: #fee2e2; color: #b91c1c; } /* red-100 / red-600 */

    </style>
</head>
<body>

<div class="container">
    
    <table class="header-table">
        <tr>
            <td style="width: 70%;">
                <h3 style="color: #1f2937; font-size: 18pt; font-weight: bold; margin-bottom: 8px;">Daftar Transaksi</h3>
                <div>
                    <p style="margin: 3px 0;">
                        Jumlah Transaksi:
                        <span style="font-size: 10pt; font-weight: bold;">{{ $total_order }}</span>
                    </p>
                    <p style="margin: 3px 0;">
                        Jumlah Pendapatan:
                        <span style="font-size: 10pt; font-weight: bold;">{{ Number::currency($total_price, locale: 'id', precision: 0) }}</span>
                    </p>
                </div>
            </td>
            <td style="width: 30%; text-align: right;">
                <p style="font-size: 8pt; color: #4b5563;">Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }}</p>
            </td>
        </tr>
    </table>
    
    <div style="margin-top: 15px; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
        
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 10%;">Order ID</th>
                    <th style="width: 20%;">Pengguna</th>
                    <th style="width: 15%;">Nama Paket</th>
                    <th style="width: 10%;">Harga</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 20%;">Tgl. Transaksi</th>
                    <th style="width: 15%; text-align: right;">Bandwidth</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order )
                <tr>
                    <td style="vertical-align: top;">{{ $order->order_id }}</td>
                    <td style="vertical-align: top;">
                        <div>
                            <span style="display: block; font-weight: bold; font-size: 9pt;">Username: {{ $order->username }}</span>
                            <span style="display: block; font-size: 8pt;">Password: {{ $order->password }}</span>
                        </div>
                    </td>
                    <td style="vertical-align: top;">{{ $order->package_name }}</td>
                    <td style="vertical-align: top;">
                        {{ Number::currency($order->price, locale: 'id', precision: 0) }}
                    </td>
                    <td style="vertical-align: top;">
                        @if ($order->status === "sukses")
                        <span class="status status-sukses">{{ $order->status }}</span> 
                        @elseif ($order->status === "pending")
                        <span class="status status-pending">{{ $order->status }}</span> 
                        @else
                        <span class="status status-gagal">{{ $order->status }}</span> 
                        @endif 
                    </td>
                    <td style="vertical-align: top;">
                        {{ $order->created_at->format('d/M/Y H:i:s')}}
                    </td>
                    <td style="text-align: right; vertical-align: top;">
                        {{ $order->bandwidth }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">Daftar Transaksi Tidak Ada</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>
    
    </div>

</body>
</html>