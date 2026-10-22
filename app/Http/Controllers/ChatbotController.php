<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = strtolower($request->message);

        // Generate response berdasarkan konteks database
        $botResponse = $this->generateIntelligentResponse($userMessage);

        return response()->json([
            'success' => true,
            'bot_response' => $botResponse,
            'timestamp' => now()->format('H:i')
        ]);
    }

    private function generateIntelligentResponse(string $message): string
    {
        // Ambil data real-time dari database
        $availableCars = Car::where('status', 'available')->get();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalCars = Car::count();

        // Konteks database untuk AI reasoning
        $context = [
            'available_cars' => $availableCars,
            'pending_bookings' => $pendingBookings,
            'total_cars' => $totalCars,
            'current_date' => now()->format('d F Y'),
            'company_info' => [
                'name' => 'RentGoid indonesia',
                'hours' => '24 jam aktif setiap hari',
                'location' => 'Jl. Flamboyan XIII No D.341 Griya Cempaka Arum Wanasaba Lor Talun - Kab. Cirebon (45171)',
                'requirements' => 'KTP, SIM A, DP 50%',
                'phone' => '6285601700507',
                'email' => 'rentgo.idcirebon@gmail.com',
                'area' => 'Cirebon dan sekitarnya'
            ]
        ];

        // Pattern matching dengan AI-like reasoning
        return $this->analyzeMessage($message, $context);
    }

    private function analyzeMessage(string $message, array $context): string
    {
        $availableCarsList = $context['available_cars'];
        $company = $context['company_info'];

        // Greeting patterns
        if (preg_match('/hai|halo|hello|hi|selamat|pagi|siang|malam/', $message)) {
            $greetings = [
                "Halo! Selamat datang di {$company['name']}! 🚗 Ada yang bisa saya bantu?",
                "Hai! Saya asisten virtual {$company['name']}. Senang bertemu dengan Anda!",
                "Halo! Bagaimana saya bisa membantu kebutuhan rental mobil Anda hari ini?"
            ];
            return $greetings[array_rand($greetings)];
        }

        // Available cars inquiry
        if (preg_match('/mobil.*tersedia|available|ready|ada.*mobil|stock|sewa.*mobil/', $message)) {
            if ($availableCarsList->isEmpty()) {
                return "Maaf, saat ini semua mobil sedang tidak tersedia. 😔\nSilakan coba lagi nanti atau hubungi kami di {$company['phone']}.";
            }

            $response = "🚗 **MOBIL TERSEDIA SAAT INI:**\n\n";
            foreach ($availableCarsList as $car) {
                $price = number_format($car->price_per_day, 0, ',', '.');
                $response .= "• **{$car->brand} {$car->model}** ({$car->year})\n";
                if (!empty($car->transmission)) {
                    $response .= "  ⚙️ Transmisi: " . ucfirst($car->transmission) . "\n";
                }
                $response .= "  💰 Rp {$price}/hari\n";
                $response .= "  ✅ Status: Tersedia\n\n";
            }
            $response .= "Total: {$availableCarsList->count()} mobil ready untuk disewa!";
            return $response;
        }

        // Price inquiry
        if (preg_match('/harga|tarif|biaya|price|berapa.*harga|sewa.*per.*hari|rental.*fee/', $message)) {
            if ($availableCarsList->isEmpty()) {
                return "Silakan tanyakan tentang mobil tersedia terlebih dahulu untuk mengetahui harga.";
            }

            $response = "💰 **TARIF SEWA HARIAN:**\n\n";
            foreach ($availableCarsList as $car) {
                $price = number_format($car->price_per_day, 0, ',', '.');
                $response .= "• {$car->brand} {$car->model}: Rp {$price}/hari\n";
            }
            $response .= "\n💡 *Harga sudah termasuk pajak dan asuransi dasar*";
            $response .= "\n💰 *Sistem DP: 50% saat booking*";
            return $response;
        }

        // Specific car price
        if (preg_match('/harga.*(avanza|brio|xpander|pajero|fortuner|innova)|(avanza|brio|xpander|pajero|fortuner|innova).*harga/', $message)) {
            $carModels = [
                'avanza' => 'Avanza',
                'brio' => 'Brio',
                'xpander' => 'Xpander',
                'pajero' => 'Pajero',
                'fortuner' => 'Fortuner',
                'innova' => 'Innova'
            ];

            foreach ($carModels as $key => $model) {
                if (strpos($message, $key) !== false) {
                    $car = Car::where('model', 'like', "%$model%")->where('status', 'available')->first();
                    if ($car) {
                        $price = number_format($car->price_per_day, 0, ',', '.');
                        return "💰 **{$car->brand} {$car->model}**: Rp {$price}/hari\n\nMobil tersedia untuk disewa sekarang!\n\n📞 Langsung hubungi: {$company['phone']} untuk booking cepat!";
                    } else {
                        return "Maaf, {$model} saat ini tidak tersedia. Silakan tanyakan mobil tersedia atau hubungi {$company['phone']} untuk info lebih lanjut.";
                    }
                }
            }
        }

        // Booking inquiry
        if (preg_match('/booking|pesan|sewa|rental|cara.*pesan|proses.*sewa|pemesanan/', $message)) {
            $response = "📋 **CARA BOOKING MOBIL:**\n\n";
            $response .= "1. **Pilih Mobil** - Tanyakan mobil tersedia ke saya\n";
            $response .= "2. **Tentukan Tanggal** - Start & end date rental\n";
            $response .= "3. **Isi Data Diri** - Nama, No HP lengkap\n";
            $response .= "4. **Bayar DP** - 50% dari total biaya\n";
            $response .= "5. **Ambil Mobil** - Di kantor kami atau antar jemput\n\n";
            $response .= "📞 Langsung hubungi: {$company['phone']} untuk proses cepat!";
            $response .= "\n\n📍 **Lokasi Kantor:**";
            $response .= "\n{$company['location']}";
            return $response;
        }

        // Requirements inquiry
        if (preg_match('/syarat|ketentuan|requirement|persyaratan|dokumen|sim|ktp|jaminan|dp/', $message)) {
            $response = "📄 **SYARAT & KETENTUAN RENTAL:**\n\n";
            $response .= "✅ **Dokumen Wajib:**\n";
            $response .= "• KTP asli (masih berlaku)\n";
            $response .= "• SIM A asli (masih berlaku)\n\n";
            $response .= "💰 **Pembayaran:**\n";
            $response .= "• DP 50% saat booking\n";
            $response .= "• Pelunasan saat ambil mobil\n";
            $response .= "• Bisa transfer Bank/E-wallet\n\n";
            $response .= "⏰ **Waktu Rental:**\n";
            $response .= "• Min. rental: 1 hari (24 jam)\n";
            $response .= "• Overtime: 10%/jam dari harga sewa\n";
            $response .= "• Area layanan: {$company['area']}\n\n";
            $response .= "🚗 **Layanan Tambahan:**\n";
            $response .= "• Antar jemput mobil (biaya sesuai jarak)\n";
            return $response;
        }

        // Location inquiry
        if (preg_match('/lokasi|alamat|tempat|dimana|map|kantor/', $message)) {
            $response = "📍 **LOKASI KANTOR KAMI:**\n\n";
            $response .= "**{$company['name']}**\n";
            $response .= "{$company['location']}\n\n";
            $response .= "🕐 **Jam Operasional:**\n";
            $response .= "{$company['hours']}\n\n";
            $response .= "📱 **Kontak:** {$company['phone']}";
            $response .= "\n\n🗺️ **Buka di Google Maps:**";
            $response .= "\nhttps://maps.google.com/?q=" . urlencode($company['location']);
            return $response;
        }

        // Contact inquiry
        if (preg_match('/kontak|telpon|telepon|hp|whatsapp|wa|call|nomor/', $message)) {
            $response = "📞 **HUBUNGI KAMI:**\n\n";
            $response .= "💬 **WhatsApp:** {$company['phone']}\n";
            $response .= "📞 **Telepon:** {$company['phone']}\n";
            $response .= "📧 **Email:** {$company['email']}\n\n";
            $response .= "🕐 **Jam Layanan:**\n";
            $response .= "{$company['hours']}\n";
            $response .= "📱 **CS 24/7 via WhatsApp!**";
            return $response;
        }

        // Email inquiry
        if (preg_match('/email|surat|electronic mail/', $message)) {
            return "📧 **EMAIL KAMI:**\n\n{$company['email']}\n\nBisa kirim pertanyaan lewat email, dijamin dibalas max 2 jam kerja!";
        }

        // Area service inquiry
        if (preg_match('/area|daerah|wilayah|layanan|servis|jangkauan/', $message)) {
            return "🗺️ **AREA LAYANAN KAMI:**\n\n{$company['area']}\n\nKami melayani rental mobil untuk area Cirebon dan sekitarnya. Bisa antar jemput mobil ke lokasi Anda!";
        }

        // Operating hours inquiry
        if (preg_match('/jam|buka|tutup|operasional|bisa.*datang|kapan.*buka/', $message)) {
            $response = "🕐 **JAM OPERASIONAL KAMI:**\n\n";
            $response .= "{$company['hours']}\n\n";
            $response .= "📱 **Customer Service 24/7 via WhatsApp!**\n";
            $response .= "Meski di luar jam operasional, tim kami siap bantu via WhatsApp.";
            return $response;
        }

        // Thanks response
        if (preg_match('/terima kasih|thanks|makasih|thank you|thx|terimakasih/', $message)) {
            $thanks = [
                "Sama-sama! Senang bisa membantu 🚗",
                "Terima kasih kembali! Semoga harimu menyenangkan!",
                "Dengan senang hati! Jangan ragu bertanya lagi ya!",
                "Sama-sama! Kalau ada pertanyaan lagi, tinggal chat aja 😊"
            ];
            return $thanks[array_rand($thanks)];
        }

        // Help request
        if (preg_match('/bantuan|tolong|help|bantu/', $message)) {
            $response = "🆘 **APA YANG BISA SAYA BANTU?**\n\n";
            $response .= "Saya bisa membantu Anda dengan:\n\n";
            $response .= "🚗 **Info Mobil & Harga:**\n";
            $response .= "• Tanya 'mobil tersedia'\n";
            $response .= "• Tanya 'harga sewa mobil'\n\n";
            $response .= "📋 **Proses Rental:**\n";
            $response .= "• Tanya 'cara booking'\n";
            $response .= "• Tanya 'syarat sewa'\n\n";
            $response .= "📍 **Info Kontak:**\n";
            $response .= "• Tanya 'lokasi kantor'\n";
            $response .= "• Tanya 'nomor telepon'\n\n";
            $response .= "📞 **Butuh bantuan cepat?**\n";
            $response .= "Langsung hubungi: {$company['phone']}";
            return $response;
        }

        // Default response
        $defaultResponses = [
            "Maaf, saya belum paham pertanyaannya. Coba tanyakan tentang:\n• Mobil tersedia\n• Harga sewa\n• Syarat rental\n• Cara booking\n• Lokasi kantor",
            "Sebagai asisten rental, saya bisa bantu Anda dengan:\n🚗 Ketersediaan mobil\n💰 Info harga\n📋 Syarat sewa\n📍 Lokasi & kontak",
            "Saya khusus membantu urusan rental mobil. Coba tanya:\n- 'Mobil apa yang tersedia?'\n- 'Berapa harga sewa Avanza?'\n- 'Apa syarat sewa mobil?'\n- 'Dimana lokasi kantornya?'"
        ];

        return $defaultResponses[array_rand($defaultResponses)];
    }
}
