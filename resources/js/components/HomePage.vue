<template>
    <!-- Hero Section -->
    <section class="relative w-full h-[400px] bg-cover bg-center flex items-center justify-center text-center text-white px-4 md:px-8"
        :style="{ backgroundImage: `url('${heroImage}')` }">
        <div class="p-4 md:p-8 rounded-lg max-w-2xl">
            <h2 class="text-xl md:text-3xl font-bold">
                Bergabunglah dalam perjalanan menuju hidup sehat dengan mengontrol gula dan kalori!
            </h2>
            <p class="mt-4 text-sm md:text-lg">
                Platform yang membantu kamu mengelola pola makan dengan lebih sehat, mengontrol gula dan kalori, 
                serta menjaga keseimbangan nutrisi untuk hidup yang lebih baik.
            </p>
            <div class="mt-6">
                <a href="#" class="bg-gradient-to-r from-[#007AFF] to-[#00D26A] text-white px-5 md:px-7 py-2 rounded-md text-sm font-semibold">Mulai Sekarang</a>
                <a href="#" class="border border-white text-white px-5 md:px-7 py-2 rounded-md text-sm font-semibold ml-2">Pelajari Selengkapnya</a>
            </div>
        </div>
    </section>

    <!-- Auto Scroll Image Section -->
    <section class="relative bg-white py-2" style="overflow: visible;">
        <div class="scroller">
            <div class="scroller__inner">
                <img v-for="(src, idx) in scrollerImages" :key="'img-'+idx" :src="src" :alt="`Card ${idx % 3 + 1}`" class="rounded-xl object-cover h-[110px] w-[180px] shadow-md" />
            </div>
        </div>
    </section>

    <!-- Cards Section -->
     <section id="program" class="relative z-20 bg-white py-12 px-6">
        <h2 class="text-3xl font-bold text-center mb-6">
            Mari Kendalikan Gula & Kalori untuk Hidup Sehat!
        </h2>
        <br/>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <img :src="cardImages.diabetes" alt="Mencegah Diabetes" class="mb-4 w-full">
                <h3 class="font-bold text-lg text-[#003266]">Mencegah Diabetes</h3>
                <p class="text-[#003266]">Mengontrol asupan gula membantu menjaga kadar gula darah tetap stabil dan mengurangi risiko diabetes tipe 2.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <img :src="cardImages.weight" alt="Menjaga Berat Badan" class="mb-4 w-full">
                <h3 class="font-bold text-lg text-[#003266]">Menjaga Berat Badan Ideal</h3>
                <p class="text-[#003266]">Mengatur kalori dengan baik mencegah kelebihan berat badan dan obesitas.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <img :src="cardImages.energy" alt="Meningkatkan Energi" class="mb-4 w-full">
                <h3 class="font-bold text-lg text-[#003266]">Meningkatkan Energi & Kesehatan</h3>
                <p class="text-[#003266]">Pola makan seimbang membuat tubuh lebih bertenaga dan mengurangi risiko penyakit kronis.</p>
            </div>
        </div>
    </section>

   <!-- FAQ Section -->
  <section id="faq" class="relative z-20 bg-white py-12 px-6 flex flex-col items-center" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-screen-md w-full">
        <h2 class="text-3xl font-bold text-center mb-8" style="font-family: 'Poppins', sans-serif;">
            Pertanyaan yang Sering Diajukan (FAQ)
        </h2>

        <div class="flex flex-col gap-6 items-center">
            <div class="bg-[#D2E7FF] p-6 rounded-lg shadow-md flex flex-row items-center space-x-4 w-full transform translate-x-4">
                <img :src="faqImages.sugar" alt="Gula" class="w-20 h-20 object-cover rounded-md">
                <div>
                    <h3 class="font-bold text-lg text-[#003266]">Mengapa penting mengontrol asupan gula dan kalori?</h3>
                    <p class="text-[#003266]">Mengontrol gula dan kalori membantu menjaga berat badan ideal, mencegah diabetes, dan meningkatkan energi sehari-hari.</p>
                </div>
            </div>

            <div class="bg-[#D2E7FF] p-6 rounded-lg shadow-md flex flex-row items-center space-x-4 w-full transform -translate-x-4">
                <div>
                    <h3 class="font-bold text-lg text-[#003266]">Berapa batas konsumsi gula harian yang disarankan?</h3>
                    <p class="text-[#003266]">WHO merekomendasikan maksimal 25 gram (6 sendok teh) per hari untuk orang dewasa agar tetap sehat.</p>
                </div>
                <img :src="faqImages.blood" alt="Batas Gula" class="w-20 h-20 object-cover rounded-md">
            </div>

            <div class="bg-[#D2E7FF] p-6 rounded-lg shadow-md flex flex-row items-center space-x-4 w-full transform translate-x-4">
                <img :src="faqImages.food" alt="Makanan Sehat" class="w-20 h-20 object-cover rounded-md">
                <div>
                    <h3 class="font-bold text-lg text-[#003266]">Apa saja makanan yang bisa membantu mengurangi konsumsi gula?</h3>
                    <p class="text-[#003266]">Sayuran hijau, biji-bijian utuh, kacang-kacangan, dan buah dengan indeks glikemik rendah seperti apel dan stroberi.</p>
                </div>
            </div>

            <div class="bg-[#D2E7FF] p-6 rounded-lg shadow-md flex flex-row items-center space-x-4 w-full transform -translate-x-4">
                <div>
                    <h3 class="font-bold text-lg text-[#003266]">Apakah semua jenis gula harus dihindari?</h3>
                    <p class="text-[#003266]">Tidak. Gula alami dari buah lebih baik dibandingkan gula tambahan yang sering ditemukan dalam makanan olahan.</p>
                </div>
                <img :src="faqImages.sugarTypes" alt="Gula Alami" class="w-20 h-20 object-cover rounded-md">
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="relative z-20 bg-white py-12 px-6" style="font-family: 'Inter', sans-serif;">
    <h2 class="text-3xl font-bold text-center mb-8 text-[#003266]">
        Testimoni Pengguna
    </h2>
    
    <div class="flex flex-col items-center">
        <div class="max-w-4xl mx-auto">
            <!-- Testimonial Carousel -->
            <div class="relative">
                <!-- Testimonial Cards -->
                <transition-group name="slide" mode="out-in">
                    <div v-if="currentTestimonial === 0" key="testimonial-1" class="bg-white rounded-lg shadow-lg p-6 mx-10 cursor-pointer" @click="nextTestimonial">
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div class="testimonial-container">
                                <img :src="testimonials[0].image" :alt="testimonials[0].name" class="testimonial-image">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                                <p class="text-gray-700 italic mb-4">{{ testimonials[0].text }}</p>
                                <div>
                                    <h4 class="font-bold text-lg text-[#003266]">{{ testimonials[0].name }}</h4>
                                    <p class="text-sm text-gray-500">{{ testimonials[0].role }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="currentTestimonial === 1" key="testimonial-2" class="bg-white rounded-lg shadow-lg p-6 mx-10 cursor-pointer" @click="nextTestimonial">
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div class="testimonial-container">
                                <img :src="testimonials[1].image" :alt="testimonials[1].name" class="testimonial-image">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                                <p class="text-gray-700 italic mb-4">{{ testimonials[1].text }}</p>
                                <div>
                                    <h4 class="font-bold text-lg text-[#003266]">{{ testimonials[1].name }}</h4>
                                    <p class="text-sm text-gray-500">{{ testimonials[1].role }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="currentTestimonial === 2" key="testimonial-3" class="bg-white rounded-lg shadow-lg p-6 mx-10 cursor-pointer" @click="nextTestimonial">
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div class="testimonial-container">
                                <img :src="testimonials[2].image" :alt="testimonials[2].name" class="testimonial-image">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                                <p class="text-gray-700 italic mb-4">{{ testimonials[2].text }}</p>
                                <div>
                                    <h4 class="font-bold text-lg text-[#003266]">{{ testimonials[2].name }}</h4>
                                    <p class="text-sm text-gray-500">{{ testimonials[2].role }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>

            <!-- Indicator Dots -->
            <div class="flex justify-center mt-6">
                <button 
                    v-for="(_, index) in testimonials" 
                    :key="index" 
                    @click="currentTestimonial = index"
                    class="w-3 h-3 rounded-full mx-1 focus:outline-none" 
                    :class="index === currentTestimonial ? 'bg-blue-500' : 'bg-gray-300'"
                ></button>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<!-- Font Awesome untuk ikon WhatsApp -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-TU8KVLNOKdH1xYEdzZr79M4LhvmuQIG0OHPuytuY0ZkTr5cfWdvV5pZbUsIq4Y0G6AMYv7xz+G+vE4M1jEILRQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Call to Action Section -->
<section class="relative z-20 bg-white py-12 px-6" style="font-family: 'Inter', sans-serif;">
    <h2 class="text-3xl font-bold text-center mb-8">
        Yuk, mulai hidup sehat sekarang! 
    </h2>
    <h2 class="text-3xl font-bold text-center mb-8">
        Kendalikan asupan gula dan kalori untuk 
    </h2>
    <h2 class="text-3xl font-bold text-center mb-8">
        tubuh yang lebih bertenaga dan seimbang!
    </h2>
    </section>
 


<!-- Footer Section -->
<footer class="bg-[#0B3C72] text-white py-10 px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Left Section
 -->
        <div>
            <div class="flex items-center space-x-3">
                <img :src="logo" alt="NutriTrack" class="h-30 w-auto">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-[#00D26A] to-[#007AFF] bg-clip-text text-transparent">
                    NutriTrack
                </h1>
            </div>
            <h3 class="font-bold text-lg">PT. Sehat Abadi</h3>
            <p class="text-sm mt-2 leading-relaxed">
                Kami hadir untuk membantu Anda mengontrol asupan gula dan kalori dengan lebih mudah dan menyenangkan. 
                Dengan panduan yang berbasis nutrisi seimbang, kami memberikan solusi sehat untuk menjaga energi, berat badan ideal, 
                dan mencegah risiko penyakit akibat konsumsi gula berlebih.
                <br><br>
                Misi kami adalah membangun kebiasaan makan yang lebih baik melalui edukasi, perencanaan makanan, dan komunitas yang mendukung gaya hidup sehat. 
                Mari bersama-sama menjaga kesehatan dengan pilihan makanan yang cerdas dan seimbang!
            </p>

            <!-- Subscribe Section -->
            <div class="mt-4">
                <h4 class="font-semibold">Subscribe Email</h4>
                <p class="text-sm">Get the best new products in your inbox, every day.</p>
                <button class="bg-blue-400 text-white px-4 py-2 mt-2 rounded w-full">Subscribe</button>
            </div>

            <!-- Social Media Icons -->
           <div class="flex space-x-4 mt-4">
                <a href="#" class="w-12 h-12 flex items-center justify-center rounded-full bg-white text-blue-500 text-2xl hover:bg-gray-200">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="w-12 h-12 flex items-center justify-center rounded-full bg-white text-blue-500 text-2xl hover:bg-gray-200">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="w-12 h-12 flex items-center justify-center rounded-full bg-white text-blue-500 text-2xl hover:bg-gray-200">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="#" class="w-12 h-12 flex items-center justify-center rounded-full bg-white text-blue-500 text-2xl hover:bg-gray-200">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="#" class="w-12 h-12 flex items-center justify-center rounded-full bg-white text-blue-500 text-2xl hover:bg-gray-200">
                    <i class="fab fa-x-twitter"></i>
                </a>
            </div>
        </div>

        <!-- Middle Section -->
        <div>
            <h4 class="font-semibold text-lg mb-3">Programs</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Beranda</a></li>
                <li><a href="#" class="hover:underline">Tentang Kami</a></li>
                <li><a href="#" class="hover:underline">Catat Asupan</a></li>
                <li><a href="#" class="hover:underline">Pilihan Sehat</a></li>
                <li><a href="#" class="hover:underline">Konsultasi Kesehatan</a></li>
                <li><a href="#" class="hover:underline">Profil & Target</a></li>
            </ul>
        </div>

        <!-- Right Section -->
        <div>
            <h4 class="font-semibold text-lg mb-3">Partner</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Grup & Forum Kesehatan</a></li>
                <li><a href="#" class="hover:underline">Kolaborasi Ahli Gizi</a></li>
            </ul>

            <h4 class="font-semibold text-lg mt-6 mb-3">Testimoni</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Cerita Inspiratif</a></li>
            </ul>
        </div>
    </div>

    <!-- Copyright -->
    <div class="mt-10 text-center text-sm border-t border-gray-500 pt-4">
        © Copyright 2025. PT Sehat Abadi. All Rights Reserved
    </div>
</footer>
</template>

<script>
export default {
    name: 'HomePage',
    data() {
        return {
            heroImage: '/images/home1.png',
            logo: '/images/logo.png',
            cardImages: {
                diabetes: '/images/cardtest.png',
                weight: '/images/card6.png',
                energy: '/images/card4.png'
            },
            faqImages: {
                sugar: '/images/Frame 90.jpg',
                blood: '/images/blood.jpg',
                food: '/images/food.jpg',
                sugarTypes: '/images/sugar.jpg'
            },
            testimonials: [
                {
                    image: '/images/testi3.png',
                    name: 'Intan Permata',
                    text: 'Bergabung dengan NutriTrack telah mengubah pola hidup saya. Sekarang, saya lebih sadar akan asupan gula dan kalori yang saya konsumsi setiap hari. Pengalaman ini tidak hanya membantu saya menjalani hidup lebih sehat, tetapi juga mengajarkan betapa pentingnya menjaga keseimbangan nutrisi untuk tubuh yang lebih bertenaga dan bebas dari risiko penyakit',
                    role: 'User'
                },
                {
                    image: '/images/testi1.jpeg',
                    name: 'Siti Aisyah',
                    text: 'Saya sangat terbantu dengan fitur-fitur yang disediakan oleh NutriTrack. Saya lebih mudah mengontrol asupan gula dan kalori, dan saya merasa lebih sehat dan energik',
                    role: 'User'
                },
                {
                    image: '/images/intan.jpg',
                    name: 'Siti Rahayu',
                    text: 'Sejak menggunakan NutriTrack, saya lebih memahami apa yang saya konsumsi setiap harinya. Aplikasi ini memberikan edukasi yang sangat bermanfaat dan mudah dipahami tentang manfaat nutrisi untuk kesehatan jangka panjang.',
                    role: 'User'
                }
            ],
            currentTestimonial: 0,
            scrollerImages: [
                '/images/card1.png',
                '/images/card2.png',
                '/images/card3.png',
                '/images/card1.png',
                '/images/card2.png',
                '/images/card3.png',
            ],
        };
    },
    mounted() {
        if (!window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
            const scroller = document.querySelector(".scroller");
            if (scroller) {
                scroller.setAttribute("data-animated", true);
                const scrollerInner = scroller.querySelector(".scroller__inner");
                if (scrollerInner) {
                    const items = Array.from(scrollerInner.children);
                    items.forEach((item) => {
                        const clone = item.cloneNode(true);
                        clone.setAttribute("aria-hidden", true);
                        scrollerInner.appendChild(clone);
                    });
                }
            }
        }

        // Mobile menu toggle
        const menuBtn = document.getElementById('menu-btn');
        if (menuBtn) {
            menuBtn.addEventListener('click', function () {
                const menu = document.getElementById('menu');
                if (menu) {
                    menu.classList.toggle('hidden');
                }
            });
        }
    },
    methods: {
        nextTestimonial() {
            this.currentTestimonial = (this.currentTestimonial + 1) % this.testimonials.length;
        }
    }
}
</script>

<style>
body {
    font-family: 'Poppins', sans-serif;
}

/* Scroller */
.scroller__inner {
    display: flex;
    gap: 1rem;
    flex-wrap: nowrap;
    width: max-content;
    animation: scroll 40s linear infinite;
}

.scroller:hover .scroller__inner {
    animation-play-state: paused;
}

@keyframes scroll {
    to {
        transform: translateX(calc(-50% - 0.5rem));
    }
}

/* Mobile Menu */
#menu {
    transition: max-height 0.3s ease-in-out;
}

/* Testimonial Transitions */
.slide-enter-active,
.slide-leave-active {
    transition: all 0.5s ease;
}

.slide-enter-from {
    opacity: 0;
    transform: translateX(50px);
}

.slide-leave-to {
    opacity: 0;
    transform: translateX(-50px);
}

/* Testimonial Images */
.testimonial-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    max-height: 100%;
    max-width: 100%;
}

.testimonial-container {
    width: 32px;
    height: 32px;
    min-width: 80px;
    min-height: 80px;
    max-width: 80px;
    max-height: 80px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    border: 2px solid #90caf9;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.scroller {
    width: 100vw;
    overflow: hidden;
    position: relative;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
}

.scroller__inner {
    display: flex;
    gap: 1.5rem;
    flex-wrap: nowrap;
    width: max-content;
    animation: scroll-right 18s linear infinite;
}

@keyframes scroll-right {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}
#program,
#faq,
#testimonials {
  scroll-margin-top: 5rem;
}
</style> 