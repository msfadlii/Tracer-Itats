{{-- resources/views/alumni/success.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Berhasil Dikirim - Alumni Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .fade-in {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .switch-btn {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .switch-btn:hover {
            background-color: #d6cc9a;
        }

        .switch-btn.active {
            background-color: #8b7355;
            color: white;
        }

        .contact-content {
            transition: all 0.3s ease;
        }

        /* Custom beige color palette */
        .bg-beige-50 { background-color: #f8f6f0; }
        .bg-beige-100 { background-color: #f2ebdc; }
        .bg-beige-200 { background-color: #e6d5c3; }
        .bg-beige-300 { background-color: #d6cc9a; }
        .text-beige-600 { color: #8b7355; }
        .text-beige-700 { color: #6b5b47; }
        .text-beige-800 { color: #4a3f35; }
        .border-beige-200 { border-color: #e6d5c3; }
        .border-beige-300 { border-color: #d6cc9a; }
    </style>
</head>
<body class="min-h-screen" style="background-color: #F2EBDC;">
    <div class="flex justify-center items-center min-h-screen px-4 py-8">
        <div class="max-w-md w-full">
            <!-- Kartu Sukses -->
            <div class="bg-white rounded-xl shadow-xl p-8 text-center fade-in border border-beige-200">
                <!-- Ikon Sukses -->
                <div class="w-20 h-20 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 success-pulse">
                    <i class="fas fa-check-circle text-4xl text-white"></i>
                </div>

                <!-- Pesan Sukses -->
                <h1 class="text-3xl font-bold text-green-700 mb-3">Terima Kasih!</h1>
                <p class="text-beige-700 mb-6 leading-relaxed">
                    Formulir alumni Anda telah berhasil disimpan dan dikirim ke sistem kami.
                </p>

                <!-- Info Tambahan -->
                <div class="bg-beige-50 border border-beige-300 rounded-xl p-4 mb-6">
                    <p class="text-sm text-beige-800 flex items-start">
                        <i class="fas fa-info-circle mr-2 mt-0.5 flex-shrink-0 text-beige-600"></i>
                        <span>Data Anda akan diproses dalam 1-2 hari kerja. Tim kami akan menghubungi Anda jika diperlukan informasi tambahan.</span>
                    </p>
                </div>

                <!-- Tombol Aksi -->
                <div class="space-y-3 mb-8">
                    <a href="{{ route('FormAlumni')}}"
                       class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-6 rounded-xl transition duration-300 flex items-center justify-center btn-hover shadow-lg">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Isi Form Lagi
                    </a>
                </div>

                <!-- Kontak -->
                <div class="pt-6 border-t border-beige-200">
                    <p class="text-sm text-beige-600 mb-3">Ada pertanyaan?</p>
                    
                    <!-- Kontak ITATS -->
                    <div id="contact-itats" class="contact-content">
                        <p class="text-sm text-beige-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-beige-600"></i>
                            <a href="mailto:alumni@itats.ac.id" class="text-blue-600 hover:text-blue-700 font-medium">
                                alumni@itats.ac.id
                            </a>
                        </p>
                        <p class="text-sm text-beige-700">
                            <i class="fas fa-phone mr-2 text-beige-600"></i>
                            <a href="tel:+62315947473" class="text-blue-600 hover:text-blue-700 font-medium">
                                (031) 594-7473
                            </a>
                        </p>
                        <p class="text-xs text-beige-600 mt-2">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            Institut Teknologi Adhi Tama Surabaya
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-sm text-beige-600">
                    © 2024 Alumni Mahasiswa - ITATS
                </p>
            </div>
        </div>
    </div>
</body>
</html>