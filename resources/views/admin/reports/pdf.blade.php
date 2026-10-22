<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - RentGo Transportasi Cirebon</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #1b3bbb;
            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-600: #475569;
            --slate-200: #e2e8f0;
            --slate-100: #f1f5f9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            background-color: #f8fafc;
            color: var(--slate-900);
            font-size: 12px;
            line-height: 1.5;
            padding-bottom: 40px;
        }

        /* Action Toolbar (Screen Only) */
        .print-toolbar {
            background: #0f172a;
            color: white;
            padding: 12px 24px;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-print {
            background: #1b3bbb;
            color: white;
        }
        .btn-print:hover {
            background: #1632a3;
        }

        .btn-close-view {
            background: #334155;
            color: #cbd5e1;
        }
        .btn-close-view:hover {
            background: #475569;
            color: white;
        }

        /* Printable Paper Canvas */
        .paper-canvas {
            width: 210mm;
            min-height: 297mm;
            margin: 24px auto;
            background: white;
            padding: 20mm;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            border-radius: 4px;
        }

        /* Official Letterhead */
        .letterhead {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 16px;
            border-bottom: 2.5px solid var(--primary);
            margin-bottom: 20px;
        }

        .brand-block h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.03em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-block p {
            color: var(--slate-600);
            font-size: 11px;
            margin-top: 3px;
        }

        .meta-block {
            text-align: right;
            font-size: 10.5px;
            color: var(--slate-600);
        }

        .meta-badge {
            display: inline-block;
            background: #eff4fe;
            color: var(--primary);
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 4px;
            margin-bottom: 6px;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Document Title */
        .doc-title-section {
            margin-bottom: 20px;
        }

        .doc-title-section h2 {
            font-size: 16px;
            font-weight: 800;
            color: var(--slate-900);
            text-transform: uppercase;
            letter-spacing: -0.01em;
        }

        .doc-title-section .doc-subtitle {
            font-size: 11.5px;
            color: var(--slate-600);
            margin-top: 2px;
        }

        /* Executive Metrics Summary Cards */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .metric-box {
            background: #f8fafc;
            border: 1px solid var(--slate-200);
            border-radius: 6px;
            padding: 10px 12px;
        }

        .metric-box .label {
            font-size: 9.5px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--slate-600);
            letter-spacing: 0.04em;
        }

        .metric-box .value {
            font-size: 15px;
            font-weight: 800;
            color: var(--slate-900);
            margin-top: 4px;
        }

        .metric-box .note {
            font-size: 9.5px;
            color: #059669;
            font-weight: 600;
            margin-top: 2px;
        }

        /* Tables */
        .table-title {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--slate-800);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
            margin-bottom: 24px;
        }

        th {
            background-color: #f1f5f9;
            color: var(--slate-800);
            font-weight: 700;
            text-align: left;
            padding: 7px 10px;
            border-bottom: 1.5px solid var(--slate-200);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        td {
            padding: 7px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: middle;
        }

        tr:nth-child(even) td {
            background-color: #fafbfc;
        }

        .badge-status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: 700;
            font-size: 9px;
            text-transform: uppercase;
        }

        .badge-completed { background: #dcfce7; color: #15803d; }
        .badge-approved { background: #dbeafe; color: #1d4ed8; }
        .badge-pending { background: #fef3c7; color: #b45309; }
        .badge-available { background: #dcfce7; color: #15803d; }
        .badge-rented { background: #fef3c7; color: #b45309; }

        /* Sign-off Block */
        .signoff-section {
            margin-top: 36px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            page-break-inside: avoid;
        }

        .signoff-box {
            text-align: center;
            font-size: 11px;
            color: var(--slate-600);
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid var(--slate-800);
            padding-top: 4px;
            font-weight: 700;
            color: var(--slate-900);
        }

        /* Print Media Styles */
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
            }

            .print-toolbar {
                display: none !important;
            }

            .paper-canvas {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            @page {
                size: A4;
                margin: 15mm 15mm;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action Toolbar (Visible on Screen, Hidden when Printed) -->
    <div class="print-toolbar no-print">
        <div class="d-flex align-items-center" style="display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-file-pdf" style="font-size: 18px; color: #f87171;"></i>
            <div>
                <strong style="font-size: 13px;">{{ $title }}</strong>
                <div style="font-size: 11px; color: #94a3b8;">Siap untuk dicetak atau disimpan sebagai PDF (Ctrl/Cmd + P)</div>
            </div>
        </div>
        <div style="display: flex; gap: 8px;">
            <button class="btn-action btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak / Simpan PDF
            </button>
            <button class="btn-action btn-close-view" onclick="window.close()">
                <i class="fas fa-times"></i> Tutup
            </button>
        </div>
    </div>

    <!-- Paper Container -->
    <div class="paper-canvas">
        <!-- Letterhead -->
        <div class="letterhead">
            <div class="brand-block">
                <h1>
                    <i class="fas fa-car-side"></i> RentGo Transportasi
                </h1>
                <p>PT RentGo Transportasi Prima Cirebon • Divisi Operasional & Manajemen Armada</p>
                <p>Jl. Tuparev No. 18, Sutawinangun, Cirebon, Jawa Barat 45153 • Telp: (0231) 882910</p>
            </div>
            <div class="meta-block">
                <div class="meta-badge">Dokumen Resmi Eksekutif</div>
                <div><strong>No. Dok:</strong> RGT/OPS/{{ now()->format('Ym') }}/{{ str_pad(rand(100, 999), 4, '0', STR_PAD_LEFT) }}</div>
                <div><strong>Tanggal:</strong> {{ now()->translatedFormat('d F Y, H:i') }} WIB</div>
                <div><strong>Penyusun:</strong> Senior Operations & Fleet Manager</div>
            </div>
        </div>

        <!-- Document Title -->
        <div class="doc-title-section">
            <h2>{{ $title }}</h2>
            <div class="doc-subtitle">
                @if($startDate && $endDate)
                    Periode Observasi Transaksi: <strong>{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}</strong>
                @else
                    Periode: <strong>Semua Catatan Historis Operasional Terverifikasi (YTD {{ now()->year }})</strong>
                @endif
            </div>
        </div>

        <!-- Executive Metrics Grid -->
        <div class="metrics-grid">
            <div class="metric-box">
                <div class="label">Realisasi Omzet Kotor</div>
                <div class="value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                <div class="note">Termasuk PPN & Jasa Layanan</div>
            </div>
            <div class="metric-box">
                <div class="label">Total Reservasi Selesai</div>
                <div class="value">{{ $stats['completed_bookings'] }} Trip</div>
                <div class="note">+{{ $stats['approved_bookings'] }} Unit Sedang Berjalan</div>
            </div>
            <div class="metric-box">
                <div class="label">Rata-rata Order (AOV)</div>
                <div class="value">Rp {{ number_format($stats['average_order_value'] ?? 0, 0, ',', '.') }}</div>
                <div class="note">Masa Sewa Rata-rata {{ $stats['average_duration'] ?? 0 }} Hari</div>
            </div>
            <div class="metric-box">
                <div class="label">Utilisasi Armada</div>
                <div class="value">{{ $stats['utilization_rate'] }}%</div>
                <div class="note">{{ $stats['available_cars'] }} Unit Standby di Pool</div>
            </div>
        </div>

        @if($type === 'revenue' || $type === 'full')
            <!-- Revenue & Booking Data Table -->
            <div class="table-title">
                <i class="fas fa-receipt text-primary"></i> Rincian Transaksi Persewaan & Realisasi Pendapatan
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 14%;">No. Booking</th>
                        <th style="width: 20%;">Penyewa</th>
                        <th style="width: 22%;">Kendaraan & Plat</th>
                        <th style="width: 18%;">Periode Sewa</th>
                        <th style="width: 14%; text-align: right;">Total Nilai</th>
                        <th style="width: 12%; text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                    <tr>
                        <td><strong>#BK-{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>
                            <strong>{{ $b->customer_name }}</strong><br>
                            <span style="font-size: 9.5px; color: #64748b;">{{ $b->customer_phone }}</span>
                        </td>
                        <td>
                            @if($b->car)
                                <strong>{{ $b->car->brand }} {{ $b->car->model }}</strong><br>
                                <span style="font-size: 9.5px; color: #64748b;">{{ $b->car->plate_number }} • {{ $b->with_driver ? 'Dengan Driver' : 'Lepas Kunci' }}</span>
                            @else
                                <span style="color: #94a3b8;">Unit Terhapus</span>
                            @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($b->start_date)->format('d/m/Y') }}<br>
                            s/d {{ \Carbon\Carbon::parse($b->end_date)->format('d/m/Y') }}
                        </td>
                        <td style="text-align: right;">
                            <strong>Rp {{ number_format($b->total_price, 0, ',', '.') }}</strong>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-status badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 16px;">Tidak ada transaksi ditemukan pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        @if($type === 'cars' || $type === 'full')
            <!-- Fleet Status & Utilization Table -->
            <div class="table-title">
                <i class="fas fa-car text-primary"></i> Daftar Kesiapan & Produktivitas Armada Mobil
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%;">No</th>
                        <th style="width: 28%;">Kendaraan</th>
                        <th style="width: 16%;">Nomor Plat</th>
                        <th style="width: 14%;">Tahun / CC</th>
                        <th style="width: 18%; text-align: right;">Tarif / Hari</th>
                        <th style="width: 16%; text-align: center;">Status Unit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $idx => $car)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>
                            <strong>{{ $car->brand }} {{ $car->model }}</strong><br>
                            <span style="font-size: 9.5px; color: #1b3bbb; font-weight: 600;">{{ $car->category }}</span>
                        </td>
                        <td><code>{{ $car->plate_number }}</code></td>
                        <td>{{ $car->year }}</td>
                        <td style="text-align: right;">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</td>
                        <td style="text-align: center;">
                            <span class="badge-status badge-{{ $car->status }}">
                                @if($car->status == 'available') Siap Jalan
                                @elseif($car->status == 'rented') Sedang Disewa
                                @else Perawatan
                                @endif
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 16px;">Tidak ada data armada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        <!-- Sign-off Block -->
        <div class="signoff-section">
            <div class="signoff-box">
                <div>Mengetahui,</div>
                <div style="font-weight: 700; margin-top: 2px;">Direksi PT RentGo Transportasi</div>
                <div class="signature-line">
                    ( .................................................... )
                    <div style="font-size: 9.5px; font-weight: 400; color: #64748b; margin-top: 2px;">Direktur Operasional</div>
                </div>
            </div>
            <div class="signoff-box">
                <div>Cirebon, {{ now()->translatedFormat('d F Y') }}</div>
                <div style="font-weight: 700; margin-top: 2px;">Senior Operations & Fleet Manager</div>
                <div class="signature-line">
                    <strong>Bpk. Rachmat Hidayat, S.T.</strong>
                    <div style="font-size: 9.5px; font-weight: 400; color: #64748b; margin-top: 2px;">NIP. 2019-RGT-0042</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-trigger print prompt on load -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Give 500ms for fonts & styles to settle, then open print dialog
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
