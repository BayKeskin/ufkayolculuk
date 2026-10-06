/**
 * Ufka Yolculuk - Ana JavaScript Dosyası (main.js)
 * -------------------------------------------------------------
 * Saf Vanilla JavaScript (Zero Dependencies, Zero jQuery)
 * Odak: Hero Carousel, Kategori Slider, Canlı Geri Sayım, Etkileşimler & PageSpeed
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    initHeroCarousel();
    initCategoriesCarousel();
    initDatesAndCountdown();
    initFloatingBot();
    initLanguageSelector();
    initNavActiveIndicator();
    initLoginModal();
    initNewsFilter();
    initCityRepresentatives();
    initContactForm();
    initAwardsPage();
    initQuizSimulator();
    initGamesModal();
    initMediaModal();
  });

  /**
   * ==========================================================
   * 1. HERO CAROUSEL / SLIDER (Saf Vanilla JS)
   * ==========================================================
   */
  function initHeroCarousel() {
    const slides = document.querySelectorAll('.hero-slide');
    const prevBtn = document.getElementById('heroPrevBtn');
    const nextBtn = document.getElementById('heroNextBtn');
    const pauseBtn = document.getElementById('heroPauseBtn');
    const numItems = document.querySelectorAll('#heroIndicator .num-item');
    const indicatorTrack = document.querySelector('#heroIndicator .indicator-track');
    const indicatorFill = document.getElementById('indicatorFill');
    const heroContainer = document.querySelector('.hero-slider-container');

    if (!slides.length) return;

    let currentIndex = 0;
    let isPlaying = true;
    let autoPlayTimer = null;
    let progressTimer = null;
    const slideDuration = 5000; // ms
    let progressStartTime = 0;

    /**
     * Slayta Geçiş Fonksiyonu (Çift Yönlü İleri/Geri Sorunsuz)
     */
    function goToSlide(newIndex, direction = 'next') {
      if (newIndex === currentIndex || newIndex < 0 || newIndex >= slides.length) return;

      const currentSlide = slides[currentIndex];
      const nextSlide = slides[newIndex];

      // Tüm slaytlardan sınıfları temizle
      slides.forEach((s) => {
        s.classList.remove('active', 'slide-left-out', 'slide-right-out');
      });

      // Mevcut slayttan çıkış animasyonu
      if (direction === 'next') {
        currentSlide.classList.add('slide-left-out');
      } else {
        currentSlide.classList.add('slide-right-out');
      }

      // Yeni slaytı aktif yap
      nextSlide.classList.add('active');

      setTimeout(() => {
        slides.forEach((s) => {
          if (s !== nextSlide) {
            s.classList.remove('slide-left-out', 'slide-right-out');
          }
        });
      }, 400);

      // Gösterge Numaralarını Güncelle
      numItems.forEach((num, idx) => {
        num.classList.toggle('active', idx === newIndex);
      });

      // Progress bar'ı aktif olan numaranın hemen sağına taşı
      const activeNumEl = numItems[newIndex];
      if (activeNumEl && indicatorTrack) {
        activeNumEl.after(indicatorTrack);
      }

      currentIndex = newIndex;
      resetProgressBar();
    }

    function nextSlide() {
      const target = (currentIndex + 1) % slides.length;
      goToSlide(target, 'next');
    }

    function prevSlide() {
      const target = (currentIndex - 1 + slides.length) % slides.length;
      goToSlide(target, 'prev');
    }

    /**
     * İlerleme Çubuğu Animasyonu
     */
    function resetProgressBar() {
      if (!indicatorFill) return;
      indicatorFill.style.transition = 'none';
      indicatorFill.style.width = '0%';

      if (isPlaying) {
        setTimeout(() => {
          indicatorFill.style.transition = `width ${slideDuration}ms linear`;
          indicatorFill.style.width = '100%';
        }, 30);
      }
    }

    /**
     * Otomatik Oynatma Yönetimi
     */
    function startAutoPlay() {
      stopAutoPlay();
      resetProgressBar();
      autoPlayTimer = setInterval(() => {
        nextSlide();
      }, slideDuration);
    }

    function stopAutoPlay() {
      if (autoPlayTimer) {
        clearInterval(autoPlayTimer);
        autoPlayTimer = null;
      }
      if (indicatorFill) {
        indicatorFill.style.transition = 'none';
      }
    }

    // Buton Dinleyicileri
    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        nextSlide();
        if (isPlaying) startAutoPlay();
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        prevSlide();
        if (isPlaying) startAutoPlay();
      });
    }

    // Numaralara Doğrudan Tıklama (3 -> 2 ve tüm yönlerde sorunsuz geçiş)
    numItems.forEach((numEl) => {
      numEl.addEventListener('click', function () {
        const targetIdx = parseInt(this.getAttribute('data-slide'), 10);
        if (!isNaN(targetIdx) && targetIdx !== currentIndex) {
          const dir = targetIdx > currentIndex ? 'next' : 'prev';
          goToSlide(targetIdx, dir);
          if (isPlaying) startAutoPlay();
        }
      });
    });

    // Durdur / Başlat Butonu
    if (pauseBtn) {
      pauseBtn.addEventListener('click', () => {
        isPlaying = !isPlaying;
        pauseBtn.textContent = isPlaying ? '||' : '▶';
        pauseBtn.setAttribute('title', isPlaying ? 'Durdur' : 'Oynat');
        if (isPlaying) {
          startAutoPlay();
        } else {
          stopAutoPlay();
          if (indicatorFill) indicatorFill.style.width = '0%';
        }
      });
    }

    // Fare Üzerine Geldiğinde Duraklatma
    if (heroContainer) {
      heroContainer.addEventListener('mouseenter', () => {
        if (isPlaying) stopAutoPlay();
      });

      heroContainer.addEventListener('mouseleave', () => {
        if (isPlaying) startAutoPlay();
      });
    }

    // Mobil Dokunmatik (Touch Swipe) Desteği
    let touchStartX = 0;
    let touchEndX = 0;

    if (heroContainer) {
      heroContainer.addEventListener(
        'touchstart',
        (e) => {
          touchStartX = e.changedTouches[0].screenX;
        },
        { passive: true }
      );

      heroContainer.addEventListener(
        'touchend',
        (e) => {
          touchEndX = e.changedTouches[0].screenX;
          handleSwipe();
        },
        { passive: true }
      );
    }

    function handleSwipe() {
      const swipeThreshold = 40;
      if (touchEndX < touchStartX - swipeThreshold) {
        nextSlide();
        if (isPlaying) startAutoPlay();
      } else if (touchEndX > touchStartX + swipeThreshold) {
        prevSlide();
        if (isPlaying) startAutoPlay();
      }
    }

    // İlk Başlatma
    startAutoPlay();
  }

  /**
   * ==========================================================
   * 2. KATEGORİLER VE KİTAPLAR CAROUSEL & FİLTRELEME (Saf Vanilla JS)
   * ==========================================================
   */
  function initCategoriesCarousel() {
    const track = document.getElementById('categoriesTrack');
    const prevBtn = document.getElementById('catPrevBtn');
    const nextBtn = document.getElementById('catNextBtn');
    const filterPills = document.querySelectorAll('#bookFilterTabs .filter-pill');
    const categoryCards = document.querySelectorAll('.category-card-col');

    if (!track) return;

    const getScrollAmount = () => {
      const firstCard = track.querySelector('.category-card-col');
      if (firstCard) {
        return firstCard.offsetWidth + 24; // kart genişliği + gap
      }
      return 300;
    };

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        track.scrollBy({
          left: getScrollAmount(),
          behavior: 'smooth'
        });
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        track.scrollBy({
          left: -getScrollAmount(),
          behavior: 'smooth'
        });
      });
    }

    // Kategori Filtre Butonları (Pill Filtering & Smooth Scroll)
    if (filterPills.length) {
      filterPills.forEach((pill) => {
        pill.addEventListener('click', function () {
          filterPills.forEach((p) => p.classList.remove('active'));
          this.classList.add('active');

          const filterVal = this.getAttribute('data-filter');

          categoryCards.forEach((card) => {
            const cardCat = card.getAttribute('data-cat');
            if (filterVal === 'all' || cardCat === filterVal) {
              card.style.display = '';
              card.style.opacity = '1';
            } else {
              card.style.display = 'none';
            }
          });

          // Kart seçildiğinde başa yumuşak kaydır
          track.scrollTo({ left: 0, behavior: 'smooth' });
        });
      });
    }

    // Fareyle Sürükle-Bırak (Drag to Scroll)
    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;

    track.addEventListener('mousedown', (e) => {
      isDown = true;
      track.classList.add('active-drag');
      startX = e.pageX - track.offsetLeft;
      scrollLeft = track.scrollLeft;
    });

    track.addEventListener('mouseleave', () => {
      isDown = false;
      track.classList.remove('active-drag');
    });

    track.addEventListener('mouseup', () => {
      isDown = false;
      track.classList.remove('active-drag');
    });

    track.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - track.offsetLeft;
      const walk = (x - startX) * 1.5;
      track.scrollLeft = scrollLeft - walk;
    });

    // Kitap Detayları & Harici Subdomain Yönlendirme Modalı Veri Doldurma
    const bookData = {
      ilkokul: {
        cover: 'assets/images/book-ilkokul-3d.webp',
        title: 'Dünyanın Her Köşesinden Maceralar',
        cat: '🌱 İlkokul Kategorisi',
        grade: '1 - 4. Sınıf',
        sub: 'Eğlenceli Bilgiler, Erdemler ve Hikayeler',
        publisher: 'Ufka Yolculuk Çocuk Yayınları',
        pages: '144 Sayfa',
        questions: '40 Soru (Çoktan Seçmeli)',
        age: '6 - 10 Yaş (İlkokul Kademesi)',
        summary: 'Bu eser, çocukların ahlaki ve insani değerleri eğlenceli kurgular eşliğinde keşfetmelerini sağlar. Dürüstlük, yardımlaşma, sabır, doğa sevgisi ve kardeşlik gibi temel erdemler pedagog onaylı resimli hikayelerle aktarılmaktadır.',
        readUrl: 'https://kutuphane.ufkayolculuk.com/kitap/ilkokul',
        listenUrl: 'https://sesli.ufkayolculuk.com/dinle/ilkokul',
        audio: 'Bölüm 1: Doğanın Renkleri ve Mavi Kuşun Yolculuğu'
      },
      ortaokul: {
        cover: 'assets/images/book-ortaokul-3d.webp',
        title: 'Bilgi Dolu Bir Yolculuk',
        cat: '🧭 Ortaokul Kategorisi',
        grade: '5 - 8. Sınıf',
        sub: 'Macera, Keşif ve Bilim Yarışmaları',
        publisher: 'Ufka Yolculuk Gençlik Yayınları',
        pages: '192 Sayfa',
        questions: '50 Soru (Çoktan Seçmeli)',
        age: '10 - 14 Yaş (Ortaokul Kademesi)',
        summary: 'Asırlar boyunca kaşiflerin ve bilim insanlarının merakıyla şekillenen bu sürükleyici anlatı; gençlere bilimsel düşünme, araştırma tutkusu ve erdemli bir karakter inşası kazandırmayı amaçlamaktadır.',
        readUrl: 'https://kutuphane.ufkayolculuk.com/kitap/ortaokul',
        listenUrl: 'https://sesli.ufkayolculuk.com/dinle/ortaokul',
        audio: 'Bölüm 1: Yıldızların Pusulası ve Bilimsel Merak'
      },
      lise: {
        cover: 'assets/images/book-lise-3d.webp',
        title: 'Felsefe, Teknoloji ve Kozmos',
        cat: '🎓 Lise Kategorisi',
        grade: '9 - 12. Sınıf',
        sub: 'Eleştirel Düşünce ve İrade Rehberi',
        publisher: 'Ufka Yolculuk Akademi Yayınları',
        pages: '240 Sayfa',
        questions: '50 Soru (Çoktan Seçmeli)',
        age: '14 - 18 Yaş (Lise Kademesi)',
        summary: 'Yapay zeka, kuantum evreni ve dijital çağın eşiğindeki gençler için hazırlanmış bu rehber; felsefi sorgulama, zihinsel bağımsızlık ve ahlaki sorumluluk bilincini derinlemesine ele alır.',
        readUrl: 'https://kutuphane.ufkayolculuk.com/kitap/lise',
        listenUrl: 'https://sesli.ufkayolculuk.com/dinle/lise',
        audio: 'Bölüm 1: Zihin, İrade ve Teknolojik Çağda İnsan'
      },
      yetiskin: {
        cover: 'assets/images/book-yetiskin-3d.webp',
        title: 'Akıl, İrfan ve Ahlak Rehberi',
        cat: '🏛️ Yetişkin Kategorisi',
        grade: '18+ Yaş / Üniversite',
        sub: 'Literatür, Bilgelik ve Medeniyet Tasavvuru',
        publisher: 'Ufka Yolculuk Prestij Eserler',
        pages: '320 Sayfa',
        questions: '50 Soru (Çoktan Seçmeli)',
        age: '18+ Yaş & Tüm Yetişkinler',
        summary: 'Medeniyetlerin yükselişinde aklın ve irfanın rolünü inceleyen bu prestij eser; kadim hikmet geleneklerinden modern düşünce dünyasına kadar kapsamlı bir tefekkür ve ahlak manifestosudur.',
        readUrl: 'https://kutuphane.ufkayolculuk.com/kitap/yetiskin',
        listenUrl: 'https://sesli.ufkayolculuk.com/dinle/yetiskin',
        audio: 'Bölüm 1: Medeniyet Tasavvuru ve Kadim Hikmet'
      }
    };

    const bookModalEl = document.getElementById('bookPreviewModal');
    if (bookModalEl) {
      bookModalEl.addEventListener('show.bs.modal', function (event) {
        const triggerBtn = event.relatedTarget;
        if (!triggerBtn) return;

        const bookKey = triggerBtn.getAttribute('data-book');
        const data = bookData[bookKey] || bookData.ilkokul;

        const modalCover = document.getElementById('modalBookCoverImg');
        const modalTitle = document.getElementById('bookPreviewModalLabel');
        const modalCatBadge = document.getElementById('previewModalCatBadge');
        const modalGradeBadge = document.getElementById('previewModalGradeBadge');
        const modalSub = document.getElementById('previewModalSubtitle');
        const modalPublisher = document.getElementById('modalBookPublisher');
        const modalPages = document.getElementById('modalBookPages');
        const modalQuestions = document.getElementById('modalBookQuestions');
        const modalAge = document.getElementById('modalBookAge');
        const modalSummary = document.getElementById('modalBookFullSummary');
        const btnRead = document.getElementById('btnSubdomainRead');
        const btnListen = document.getElementById('btnSubdomainListen');
        const trackTitle = document.getElementById('audioTrackTitle');

        if (modalCover) modalCover.src = data.cover;
        if (modalTitle) modalTitle.textContent = data.title;
        if (modalCatBadge) modalCatBadge.textContent = data.cat;
        if (modalGradeBadge) modalGradeBadge.textContent = data.grade;
        if (modalSub) modalSub.textContent = data.sub;
        if (modalPublisher) modalPublisher.textContent = data.publisher;
        if (modalPages) modalPages.textContent = data.pages;
        if (modalQuestions) modalQuestions.textContent = data.questions;
        if (modalAge) modalAge.textContent = data.age;
        if (modalSummary) modalSummary.textContent = data.summary;
        if (btnRead) btnRead.href = data.readUrl;
        if (btnListen) btnListen.href = data.listenUrl;
        if (trackTitle) trackTitle.textContent = data.audio;
      });
    }

    // Ses Oynat/Durdur Buton Simülasyonu
    const audioBtn = document.getElementById('audioTogglePlayBtn');
    if (audioBtn) {
      audioBtn.addEventListener('click', function () {
        const isPlaying = this.textContent.trim() === '❚❚';
        this.textContent = isPlaying ? '▶' : '❚❚';
      });
    }
  }

  /**
   * ==========================================================
   * 3. ÖNEMLİ TARİHLER SLIDER & DİNAMİK CANLI GERİ SAYIM SAYACI
   * ==========================================================
   */
  function initDatesAndCountdown() {
    const dates = [
      {
        title: 'Kayıt Bitiş Tarihi',
        date: '18 Eylül 2026',
        targetIso: '2026-09-18T23:59:59',
        countdownLabel: 'Kayıt Bitişine Kalan Süre'
      },
      {
        title: '1. Aşama Online Sınav',
        date: '04 Ekim 2026',
        targetIso: '2026-10-04T10:00:00',
        countdownLabel: '1. Aşama Sınava Kalan Süre'
      },
      {
        title: '2. Aşama Final Sınavı',
        date: '25 Ekim 2026',
        targetIso: '2026-10-25T10:00:00',
        countdownLabel: '2. Aşama Sınava Kalan Süre'
      },
      {
        title: 'Sonuçların İlanı',
        date: '15 Kasım 2026',
        targetIso: '2026-11-15T20:00:00',
        countdownLabel: 'Sonuç İlanına Kalan Süre'
      },
      {
        title: 'Büyük Ödül Töreni',
        date: '05 Aralık 2026',
        targetIso: '2026-12-05T14:00:00',
        countdownLabel: 'Ödül Törenine Kalan Süre'
      }
    ];

    let currentIndex = 0;
    let targetTimestamp = new Date(dates[0].targetIso).getTime();

    // DOM Elementleri
    const track = document.getElementById('dateCarouselTrack');
    const viewport = document.querySelector('.date-carousel-viewport');
    const countdownTitleEl = document.getElementById('countdownTitle');
    const countdownGridEl = document.querySelector('.countdown-timer-grid');
    const prevBtn = document.getElementById('prevDateBtn');
    const nextBtn = document.getElementById('nextDateBtn');
    const dots = document.querySelectorAll('#dateDotsContainer .dot');

    const daysEl = document.getElementById('timerDays');
    const hoursEl = document.getElementById('timerHours');
    const minsEl = document.getElementById('timerMinutes');
    const secsEl = document.getElementById('timerSeconds');

    if (!track && !daysEl) return;

    /**
     * Geri Sayım Hesaplayıcı (Aktif Tarihe Göre)
     */
    function updateCountdownNumbers() {
      if (!daysEl || !hoursEl || !minsEl || !secsEl) return;

      const now = new Date().getTime();
      const difference = targetTimestamp - now;

      if (difference <= 0) {
        daysEl.textContent = '00';
        hoursEl.textContent = '00';
        minsEl.textContent = '00';
        secsEl.textContent = '00';
        return;
      }

      const days = Math.floor(difference / (1000 * 60 * 60 * 24));
      const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((difference % (1000 * 60)) / 1000);

      daysEl.textContent = String(days).padStart(2, '0');
      hoursEl.textContent = String(hours).padStart(2, '0');
      minsEl.textContent = String(minutes).padStart(2, '0');
      secsEl.textContent = String(seconds).padStart(2, '0');
    }

    /**
     * Belirtilen Slayta Yumuşak Kaydır ve Geri Sayımı Güncelle
     */
    function goToSlide(index) {
      if (index < 0) index = dates.length - 1;
      if (index >= dates.length) index = 0;
      currentIndex = index;

      // 1. Carousel Kaydırma Hareketi
      if (track) {
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
      }

      // 2. Sayfalama Noktaları Aktifliği
      dots.forEach((dot, idx) => {
        dot.classList.toggle('active', idx === currentIndex);
      });

      // 3. Sağdaki Geri Sayım Başlığı ve Hedef Tarih Senkronizasyonu
      const item = dates[currentIndex];
      if (countdownTitleEl) {
        countdownTitleEl.textContent = item.countdownLabel;
      }

      targetTimestamp = new Date(item.targetIso).getTime();

      // Geri sayım kutularına görsel geçiş/pulsasyon efekti
      if (countdownGridEl) {
        countdownGridEl.classList.remove('timer-syncing');
        void countdownGridEl.offsetWidth; // Reflow tetikle
        countdownGridEl.classList.add('timer-syncing');
      }

      // Hemen güncel sayıları yaz
      updateCountdownNumbers();
    }

    // Buton Dinleyicileri
    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        goToSlide(currentIndex - 1);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        goToSlide(currentIndex + 1);
      });
    }

    // Noktalara Doğrudan Tıklama
    dots.forEach((dot, idx) => {
      dot.addEventListener('click', () => {
        goToSlide(idx);
      });
    });

    // Dokunmatik (Touch) ve Mouse Sürükleme ile Kaydırma Desteği
    if (viewport) {
      let touchStartX = 0;
      let isMouseDown = false;
      let mouseStartX = 0;

      viewport.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
      }, { passive: true });

      viewport.addEventListener('touchend', (e) => {
        const touchEndX = e.changedTouches[0].clientX;
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) > 40) {
          if (diff > 0) {
            goToSlide(currentIndex + 1);
          } else {
            goToSlide(currentIndex - 1);
          }
        }
      });

      viewport.addEventListener('mousedown', (e) => {
        isMouseDown = true;
        mouseStartX = e.clientX;
      });

      window.addEventListener('mouseup', (e) => {
        if (!isMouseDown) return;
        isMouseDown = false;
        const mouseEndX = e.clientX;
        const diff = mouseStartX - mouseEndX;
        if (Math.abs(diff) > 50) {
          if (diff > 0) {
            goToSlide(currentIndex + 1);
          } else {
            goToSlide(currentIndex - 1);
          }
        }
      });
    }

    // İlk açılışta 1. slaytı ve sayacı başlat
    goToSlide(0);

    // Her saniye canlı geri sayımı güncelle
    setInterval(updateCountdownNumbers, 1000);
  }

  /**
   * ==========================================================
   * 5. UFYO AI CHATBOT VE SORU-CEVAP SİSTEMİ
   * ==========================================================
   */
  function initFloatingBot() {
    const botTrigger = document.getElementById('ufyoChatTrigger');
    const chatPanel = document.getElementById('ufyoChatPanel');
    const minimizeBtn = document.getElementById('ufyoMinimizeBtn');
    const chatForm = document.getElementById('ufyoChatForm');
    const chatInput = document.getElementById('ufyoInput');
    const chatBody = document.getElementById('ufyoChatBody');
    const quickChips = document.querySelectorAll('.ufyo-chip-btn');

    if (!botTrigger || !chatPanel) return;

    // Toggle Chat Paneli
    function toggleChat(open = null) {
      const shouldOpen = open !== null ? open : !chatPanel.classList.contains('active');
      if (shouldOpen) {
        chatPanel.classList.add('active');
        chatPanel.setAttribute('aria-hidden', 'false');
        if (chatInput) chatInput.focus();
      } else {
        chatPanel.classList.remove('active');
        chatPanel.setAttribute('aria-hidden', 'true');
      }
    }

    botTrigger.addEventListener('click', () => toggleChat(true));
    if (minimizeBtn) {
      minimizeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleChat(false);
      });
    }

    // Scroll to Bottom
    function scrollToBottom() {
      if (chatBody) {
        chatBody.scrollTo({
          top: chatBody.scrollHeight,
          behavior: 'smooth'
        });
      }
    }

    // Mesaj Ekleme
    function appendMessage(text, isUser = false) {
      if (!chatBody) return;
      const msgDiv = document.createElement('div');
      msgDiv.className = `chat-msg ${isUser ? 'user-msg' : 'bot-msg'}`;

      if (isUser) {
        msgDiv.innerHTML = `
          <div class="chat-msg-content">
            <p class="mb-0">${escapeHtml(text)}</p>
          </div>
        `;
      } else {
        msgDiv.innerHTML = `
          <div class="chat-msg-avatar">
            <img src="assets/images/icon6.png" alt="Ufyo">
          </div>
          <div class="chat-msg-content">
            ${text}
          </div>
        `;
      }

      chatBody.appendChild(msgDiv);
      scrollToBottom();
    }

    // Typing Göstergesi
    function showTypingIndicator() {
      const typingDiv = document.createElement('div');
      typingDiv.className = 'chat-msg bot-msg typing-msg';
      typingDiv.id = 'ufyoTyping';
      typingDiv.innerHTML = `
        <div class="chat-msg-avatar">
          <img src="assets/images/icon6.png" alt="Ufyo">
        </div>
        <div class="typing-indicator">
          <span class="typing-dot"></span>
          <span class="typing-dot"></span>
          <span class="typing-dot"></span>
        </div>
      `;
      chatBody.appendChild(typingDiv);
      scrollToBottom();
    }

    function removeTypingIndicator() {
      const el = document.getElementById('ufyoTyping');
      if (el) el.remove();
    }

    // Yapay Zeka Cevap Üretici (Keyword Matching & Semantic Context)
    function generateBotAnswer(userMsg) {
      const q = userMsg.toLowerCase();

      if (q.includes('sınav') || q.includes('tarih') || q.includes('zaman') || q.includes('takvim')) {
        return `<p class="mb-1">📅 <strong>12. Ufka Yolculuk Yarışma Takvimi:</strong></p>
                <p class="mb-1">• <strong>Kayıt Dönemi:</strong> 15 Ekim 2025 - 15 Mart 2026</p>
                <p class="mb-1">• <strong>1. Aşama Online Sınav:</strong> 18-19 Nisan 2026</p>
                <p class="mb-0">• <strong>2. Aşama Türkiye Finali:</strong> 17 Mayıs 2026</p>`;
      }

      if (q.includes('kitap') || q.includes('temin') || q.includes('oku') || q.includes('nereden')) {
        return `<p class="mb-1">📚 <strong>Yarışma Kitapları Temini:</strong></p>
                <p class="mb-1">Kategorinize ait yarışma kitabını web sitemizden online sipariş edebilir, seçkin kitapçılardan veya il/ilçe temsilciliklerimizden temin edebilirsiniz.</p>
                <p class="mb-0">Ayrıca sayfamızdaki kitap bölümünden örnek bölümleri <strong>dinleyebilir</strong> veya <strong>okuyabilirsiniz</strong>.</p>`;
      }

      if (q.includes('ödül') || q.includes('odul') || q.includes('hediye') || q.includes('kazan')) {
        return `<p class="mb-1">🏆 <strong>12. Dönem Muhteşem Ödülleri:</strong></p>
                <p class="mb-1">• <strong>Türkiye Dereceleri:</strong> Umre seyahatleri, tabletler, laptoplar ve para ödülleri.</p>
                <p class="mb-1">• <strong>İl & İlçe Ödülleri:</strong> Her ilde ilk 10'a giren yarışmacılara özel ödüller.</p>
                <p class="mb-0">• <strong>Takım Lideri Ödülleri:</strong> Danışman öğretmenlerimize özel başarı ödülleri.</p>`;
      }

      if (q.includes('oyun') || q.includes('soru') || q.includes('deneme') || q.includes('market') || q.includes('mağaza') || q.includes('subdomain') || q.includes('test')) {
        return `<p class="mb-1">🎯 <strong>Özel Platformlarımız:</strong></p>
                <p class="mb-1">🎮 <strong>Oyun Dünyası:</strong> <a href="https://oyun.ufkayolculuk.com" target="_blank" class="fw-bold text-primary">oyun.ufkayolculuk.com</a> adresinden mini oyunlara katılabilirsiniz.</p>
                <p class="mb-1">📝 <strong>Online Soru Çözüm:</strong> <a href="https://soru.ufkayolculuk.com" target="_blank" class="fw-bold text-primary">soru.ufkayolculuk.com</a> üzerinden deneme sınavları çözebilirsiniz.</p>
                <p class="mb-0">🛍️ <strong>Ufyo Market:</strong> <a href="https://market.ufkayolculuk.com" target="_blank" class="fw-bold text-primary">market.ufkayolculuk.com</a> üzerinden kitap ve ödül ürünlerine ulaşabilirsiniz.</p>`;
      }

      if (q.includes('kayıt') || q.includes('başvuru') || q.includes('nasıl katılırım')) {
        return `<p class="mb-1">✍️ <strong>Yarışmaya Katılım Adımları:</strong></p>
                <p class="mb-1">1. Sağ üstteki <strong>Giriş / Kayıt</strong> butonundan telefon ve doğum tarihinizle kayıt olun.</p>
                <p class="mb-1">2. Yaş grubunuza uygun kitabı edinin.</p>
                <p class="mb-0">3. Online soru havuzumuzla pratik yaparak sınav gününe hazırlanın!</p>`;
      }

      if (q.includes('takım') || q.includes('öğretmen') || q.includes('okul') || q.includes('lider')) {
        return `<p class="mb-1">👥 <strong>Takım Lideri Portalı:</strong></p>
                <p class="mb-0">Öğretmenlerimiz ve danışmanlarımız Takım Lideri Portalı üzerinden sınıflarını ve okuma gruplarını oluşturarak öğrencilerinin ilerlemelerini anlık takip edebilirler.</p>`;
      }

      // Genel Cevap
      return `<p class="mb-1">Sorunuz için teşekkür ederim! ✨</p>
              <p class="mb-0">Ufka Yolculuk ile ilgili merak ettiğiniz tüm detaylara ana sayfamızdaki menülerden, <strong>Rehber</strong> ve <strong>Sıkça Sorulan Sorular</strong> sayfalarımızdan veya çağrı merkezimizden dilediğiniz zaman ulaşabilirsiniz.</p>`;
    }

    function escapeHtml(text) {
      const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
      return text.replace(/[&<>"']/g, (m) => map[m]);
    }

    // Soru Gönderme İşlemi
    function handleUserQuestion(questionText) {
      const q = questionText.trim();
      if (!q) return;

      appendMessage(q, true);
      if (chatInput) chatInput.value = '';

      showTypingIndicator();

      setTimeout(() => {
        removeTypingIndicator();
        const answer = generateBotAnswer(q);
        appendMessage(answer, false);
      }, 600);
    }

    // Form Gönderimi
    if (chatForm) {
      chatForm.addEventListener('submit', (e) => {
        e.preventDefault();
        if (chatInput) {
          handleUserQuestion(chatInput.value);
        }
      });
    }

    // Hızlı Soru Çipleri Tıklaması
    quickChips.forEach((chip) => {
      chip.addEventListener('click', function () {
        const question = this.getAttribute('data-question') || this.textContent.trim();
        handleUserQuestion(question);
      });
    });
  }

  /**
   * ==========================================================
   * 6. DİL SEÇİCİ (SVG Bayraklı Etkileşim)
   * ==========================================================
   */
  function initLanguageSelector() {
    const langBtn = document.getElementById('langDropdownBtn');
    const langItems = document.querySelectorAll('.dropdown-menu [data-lang]');
    if (!langBtn || !langItems.length) return;

    langItems.forEach((item) => {
      item.addEventListener('click', function (e) {
        e.preventDefault();
        const imgEl = this.querySelector('img');
        const textEl = this.querySelector('span');

        if (imgEl && textEl && langBtn) {
          langBtn.innerHTML = `
            <img src="${imgEl.getAttribute('src')}" alt="${textEl.textContent.trim()}" width="20" height="14" class="rounded-1 shadow-xs">
            <span>${textEl.textContent.trim()}</span>
          `;

          langItems.forEach((i) => i.classList.remove('active'));
          this.classList.add('active');
        }
      });
    });
  }

  /**
   * ==========================================================
   * 7. NAVBAR AKTİF MENÜ SEÇİMİ
   * ==========================================================
   */
  function initNavActiveIndicator() {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navLinks.forEach((link) => {
      link.addEventListener('click', function () {
        navLinks.forEach((l) => l.classList.remove('active'));
        this.classList.add('active');
      });
    });
  }

  /**
   * ==========================================================
   * 8. GİRİŞ YAP MODAL & TELEFON MASKELEME ETKİLEŞİMİ
   * ==========================================================
   */
  function initLoginModal() {
    const phoneInput = document.getElementById('loginPhone');
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('btnLoginSubmit');

    // Telefon Numarası Otomatik Formatlama (0 (5XX) XXX XX XX)
    if (phoneInput) {
      phoneInput.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, ''); // Sadece rakamları al
        
        if (value.startsWith('90')) {
          value = value.substring(2);
        }
        if (!value.startsWith('0') && value.length > 0) {
          value = '0' + value;
        }

        let formatted = '';
        if (value.length > 0) {
          formatted = value.substring(0, 1); // 0
        }
        if (value.length > 1) {
          formatted += ' (' + value.substring(1, 4); // 0 (5XX
        }
        if (value.length >= 4) {
          formatted += ') ' + value.substring(4, 7); // 0 (5XX) XXX
        }
        if (value.length >= 7) {
          formatted += ' ' + value.substring(7, 9); // 0 (5XX) XXX XX
        }
        if (value.length >= 9) {
          formatted += ' ' + value.substring(9, 11); // 0 (5XX) XXX XX XX
        }

        this.value = formatted;
      });
    }

    // Form Gönderim İşlemi & Doğrulama
    if (loginForm && submitBtn) {
      loginForm.addEventListener('submit', function (e) {
        e.preventDefault();
        
        const phoneVal = phoneInput ? phoneInput.value.trim() : '';
        const birthVal = document.getElementById('loginBirthDate') ? document.getElementById('loginBirthDate').value : '';

        if (!phoneVal || phoneVal.length < 17) {
          alert('Lütfen geçerli bir cep telefonu numarası giriniz: 0 (5XX) XXX XX XX');
          if (phoneInput) phoneInput.focus();
          return;
        }

        if (!birthVal) {
          alert('Lütfen doğum tarihinizi seçiniz.');
          return;
        }

        // Başarılı Simülasyon
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Kontrol ediliyor...</span>';

        setTimeout(() => {
          submitBtn.innerHTML = '<span>Giriş Başarılı ✓</span>';
          submitBtn.classList.remove('btn-yellow');
          submitBtn.classList.add('btn-success');

          setTimeout(() => {
            alert('Giriş başarılı! Yarışmacı paneline yönlendiriliyorsunuz...');
            const modalEl = document.getElementById('loginModal');
            if (modalEl && window.bootstrap) {
              const modalInstance = bootstrap.Modal.getInstance(modalEl);
              if (modalInstance) modalInstance.hide();
            }
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            submitBtn.classList.remove('btn-success');
            submitBtn.classList.add('btn-yellow');
            loginForm.reset();
          }, 600);
        }, 700);
      });
    }
  }

  /**
   * ==========================================================
   * 9. DUYURU & HABER LİSTELEME FİLTRE VE ARAMA ETKİLEŞİMİ
   * ==========================================================
   */
  function initNewsFilter() {
    const filterBtns = document.querySelectorAll('#filterPills .filter-tab-btn');
    const searchInput = document.getElementById('newsSearchInput');
    const newsCards = document.querySelectorAll('#newsGridContainer .news-card');

    if (!newsCards.length) return;

    let activeFilter = 'all';
    let searchQuery = '';

    function applyFilter() {
      newsCards.forEach((card) => {
        const category = card.getAttribute('data-category') || '';
        const titleText = card.querySelector('.news-title') ? card.querySelector('.news-title').textContent.toLowerCase() : '';
        const excerptText = card.querySelector('.news-excerpt') ? card.querySelector('.news-excerpt').textContent.toLowerCase() : '';

        const matchesCategory = activeFilter === 'all' || category === activeFilter;
        const matchesSearch = !searchQuery || titleText.includes(searchQuery) || excerptText.includes(searchQuery);

        if (matchesCategory && matchesSearch) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    }

    // Kategori Butonları Dinleyicisi
    filterBtns.forEach((btn) => {
      btn.addEventListener('click', function () {
        filterBtns.forEach((b) => b.classList.remove('active'));
        this.classList.add('active');
        activeFilter = this.getAttribute('data-filter') || 'all';
        applyFilter();
      });
    });

    // Arama Kutusu Dinleyicisi
    if (searchInput) {
      searchInput.addEventListener('input', function () {
        searchQuery = this.value.trim().toLowerCase();
        applyFilter();
      });
    }
  }

  /**
   * ==========================================================
   * 10. İL TEMSİLCİLİKLERİ DİNAMİK SEÇİMİ VE İLETİŞİM FORMU
   * ==========================================================
   */
  function initCityRepresentatives() {
    const citySelect = document.getElementById('citySelect');
    const districtSelect = document.getElementById('districtSelect');
    const quickChipsContainer = document.getElementById('districtQuickChips');
    const badgeEl = document.getElementById('repCityBadge');
    const levelBadgeEl = document.getElementById('repLevelBadge');
    const nameEl = document.getElementById('repPersonName');
    const clubEl = document.getElementById('repClubName');
    const phoneEl = document.getElementById('repPhoneText');
    const callBtn = document.getElementById('repCallBtn');
    const waBtn = document.getElementById('repWaBtn');
    const resultBox = document.getElementById('repResultBox');

    if (!citySelect) return;

    // 81 İlin İlçeleri Veri Tabanı
    const turkeyDistricts = {
      'Konya': ['Selçuklu', 'Meram', 'Karatay', 'Ereğli', 'Akşehir', 'Beyşehir', 'Seydişehir', 'Çumra', 'Cihanbeyli', 'Ilgın', 'Kulu', 'Kadınhanı', 'Sarayönü', 'Bozkır', 'Karapınar', 'Yunak', 'Hüyük', 'Doğanhisar', 'Hadim', 'Taşkent', 'Güneysınır', 'Emirgazi', 'Derebucak', 'Tuzlukçu', 'Çeltik', 'Derbent', 'Yalıhüyük', 'Halkapınar', 'Ahırlı'],
      'İstanbul': ['Kadıköy', 'Üsküdar', 'Fatih', 'Beşiktaş', 'Ümraniye', 'Pendik', 'Maltepe', 'Kartal', 'Başakşehir', 'Esenyurt', 'Bağcılar', 'Sarıyer', 'Beylikdüzü', 'Bakırköy', 'Şişli', 'Zeytinburnu', 'Gaziosmanpaşa', 'Sultangazi', 'Eyüpsultan', 'Kağıthane', 'Avcılar', 'Küçükçekmece', 'Büyükçekmece', 'Beyoğlu', 'Tuzla', 'Çekmeköy', 'Sancaktepe', 'Sultanbeyli', 'Ataşehir', 'Arnavutköy', 'Silivri', 'Çatalca', 'Şile', 'Adalar'],
      'Ankara': ['Çankaya', 'Keçiören', 'Yenimahalle', 'Mamak', 'Etimesgut', 'Sincan', 'Altındağ', 'Pursaklar', 'Gölbaşı', 'Polatlı', 'Beypazarı', 'Çubuk', 'Kahramankazan', 'Elmadağ', 'Nallıhan', 'Haymana', 'Kızılcahamam', 'Şereflikoçhisar', 'Bala', 'Kalecik', 'Ayaş', 'Güdül', 'Çamlıdere', 'Akyurt', 'Evren'],
      'İzmir': ['Konak', 'Bornova', 'Karşıyaka', 'Buca', 'Karabağlar', 'Bayraklı', 'Çiğli', 'Menemen', 'Gaziemir', 'Torbalı', 'Ödemiş', 'Kemalpaşa', 'Bergama', 'Aliağa', 'Menderes', 'Tire', 'Balçova', 'Narlıdere', 'Urla', 'Çeşme', 'Seferihisar', 'Dikili', 'Selçuk', 'Foça', 'Güzelbahçe', 'Kınık', 'Kiraz', 'Beydağ', 'Karaburun'],
      'Bursa': ['Osmangazi', 'Yıldırım', 'Nilüfer', 'İnegöl', 'Gemlik', 'Mustafakemalpaşa', 'Mudanya', 'Gürsu', 'Karacabey', 'Orhangazi', 'Kestel', 'Yenişehir', 'İznik', 'Orhaneli', 'Keles', 'Büyükorhan', 'Harmancık'],
      'Antalya': ['Muratpaşa', 'Kepez', 'Konyaaltı', 'Alanya', 'Manavgat', 'Serik', 'Kumluca', 'Kaş', 'Korkuteli', 'Gazipaşa', 'Finike', 'Kemer', 'Elmalı', 'Demre', 'Akseki', 'Gündoğmuş', 'İbradı'],
      'Adana': ['Seyhan', 'Çukurova', 'Yüreğir', 'Sarıçam', 'Ceyhan', 'Kozan', 'İmamoğlu', 'Karataş', 'Karaisalı', 'Pozantı', 'Yumurtalık', 'Tufanbeyli', 'Feke', 'Aladağ', 'Saimbeyli'],
      'Gaziantep': ['Şahinbey', 'Şehitkamil', 'Nizip', 'İslahiye', 'Nurdağı', 'Oğuzeli', 'Araban', 'Yavuzeli', 'Karkamış'],
      'Kocaeli': ['İzmit', 'Gebze', 'Darıca', 'Gölcük', 'Körfez', 'Derince', 'Çayırova', 'Kartepe', 'Başiskele', 'Karamürsel', 'Kandıra', 'Dilovası'],
      'Diyarbakır': ['Bağlar', 'Kayapınar', 'Yenişehir', 'Sur', 'Ergani', 'Bismil', 'Silvan', 'Çınar', 'Çermik', 'Dicle', 'Kulp', 'Hani', 'Lice', 'Eğil', 'Hazro', 'Kocaköy', 'Çüngüş'],
      'Samsun': ['İlkadım', 'Atakum', 'Canik', 'Bafra', 'Çarşamba', 'Vezirköprü', 'Terme', 'Tekkeköy', 'Havza', 'Alaçam', '19 Mayıs', 'Ayvacık', 'Kavak', 'Salıpazarı', 'Asarcık', 'Ladik', 'Yakakent'],
      'Trabzon': ['Ortahisar', 'Akçaabat', 'Araklı', 'Of', 'Yomra', 'Arsin', 'Vakfıkebir', 'Sürmene', 'Maçka', 'Beşikdüzü', 'Çarşıbaşı', 'Çaykara', 'Tonya', 'Düzköy', 'Şalpazarı', 'Hayrat', 'Köprübaşı', 'Dernekpazarı'],
      'Kayseri': ['Melikgazi', 'Kocasinan', 'Talas', 'Develi', 'Yahyalı', 'Bünyan', 'İncesu', 'Pınarbaşı', 'Tomarza', 'Yeşilhisar', 'Sarıoğlan', 'Hacılar', 'Sarız', 'Felahiye', 'Akkışla', 'Özvatan'],
      'Erzurum': ['Yakutiye', 'Palandöken', 'Aziziye', 'Horasan', 'Oltu', 'Pasinler', 'Karayazı', 'Hınıs', 'Tekman', 'Karaçoban', 'Aşkale', 'Şenkaya', 'Çat', 'Köprüköy', 'İspir', 'Tortum', 'Narman', 'Uzundere', 'Olur', 'Pazaryolu'],
      'Malatya': ['Yeşilyurt', 'Battalgazi', 'Doğanşehir', 'Akçadağ', 'Darende', 'Hekimhan', 'Pütürge', 'Yazıhan', 'Arapgir', 'Kuluncak', 'Arguvan', 'Kale', 'Doğanyol'],
      'Şanlıurfa': ['Eyyübiye', 'Haliliye', 'Karaköprü', 'Siverek', 'Viranşehir', 'Akçakale', 'Suruç', 'Birecik', 'Ceylanpınar', 'Harran', 'Bozova', 'Hilvan', 'Halfeti'],
      'Sakarya': ['Adapazarı', 'Serdivan', 'Akyazı', 'Erenler', 'Hendek', 'Karasu', 'Geyve', 'Arifiye', 'Sapanca', 'Pamukova', 'Ferizli', 'Kaynarca', 'Kocaali', 'Söğütlü', 'Karapürçek', 'Taraklı'],
      'Mersin': ['Akdeniz', 'Toroslar', 'Yenişehir', 'Mezitli', 'Tarsus', 'Erdemli', 'Silifke', 'Anamur', 'Mut', 'Bozyazı', 'Gülnar', 'Aydıncık', 'Çamlıyayla'],
      'Eskişehir': ['Odunpazarı', 'Tepebaşı', 'Sivrihisar', 'Çifteler', 'Seyitgazi', 'Alpu', 'Mihalıççık', 'Mahmudiye', 'Beylikova', 'İnönü', 'Günyüzü', 'Han', 'Mihalgazi', 'Sarıcakaya'],
      'Denizli': ['Pamukkale', 'Merkezefendi', 'Çivril', 'Acıpayam', 'Tavas', 'Honaz', 'Sarayköy', 'Buldan', 'Kale', 'Çal', 'Çameli', 'Serinhisar', 'Bozkurt', 'Güney', 'Çardak', 'Bekilli', 'Beyağaç', 'Babadağ', 'Baklan'],
      'Balıkesir': ['Altıeylül', 'Karesi', 'Edremit', 'Bandırma', 'Gönen', 'Ayvalık', 'Burhaniye', 'Bigadiç', 'Dursunbey', 'Susurluk', 'Sındırgı', 'İvrindi', 'Erdek', 'Havran', 'Kepsut', 'Manyas', 'Savaştepe', 'Balya', 'Gömeç', 'Marmara'],
      'Kahramanmaraş': ['Onikişubat', 'Dulkadiroğlu', 'Elbistan', 'Afşin', 'Türkoğlu', 'Pazarcık', 'Göksun', 'Andırın', 'Çağlayancerit', 'Nurhak', 'Ekinözü'],
      'Van': ['İpekyolu', 'Tuşba', 'Edremit', 'Erciş', 'Özalp', 'Çaldıran', 'Başkale', 'Muradiye', 'Gürpınar', 'Gevaş', 'Saray', 'Çatak', 'Bahçesaray'],
      'Aydın': ['Efeler', 'Nazilli', 'Söke', 'Kuşadası', 'Didim', 'İncirliova', 'Germencik', 'Çine', 'Bozdoğan', 'Köşk', 'Kuyucak', 'Sultanhisar', 'Karacasu', 'Yenipazar', 'Buharkent', 'Karpuzlu'],
      'Tekirdağ': ['Süleymanpaşa', 'Çorlu', 'Çerkezköy', 'Kapaklı', 'Ergene', 'Malkara', 'Saray', 'Hayrabolu', 'Şarköy', 'Muratlı', 'Marmaraereğlisi'],
      'Manisa': ['Yunusemre', 'Şehzadeler', 'Akhisar', 'Turgutlu', 'Salihli', 'Soma', 'Alaşehir', 'Saruhanlı', 'Kula', 'Kırkağaç', 'Demirci', 'Sarıgöl', 'Gördes', 'Selendi', 'Ahmetli', 'Gölmarmara', 'Köprübaşı'],
      'Hatay': ['Antakya', 'İskenderun', 'Defne', 'Dörtyol', 'Samandağ', 'Kırıkhan', 'Reyhanlı', 'Arsuz', 'Altınözü', 'Hassa', 'Payas', 'Erzin', 'Yayladağı', 'Belen', 'Kumlu'],
      'Muğla': ['Bodrum', 'Fethiye', 'Milas', 'Menteşe', 'Marmaris', 'Seydikemer', 'Ortaca', 'Yatağan', 'Dalaman', 'Köyceğiz', 'Ula', 'Datça', 'Kavaklıdere'],
      'Afyonkarahisar': ['Merkez', 'Sandıklı', 'Dinar', 'Bolvadin', 'Sinanpaşa', 'Emirdağ', 'Şuhut', 'Çay', 'İhsaniye', 'İscehisar', 'Sultandağı', 'Çobanlar', 'Dazkırı', 'Başmakçı', 'Hocalar', 'Kızılören', 'Evciler', 'Bayat'],
      'Sivas': ['Merkez', 'Şarkışla', 'Yıldızeli', 'Suşehri', 'Gemerek', 'Zara', 'Kangal', 'Gürün', 'Divriği', 'Koyulhisar', 'Altınyayla', 'Hafik', 'Ulaş', 'İmranlı', 'Akıncılar', 'Gölova', 'Doğanşar'],
      'Çorum': ['Merkez', 'Sungurlu', 'Osmancık', 'Alaca', 'İskilip', 'Bayat', 'Mecitözü', 'Kargı', 'Ortaköy', 'Uğurludağ', 'Dodurga', 'Oğuzlar', 'Laçin', 'Boğazkale'],
      'Batman': ['Merkez', 'Kozluk', 'Sason', 'Beşiri', 'Gercüş', 'Hasankeyf'],
      'Elazığ': ['Merkez', 'Kovancılar', 'Karakoçan', 'Palu', 'Arıcak', 'Baskil', 'Maden', 'Sivrice', 'Keban', 'Alacakaya', 'Ağın'],
      'Adıyaman': ['Merkez', 'Kahta', 'Besni', 'Gölbaşı', 'Gerger', 'Sincik', 'Çelikhan', 'Tut', 'Samsat'],
      'Ağrı': ['Merkez', 'Patnos', 'Doğubayazıt', 'Diyadin', 'Eleşkirt', 'Tutak', 'Taşlıçay', 'Hamur'],
      'Amasya': ['Merkez', 'Merzifon', 'Suluova', 'Taşova', 'Gümüşhacıköy', 'Göynücek', 'Hamamözü'],
      'Artvin': ['Merkez', 'Hopa', 'Borçka', 'Yusufeli', 'Arhavi', 'Şavşat', 'Ardanuç', 'Murgul', 'Kemalpaşa'],
      'Bilecik': ['Merkez', 'Bozüyük', 'Osmaneli', 'Söğüt', 'Gölpazarı', 'Pazaryeri', 'Yenipazar', 'İnhisar'],
      'Bingöl': ['Merkez', 'Genç', 'Solhan', 'Karlıova', 'Adaklı', 'Kiğı', 'Yedisu', 'Yayladere'],
      'Bitlis': ['Tatvan', 'Merkez', 'Güroymak', 'Ahlat', 'Hizan', 'Mutki', 'Adilcevaz'],
      'Bolu': ['Merkez', 'Gerede', 'Mudurnu', 'Göynük', 'Mengen', 'Yeniçağa', 'Dörtdivan', 'Seben', 'Kıbrıscık'],
      'Burdur': ['Merkez', 'Bucak', 'Gölhisar', 'Yeşilova', 'Ağlasun', 'Çavdır', 'Tefenni', 'Karamanlı', 'Altınyayla', 'Çeltikçi', 'Kemer'],
      'Çanakkale': ['Merkez', 'Biga', 'Çan', 'Gelibolu', 'Yenice', 'Ayvacık', 'Ezine', 'Bayramiç', 'Lapseki', 'Eceabat', 'Gökçeada', 'Bozcaada'],
      'Çankırı': ['Merkez', 'Çerkeş', 'Ilgaz', 'Orta', 'Şabanözü', 'Kurşunlu', 'Yapraklı', 'Kızılırmak', 'Eldivan', 'Atkaracalar', 'Korgun', 'Bayramören'],
      'Edirne': ['Merkez', 'Keşan', 'Uzunköprü', 'İpsala', 'Havsa', 'Meriç', 'Enez', 'Süloğlu', 'Lalapaşa'],
      'Erzincan': ['Merkez', 'Tercan', 'Üzümlü', 'Çayırlı', 'İliç', 'Kemah', 'Kemaliye', 'Refahiye', 'Otlukbeli'],
      'Giresun': ['Merkez', 'Bulancak', 'Espiye', 'Görele', 'Tirebolu', 'Dereli', 'Şebinkarahisar', 'Keşap', 'Yağlıdere', 'Piraziz', 'Eynesil', 'Alucra', 'Çamoluk', 'Güce', 'Doğankent', 'Çanakçı'],
      'Gümüşhane': ['Merkez', 'Kelkit', 'Şiran', 'Kürtün', 'Torul', 'Köse'],
      'Hakkari': ['Yüksekova', 'Merkez', 'Şemdinli', 'Çukurca', 'Derecik'],
      'Isparta': ['Merkez', 'Yalvaç', 'Eğirdir', 'Şarkikaraağaç', 'Gelendost', 'Keçiborlu', 'Senirkent', 'Sütçüler', 'Gönen', 'Uluborlu', 'Atabey', 'Aksu', 'Yenişarbademli'],
      'Kars': ['Merkez', 'Kağızman', 'Sarıkamış', 'Selim', 'Digor', 'Arpaçay', 'Akyaka', 'Susuz'],
      'Kastamonu': ['Merkez', 'Tosya', 'Taşköprü', 'Cide', 'İnebolu', 'Araç', 'Devrekani', 'Bozkurt', 'Daday', 'Azdavay', 'Çatalzeytin', 'Küre', 'Doğanyurt', 'İhsangazi', 'Pınarbaşı', 'Şenpazar', 'Abana', 'Seydiler', 'Hanönü', 'Ağlı'],
      'Kırklareli': ['Lüleburgaz', 'Merkez', 'Babaeski', 'Vize', 'Pınarhisar', 'Demirköy', 'Pehlivanköy', 'Kofçaz'],
      'Kırşehir': ['Merkez', 'Kaman', 'Mucur', 'Çiçekdağı', 'Akpınar', 'Boztepe', 'Akçakent'],
      'Kütahya': ['Merkez', 'Tavşanlı', 'Simav', 'Gediz', 'Emet', 'Altıntaş', 'Domaniç', 'Hisarcık', 'Aslanapa', 'Çavdarhisar', 'Şaphane', 'Pazarlar', 'Dumlupınar'],
      'Mardin': ['Kızıltepe', 'Artuklu', 'Midyat', 'Nusaybin', 'Derik', 'Mazıdağı', 'Dargeçit', 'Savur', 'Yeşilli', 'Ömerli'],
      'Muş': ['Merkez', 'Bulanık', 'Malazgirt', 'Varto', 'Hasköy', 'Korkut'],
      'Nevşehir': ['Merkez', 'Ürgüp', 'Avanos', 'Gülşehir', 'Derinkuyu', 'Acıgöl', 'Kozaklı', 'Hacıbektaş'],
      'Niğde': ['Merkez', 'Bor', 'Çiftlik', 'Ulukışla', 'Altunhisar', 'Çamardı'],
      'Ordu': ['Altınordu', 'Ünye', 'Fatsa', 'Gölköy', 'Kumru', 'Korgan', 'Perşembe', 'Akkuş', 'Aybastı', 'Ulubey', 'İkizce', 'Gürgentepe', 'Çatalpınar', 'Çaybaşı', 'Mesudiye', 'Kabadüz', 'Kabataş', 'Çamaş', 'Gülyalı'],
      'Rize': ['Merkez', 'Çayeli', 'Ardeşen', 'Pazar', 'Fındıklı', 'Güneysu', 'Kalkandere', 'İyidere', 'Derepazarı', 'Çamlıhemşin', 'İkizdere', 'Hemşin'],
      'Siirt': ['Merkez', 'Kurtalan', 'Pervari', 'Baykan', 'Şirvan', 'Eruh', 'Tillo'],
      'Sinop': ['Merkez', 'Boyabat', 'Gerze', 'Ayancık', 'Durağan', 'Türkeli', 'Erfelek', 'Dikmen', 'Saraydüzü'],
      'Tokat': ['Merkez', 'Erbaa', 'Turhal', 'Niksar', 'Zile', 'Reşadiye', 'Almus', 'Pazar', 'Yeşilyurt', 'Artova', 'Sulusaray', 'Başçiftlik'],
      'Tunceli': ['Merkez', 'Pertek', 'Mazgirt', 'Çemişgezek', 'Hozat', 'Ovacık', 'Pülümür', 'Nazımiye'],
      'Uşak': ['Merkez', 'Banaz', 'Eşme', 'Sivaslı', 'Ulubey', 'Karahallı'],
      'Yozgat': ['Merkez', 'Sorgun', 'Akdağmadeni', 'Yerköy', 'Boğazlıyan', 'Sarıkaya', 'Çekerek', 'Şefaatli', 'Saraykent', 'Çayıralan', 'Kadışehri', 'Aydıncık', 'Yenifakılı', 'Chandır'],
      'Zonguldak': ['Ereğli', 'Merkez', 'Çaycuma', 'Devrek', 'Kozlu', 'Alaplı', 'Kilimli', 'Gökçebey'],
      'Aksaray': ['Merkez', 'Ortaköy', 'Eskil', 'Gülağaç', 'Güzelyurt', 'Ağaçören', 'Sarıyahşi', 'Sultanhanı'],
      'Bayburt': ['Merkez', 'Demirözü', 'Aydıntepe'],
      'Karaman': ['Merkez', 'Ermenek', 'Sarıveliler', 'Ayrancı', 'Kazımkarabekir', 'Başyayla'],
      'Kırıkkale': ['Merkez', 'Yahşihan', 'Keskin', 'Delice', 'Bahşılı', 'Sulakyurt', 'Balışeyh', 'Karakeçili', 'Çelebi'],
      'Şırnak': ['Cizre', 'Silopi', 'Merkez', 'İdil', 'Uludere', 'Beytüşşebap', 'Güçlükonak'],
      'Bartın': ['Merkez', 'Ulus', 'Amasra', 'Kurucaşile'],
      'Ardahan': ['Merkez', 'Göle', 'Çıldır', 'Hanak', 'Posof', 'Damal'],
      'Iğdır': ['Merkez', 'Tuzluca', 'Aralık', 'Karakoyunlu'],
      'Yalova': ['Merkez', 'Çiftlikköy', 'Çınarcık', 'Altınova', 'Armutlu', 'Termal'],
      'Karabük': ['Merkez', 'Safranbolu', 'Yenice', 'Eskipazar', 'Eflani', 'Ovacık'],
      'Kilis': ['Merkez', 'Musabeyli', 'Elbeyli', 'Polateli'],
      'Osmaniye': ['Merkez', 'Kadirli', 'Düziçi', 'Bahçe', 'Toprakkale', 'Sumbas', 'Hasanbeyli'],
      'Düzce': ['Merkez', 'Akçakoca', 'Kaynaşlı', 'Gölyaka', 'Çilimli', 'Yığılca', 'Gümüşova', 'Cumayeri']
    };

    // İl ve İlçe Özel Temsilci Bilgileri Veritabanı
    const customRepresentatives = {
      'Konya': {
        main: {
          name: 'Osman ERDEM',
          club: 'Şehristan Gençlik Spor ve İzcilik Kulübü',
          phone: '0535 595 40 60'
        },
        districts: {
          'Selçuklu': { name: 'Mustafa ÇETİN', club: 'Selçuklu Gençlik ve Kültür Kulübü', phone: '0535 595 40 61' },
          'Meram': { name: 'Mehmet Ali YILDIZ', club: 'Meram İrfan ve İzcilik Derneği', phone: '0535 595 40 62' },
          'Karatay': { name: 'İbrahim KAYA', club: 'Karatay Bilgi ve Gelişim Kulübü', phone: '0535 595 40 63' },
          'Ereğli': { name: 'Hasan YILMAZ', club: 'Ereğli Gençlik ve Spor Kulübü', phone: '0535 595 40 64' },
          'Akşehir': { name: 'Ali DEMİR', club: 'Akşehir Nasreddin Gençlik Kulübü', phone: '0535 595 40 65' },
          'Beyşehir': { name: 'Ömer ŞAHİN', club: 'Beyşehir Göl Gençlik Kulübü', phone: '0535 595 40 66' },
          'Seydişehir': { name: 'Yusuf AKTAŞ', club: 'Seydişehir Gençlik Kulübü', phone: '0535 595 40 67' }
        }
      },
      'İstanbul': {
        main: {
          name: 'Ahmet YILMAZ',
          club: 'Server Gençlik ve İzcilik Kulübü Derneği',
          phone: '0532 111 22 33'
        },
        districts: {
          'Kadıköy': { name: 'Serkan YILDIZ', club: 'Kadıköy Server İzcilik Kulübü', phone: '0532 111 22 34' },
          'Üsküdar': { name: 'Bilal ÇELİK', club: 'Üsküdar İrfan ve Gençlik Kulübü', phone: '0532 111 22 35' },
          'Fatih': { name: 'Emre DEMİR', club: 'Fatih Gençlik ve Spor Kulübü', phone: '0532 111 22 36' },
          'Başakşehir': { name: 'Mahmut ŞAHİN', club: 'Başakşehir Bilgi ve Kültür Derneği', phone: '0532 111 22 37' },
          'Ümraniye': { name: 'Yusuf ASLAN', club: 'Ümraniye Lider İzcilik Kulübü', phone: '0532 111 22 38' },
          'Pendik': { name: 'Murat KAYA', club: 'Pendik Gençlik Spor Kulübü', phone: '0532 111 22 39' },
          'Beşiktaş': { name: 'Kemal BOZKURT', club: 'Beşiktaş Bilgi ve İlim Kulübü', phone: '0532 111 22 40' }
        }
      },
      'Ankara': {
        main: {
          name: 'Mehmet DEMİR',
          club: 'Asfa Gençlik Spor ve İzcilik Kulübü',
          phone: '0533 222 33 44'
        },
        districts: {
          'Çankaya': { name: 'Murat KILIÇ', club: 'Çankaya Asfa Gençlik Kulübü', phone: '0533 222 33 45' },
          'Keçiören': { name: 'Kemal BOZKURT', club: 'Keçiören Bilgi ve Kültür Kulübü', phone: '0533 222 33 46' },
          'Yenimahalle': { name: 'Hüseyin DOĞAN', club: 'Yenimahalle Gençlik ve İzcilik Kulübü', phone: '0533 222 33 47' },
          'Etimesgut': { name: 'Recep GÜLER', club: 'Etimesgut Lider Gençlik Kulübü', phone: '0533 222 33 48' },
          'Sincan': { name: 'Fatih ÖZTÜRK', club: 'Sincan Bilgi Evi ve Gençlik Kulübü', phone: '0533 222 33 49' },
          'Mamak': { name: 'Ali YILDIRIM', club: 'Mamak İrfan Spor Kulübü', phone: '0533 222 33 50' }
        }
      },
      'İzmir': {
        main: {
          name: 'Mustafa KAYA',
          club: 'Kordon Gençlik ve İzcilik Kulübü',
          phone: '0535 333 44 55'
        },
        districts: {
          'Konak': { name: 'Kemal AKSOY', club: 'Konak Kordon Gençlik Kulübü', phone: '0535 333 44 56' },
          'Bornova': { name: 'Mustafa KOÇ', club: 'Bornova İrfan ve Bilgi Derneği', phone: '0535 333 44 57' },
          'Karşıyaka': { name: 'Ahmet YALÇIN', club: 'Karşıyaka Gençlik Spor Kulübü', phone: '0535 333 44 58' },
          'Buca': { name: 'Selim ŞEN', club: 'Buca İzcilik ve Spor Kulübü', phone: '0535 333 44 59' }
        }
      },
      'Bursa': {
        main: {
          name: 'İbrahim ÇELİK',
          club: 'Uludağ Gençlik Spor Kulübü Derneği',
          phone: '0536 444 55 66'
        },
        districts: {
          'Osmangazi': { name: 'Süleyman ÇETİN', club: 'Osmangazi Uludağ Gençlik Kulübü', phone: '0536 444 55 67' },
          'Nilüfer': { name: 'Faruk ÖZTÜRK', club: 'Nilüfer Bilgi ve İzcilik Kulübü', phone: '0536 444 55 68' },
          'Yıldırım': { name: 'Yasin DOĞAN', club: 'Yıldırım Gençlik Spor Kulübü', phone: '0536 444 55 69' },
          'İnegöl': { name: 'Fatih ŞAHİN', club: 'İnegöl İrfan Gençlik Kulübü', phone: '0536 444 55 70' }
        }
      },
      'Antalya': {
        main: {
          name: 'Hasan ŞAHİN',
          club: 'Akdeniz Bilgi ve Kültür Kulübü',
          phone: '0537 555 66 77'
        },
        districts: {
          'Muratpaşa': { name: 'Erhan KAYA', club: 'Muratpaşa Akdeniz Kültür Kulübü', phone: '0537 555 66 78' },
          'Alanya': { name: 'Cevdet YILMAZ', club: 'Alanya Gençlik ve İzcilik Kulübü', phone: '0537 555 66 79' },
          'Kepez': { name: 'Metin DEMİR', club: 'Kepez İrfan ve Spor Kulübü', phone: '0537 555 66 80' }
        }
      },
      'Adana': {
        main: {
          name: 'Yusuf DOĞAN',
          club: 'Çukurova Gençlik ve Spor Kulübü',
          phone: '0538 666 77 88'
        }
      },
      'Gaziantep': {
        main: {
          name: 'Ali YILDIZ',
          club: 'Gaziantep İlim ve Kültür Derneği',
          phone: '0539 777 88 99'
        }
      },
      'Trabzon': {
        main: {
          name: 'Fatih ÖZTÜRK',
          club: 'Karadeniz Gençlik İzcilik Kulübü',
          phone: '0530 888 99 00'
        }
      },
      'Kayseri': {
        main: {
          name: 'Abdullah KILIÇ',
          club: 'Erciyes Gençlik Spor Kulübü',
          phone: '0531 999 00 11'
        }
      },
      'Diyarbakır': {
        main: {
          name: 'Ömer ASLAN',
          club: 'Dicle Gençlik ve Kültür Kulübü',
          phone: '0534 000 11 22'
        }
      },
      'Samsun': {
        main: {
          name: 'Hüseyin AYDIN',
          club: 'Canik Gençlik Spor Kulübü',
          phone: '0535 123 45 67'
        }
      },
      'Kocaeli': {
        main: {
          name: 'Recep GÜLER',
          club: 'Kocaeli Lider Gençlik Kulübü',
          phone: '0536 234 56 78'
        }
      },
      'Erzurum': {
        main: {
          name: 'Emre PALANDÖKEN',
          club: 'Palandöken Gençlik ve İzcilik Kulübü',
          phone: '0537 345 67 89'
        }
      },
      'Malatya': {
        main: {
          name: 'Kemal BOZKURT',
          club: 'Battalgazi Gençlik Kulübü',
          phone: '0538 456 78 90'
        }
      },
      'Şanlıurfa': {
        main: {
          name: 'Halil KARA',
          club: 'Balıklıgöl Gençlik ve Kültür Derneği',
          phone: '0539 567 89 01'
        }
      }
    };

    /**
     * Temsilci Bilgisini Getir ve Kartı Güncelle
     */
    function updateRepresentative(city, district = '__ALL__') {
      const cityData = customRepresentatives[city];
      let repInfo = null;
      let isDistrictView = (district && district !== '__ALL__');

      if (isDistrictView) {
        // İlçe Temsilcisi
        if (cityData && cityData.districts && cityData.districts[district]) {
          repInfo = cityData.districts[district];
        } else {
          // Dinamik gerçekçi ilçe temsilcisi oluştur
          repInfo = {
            name: `${district} İlçe Sorumlusu`,
            club: `${city} ${district} Gençlik ve İzcilik Kulübü`,
            phone: '0532 000 ' + String(Math.abs(district.split('').reduce((acc, c) => acc + c.charCodeAt(0), 0) % 9000 + 1000)).slice(0, 4)
          };
        }

        if (badgeEl) badgeEl.textContent = `${city.toUpperCase()} - ${district.toUpperCase()} İLÇE TEMSİLCİLİĞİ`;
        if (levelBadgeEl) {
          levelBadgeEl.textContent = 'İlçe Temsilciliği';
          levelBadgeEl.className = 'badge bg-warning bg-opacity-25 text-dark border border-warning small';
        }
      } else {
        // İl Merkezi Temsilcisi
        if (cityData && cityData.main) {
          repInfo = cityData.main;
        } else {
          repInfo = {
            name: `${city} İl Temsilcisi`,
            club: `${city} Gençlik Spor ve İzcilik Kulübü`,
            phone: '0532 000 00 00'
          };
        }

        if (badgeEl) badgeEl.textContent = `${city.toUpperCase()} İL TEMSİLCİLİĞİ`;
        if (levelBadgeEl) {
          levelBadgeEl.textContent = 'Yetkili İl Temsilcisi';
          levelBadgeEl.className = 'badge bg-light text-secondary border small';
        }
      }

      // DOM Alanlarını Doldur
      if (nameEl) nameEl.textContent = repInfo.name;
      if (clubEl) clubEl.textContent = repInfo.club;
      if (phoneEl) phoneEl.textContent = repInfo.phone;

      const cleanPhone = repInfo.phone.replace(/\D/g, '');
      if (callBtn) callBtn.setAttribute('href', `tel:0${cleanPhone.replace(/^0/, '')}`);
      if (waBtn) waBtn.setAttribute('href', `https://wa.me/90${cleanPhone.replace(/^0/, '')}`);

      // Hızlı İlçe Etiketlerini Senkronize Et
      if (quickChipsContainer) {
        const chips = quickChipsContainer.querySelectorAll('.district-chip-btn');
        chips.forEach(chip => {
          chip.classList.toggle('active', chip.getAttribute('data-district') === district);
        });
      }

      // Hafif geçiş animasyonu
      if (resultBox) {
        resultBox.style.opacity = '0.4';
        resultBox.style.transform = 'translateY(4px)';
        setTimeout(() => {
          resultBox.style.opacity = '1';
          resultBox.style.transform = 'translateY(0)';
        }, 120);
      }
    }

    /**
     * Seçilen İle Göre İlçe Dropdown'ını ve Hızlı Butonları Doldur
     */
    function populateDistricts(city) {
      if (!districtSelect) return;

      const districts = turkeyDistricts[city] || ['Merkez'];
      districtSelect.innerHTML = '<option value="__ALL__" selected>Tüm İl (İl Temsilciliği)</option>';

      districts.forEach(dist => {
        const opt = document.createElement('option');
        opt.value = dist;
        opt.textContent = dist;
        districtSelect.appendChild(opt);
      });

      // Hızlı Seçim Butonları (Chips)
      if (quickChipsContainer) {
        quickChipsContainer.innerHTML = '';

        // "Tüm İl" Butonu
        const allBtn = document.createElement('button');
        allBtn.type = 'button';
        allBtn.className = 'district-chip-btn active';
        allBtn.setAttribute('data-district', '__ALL__');
        allBtn.textContent = '🏢 Tüm İl (Merkez)';
        allBtn.addEventListener('click', () => {
          districtSelect.value = '__ALL__';
          updateRepresentative(citySelect.value, '__ALL__');
        });
        quickChipsContainer.appendChild(allBtn);

        // İlk 5 popüler ilçeyi buton olarak ekle
        const topDistricts = districts.slice(0, 5);
        topDistricts.forEach(dist => {
          const chip = document.createElement('button');
          chip.type = 'button';
          chip.className = 'district-chip-btn';
          chip.setAttribute('data-district', dist);
          chip.textContent = dist;
          chip.addEventListener('click', () => {
            districtSelect.value = dist;
            updateRepresentative(citySelect.value, dist);
          });
          quickChipsContainer.appendChild(chip);
        });
      }
    }

    // İl Değiştiğinde
    citySelect.addEventListener('change', function () {
      populateDistricts(this.value);
      updateRepresentative(this.value, '__ALL__');
    });

    // İlçe Değiştiğinde
    if (districtSelect) {
      districtSelect.addEventListener('change', function () {
        updateRepresentative(citySelect.value, this.value);
      });
    }

    // İlk açılışta seçili ili ve ilçeleri yükle
    const initialCity = citySelect.value || 'Konya';
    populateDistricts(initialCity);
    updateRepresentative(initialCity, '__ALL__');
  }

  function initContactForm() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('btnContactSubmit');

    if (!form || !submitBtn) return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const name = document.getElementById('contactName')?.value.trim();
      const email = document.getElementById('contactEmail')?.value.trim();
      const message = document.getElementById('contactMessage')?.value.trim();

      if (!name || !email || !message) {
        alert('Lütfen zorunlu alanları eksiksiz doldurunuz.');
        return;
      }

      const origText = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span>Gönderiliyor...</span>';

      setTimeout(() => {
        submitBtn.innerHTML = '<span>Mesajınız Alındı ✓</span>';
        submitBtn.classList.remove('btn-yellow');
        submitBtn.classList.add('btn-success');

        setTimeout(() => {
          alert('Mesajınız başarıyla iletildi. En kısa sürede sizinle iletişime geçeceğiz.');
          form.reset();
          submitBtn.disabled = false;
          submitBtn.innerHTML = origText;
          submitBtn.classList.remove('btn-success');
          submitBtn.classList.add('btn-yellow');
        }, 600);
      }, 700);
    });
  }

  /**
   * ==========================================================
   * 11. ÖDÜLLER SAYFASI DİNAMİK YEREL ÖDÜL VE KATEGORİ SEÇİMİ
   * ==========================================================
   */
  function initAwardsPage() {
    const citySelect = document.getElementById('awardCitySelect');
    const localContentArea = document.getElementById('localAwardsDynamicContent');
    const cityBadge = document.getElementById('localSelectedCityName');

    if (!citySelect || !localContentArea) return;

    // İl bazlı dinamik ödül veri havuzu
    const cityData = {
      'Konya': {
        lead: 'Yarım Altın + Umre Katkı Payı (15.000₺)',
        second: 'Çeyrek Altın (8.000₺)',
        third: 'Gram Altın (5.000₺)',
        honorable: '2.500₺ Kitap & Kırtasiye Çeki (4. - 10.)',
        districts: [
          { name: 'Selçuklu İlçesi', awards: '1. Çeyrek Altın | 2. Gram Altın | 3. 2.000₺ Hediye Çeki' },
          { name: 'Meram İlçesi', awards: '1. Çeyrek Altın | 2. Gram Altın | 3. 2.000₺ Hediye Çeki' },
          { name: 'Karatay İlçesi', awards: '1. Çeyrek Altın | 2. Gram Altın | 3. 2.000₺ Hediye Çeki' },
          { name: 'Ereğli İlçesi', awards: '1. Gram Altın | 2. 1.500₺ | 3. 1.000₺ Kitap Çeki' }
        ],
        notes: 'Konya il ödülleri Şehristan Gençlik Spor Kulübü koordinasyonunda gerçekleştirilecek gala gecesinde takdim edilecektir.'
      },
      'İstanbul': {
        lead: '1 Tam Altın (20.000₺)',
        second: 'Yarım Altın (10.000₺)',
        third: 'Çeyrek Altın (6.000₺)',
        honorable: '3.000₺ Teknoloji & Kitap Çeki (4. - 10.)',
        districts: [
          { name: 'Üsküdar & Kadıköy', awards: '1. Yarım Altın | 2. Çeyrek Altın | 3. Gram Altın' },
          { name: 'Fatih & Başakşehir', awards: '1. Yarım Altın | 2. Çeyrek Altın | 3. Gram Altın' },
          { name: 'Pendik & Kartal', awards: '1. Çeyrek Altın | 2. Gram Altın | 3. 2.000₺ Çek' }
        ],
        notes: 'İstanbul ödül töreni Haliç Kongre Merkezi\'nde düzenlenecek görkemli kapanış programında verilecektir.'
      },
      'Ankara': {
        lead: 'Yarım Altın + 12.000₺ Hediye Çeki',
        second: 'Çeyrek Altın (8.000₺)',
        third: 'Gram Altın (5.000₺)',
        honorable: '2.000₺ Eğitim Bursu Desteği (4. - 10.)',
        districts: [
          { name: 'Keçiören & Yenimahalle', awards: '1. Çeyrek Altın | 2. Gram Altın | 3. 2.000₺ Çek' },
          { name: 'Çankaya & Mamak', awards: '1. Çeyrek Altın | 2. Gram Altın | 3. 2.000₺ Çek' },
          { name: 'Sincan & Etimesgut', awards: '1. Gram Altın | 2. 1.500₺ | 3. 1.000₺ Çek' }
        ],
        notes: 'Ankara İl Milli Eğitim Müdürlüğü ve ilgili gençlik kulüplerinin ortak organizasyonu ile takdim edilecektir.'
      }
    };

    function renderLocalAwards(cityName) {
      if (cityBadge) cityBadge.textContent = cityName || 'Tüm İller';

      const data = cityData[cityName] || {
        lead: 'Yarım Altın / 12.000₺ Değerinde Hediye',
        second: 'Çeyrek Altın / 7.500₺ Değerinde Hediye',
        third: 'Gram Altın / 4.500₺ Değerinde Hediye',
        honorable: '1.500₺ Başarı Teşvik Çeki (4. - 10.)',
        districts: [
          { name: 'Merkez İlçe', awards: '1. Çeyrek Altın | 2. Gram Altın | 3. 1.500₺ Çek' },
          { name: 'Diğer Tüm İlçeler', awards: '1. Gram Altın | 2. 1.000₺ Kitap Çeki' }
        ],
        notes: `${cityName} İl Temsilciliği ve proje paydaşlarımız tarafından sınav sonrası düzenlenecek il ödül töreninde kazanan yarışmacılara takdim edilecektir.`
      };

      let districtHtml = '';
      if (data.districts && data.districts.length > 0) {
        districtHtml = `
          <div class="district-awards-container">
            <h5 class="district-awards-title">
              <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
              <span>${cityName} İlçe & Okul Başarı Ödülleri</span>
            </h5>
            <div class="row g-3">
              ${data.districts.map(d => `
                <div class="col-md-6">
                  <div class="district-item-card shadow-xs">
                    <div class="fw-bold text-dark fs-6 mb-1">${d.name}</div>
                    <div class="text-primary fw-semibold fs-7">${d.awards}</div>
                  </div>
                </div>
              `).join('')}
            </div>
          </div>
        `;
      }

      localContentArea.innerHTML = `
        <!-- Podyum Dereceleri (1., 2., 3.) -->
        <div class="award-podium-row mb-3">
          <div class="award-podium-col">
            <div class="podium-card gold">
              <div class="podium-medal-badge bg-warning bg-opacity-25 text-warning">🥇</div>
              <div class="podium-rank-label text-warning">1. İl Birincisi</div>
              <div class="podium-prize-val">${data.lead}</div>
              <p class="podium-prize-desc">Büyük İl Başarı Ödülü</p>
            </div>
          </div>
          <div class="award-podium-col">
            <div class="podium-card silver">
              <div class="podium-medal-badge bg-secondary bg-opacity-25 text-secondary">🥈</div>
              <div class="podium-rank-label text-secondary">2. İl İkincisi</div>
              <div class="podium-prize-val">${data.second}</div>
              <p class="podium-prize-desc">İl Derecesi Ödülü</p>
            </div>
          </div>
          <div class="award-podium-col">
            <div class="podium-card bronze">
              <div class="podium-medal-badge bg-warning bg-opacity-25" style="color:#D97706;">🥉</div>
              <div class="podium-rank-label" style="color:#D97706;">3. İl Üçüncüsü</div>
              <div class="podium-prize-val">${data.third}</div>
              <p class="podium-prize-desc">İl Derecesi Ödülü</p>
            </div>
          </div>
        </div>

        <!-- 4. - 10. Sıralama ve Mansiyon Ödülü -->
        <div class="p-3 bg-light rounded-3 border mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary px-3 py-2 fs-7 fw-bold">4. - 10. Sıralama</span>
            <span class="fw-bold text-dark fs-6">${data.honorable}</span>
          </div>
          <span class="text-muted fs-7">Mansiyon & Başarı Teşvik Desteği</span>
        </div>

        ${districtHtml}

        <!-- Bilgilendirme Notu -->
        <div class="award-notes-banner">
          <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="flex-shrink-0 mt-0.5">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <div>
            <h6 class="fw-bold mb-1">Resmi İl Ödül Töreni Bilgilendirmesi</h6>
            <p class="mb-0 fs-7">${data.notes}</p>
          </div>
        </div>
      `;

      // Hafif geçiş efekti
      localContentArea.style.opacity = '0.5';
      setTimeout(() => {
        localContentArea.style.opacity = '1';
      }, 150);
    }

    citySelect.addEventListener('change', function () {
      if (!this.value) {
        localContentArea.innerHTML = `
          <div class="alert alert-info py-4 text-center" role="alert">
            <h5 class="fw-bold mb-1">Lütfen Yukarıdaki Kutucuktan İl Seçimi Yapınız</h5>
            <p class="text-muted fs-7 mb-0">Seçtiğiniz ile ait il birinciliği, ilçe ve okul başarı ödülleri bu alanda listelenecektir.</p>
          </div>
        `;
        if (cityBadge) cityBadge.textContent = 'İl Seçiniz';
      } else {
        renderLocalAwards(this.value);
      }
    });

    // Yerel Kategori Sekmeleri Tıklama Yönetimi
    const localTabButtons = document.querySelectorAll('#localAwardsTabs .nav-link');
    localTabButtons.forEach(btn => {
      btn.addEventListener('click', function () {
        localTabButtons.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        renderLocalAwards(citySelect.value || 'Konya');
      });
    });

    // Varsayılan olarak Konya veya ilk seçili ili göster
    renderLocalAwards(citySelect.value || 'Konya');
  }

  /**
   * ==========================================================
   * 12. ONLINE SORU SİMÜLATÖRÜ VE KADEME SEÇİMİ
   * ==========================================================
   */
  function initQuizSimulator() {
    const gradeButtons = document.querySelectorAll('.quiz-grade-btn');
    const optionsGroup = document.getElementById('simOptionsGroup');
    const feedbackBox = document.getElementById('quizFeedbackBox');
    const subjectLabel = document.getElementById('quizSubjectLabel');
    const questionText = document.getElementById('simQuestionText');

    const gradeData = {
      ilkokul: {
        subject: 'İlkokul • 1-4. Sınıf',
        question: 'Kitaptaki macerada kahramanımızın karşılaştığı zorlukları aşmasında ona en çok yardımcı olan erdem hangisidir?',
        options: [
          { letter: 'A', text: 'Sabır, dürüstlük ve arkadaşlarına güvenmek', correct: true },
          { letter: 'B', text: 'Tek başına aceleyle kurallara uymadan hareket etmek', correct: false },
          { letter: 'C', text: 'Karşılaştığı ilk engelde pes edip vazgeçmek', correct: false },
          { letter: 'D', text: 'Sadece kolay yolları ve kestirmeleri aramak', correct: false }
        ],
        feedback: 'Harika! Sabır ve erdemli davranışlar her zaman en doğru kapıları açar. +10 XP kazandınız!'
      },
      ortaokul: {
        subject: 'Ortaokul • 5-8. Sınıf',
        question: '12. Ufka Yolculuk yarışmasında kitap okuma sürecinde odaklanmayı artırmak ve bilgileri kalıcı kılmak için hangisi en etkili yöntemdir?',
        options: [
          { letter: 'A', text: 'Sadece sınavdan önceki son gece tüm kitabı hızlıca okumak', correct: false },
          { letter: 'B', text: 'Önemli noktaları not alarak, sesli dinleyip düzenli tekrarlar yapmak', correct: true },
          { letter: 'C', text: 'Soruları kitaba hiç çalışmadan rastgele tahminlerle çözmek', correct: false },
          { letter: 'D', text: 'Metni okumadan yalnızca görsel ve kapak resimlerine bakmak', correct: false }
        ],
        feedback: 'Tebrikler! Düzenli ve not alarak okuma, bilgilerin hafızada kalıcı olmasını sağlar. +10 XP kazandınız!'
      },
      lise: {
        subject: 'Lise • 9-12. Sınıf',
        question: 'Felsefe ve medeniyet tasavvuru bağlamında, eleştirel düşüncenin bireye kazandırdığı en temel yetkinlik nedir?',
        options: [
          { letter: 'A', text: 'Her düşünceyi sorgulamadan doğrudan kabul etmek', correct: false },
          { letter: 'B', text: 'Olayları çok boyutlu analiz edip bilgiye akıl ve hikmetle yaklaşmak', correct: true },
          { letter: 'C', text: 'Farklı görüşleri dinlemeden sadece kendi fikrini savunmak', correct: false },
          { letter: 'D', text: 'Bilgileri araştırmadan yalnızca popüler kaynaklara inanmak', correct: false }
        ],
        feedback: 'Mükemmel tespit! Hikmet ve akıl süzgecinden geçen bilgi en güçlü rehberdir. +10 XP kazandınız!'
      },
      yetiskin: {
        subject: 'Yetişkin • 18+ Yaş & Üniversite',
        question: 'Kadim ahlak metinlerinde irade eğitimi ve bireysel kemalatın toplum inşaasındaki rolü nasıl temellendirilir?',
        options: [
          { letter: 'A', text: 'Bireysel ahlakın yükselmesi, adil ve erdemli bir toplumun temel taşıdır', correct: true },
          { letter: 'B', text: 'Toplumsal gelişim yalnızca maddi ilerleme ve teknolojiyle mümkündür', correct: false },
          { letter: 'C', text: 'Geçmiş literatürün modern dönem problemlerine hiçbir katkısı yoktur', correct: false },
          { letter: 'D', text: 'Bireysel sorumluluklar toplumun genel refahını etkilemez', correct: false }
        ],
        feedback: 'Tebrikler, doğru cevap! Erdemli bireyler, aydınlık bir geleceğin sarsılmaz temelidir. +10 XP kazandınız!'
      }
    };

    function attachOptionListeners() {
      const optionButtons = document.querySelectorAll('.quiz-option-item');
      optionButtons.forEach(btn => {
        btn.addEventListener('click', function () {
          const isCorrect = this.getAttribute('data-correct') === 'true';

          optionButtons.forEach(b => {
            b.classList.remove('correct', 'wrong');
            b.disabled = true;
          });

          if (isCorrect) {
            this.classList.add('correct');
            if (feedbackBox) {
              feedbackBox.className = 'quiz-feedback-box';
              document.getElementById('feedbackIcon').textContent = '🎉';
              document.getElementById('feedbackTitle').textContent = 'Tebrikler, Doğru Cevap!';
              document.getElementById('feedbackDesc').textContent = this.getAttribute('data-feedback') || 'Doğru şıkkı buldunuz. +10 XP hesabınıza eklendi!';
            }
          } else {
            this.classList.add('wrong');
            // Doğru olanı da yeşil göster
            optionButtons.forEach(b => {
              if (b.getAttribute('data-correct') === 'true') {
                b.classList.add('correct');
              }
            });
            if (feedbackBox) {
              feedbackBox.className = 'quiz-feedback-box bg-danger-subtle border-danger-subtle';
              document.getElementById('feedbackIcon').textContent = '💡';
              document.getElementById('feedbackTitle').textContent = 'Tekrar Deneyebilirsin!';
              document.getElementById('feedbackDesc').textContent = 'Doğru cevap yeşil renkle işaretlendi. Konu tekrarı için sisteme giriş yapabilirsiniz.';
            }
          }
        });
      });
    }

    if (gradeButtons.length && optionsGroup) {
      gradeButtons.forEach(btn => {
        btn.addEventListener('click', function () {
          gradeButtons.forEach(b => b.classList.remove('active'));
          this.classList.add('active');

          const grade = this.getAttribute('data-grade');
          const data = gradeData[grade] || gradeData.ortaokul;

          if (subjectLabel) subjectLabel.textContent = data.subject;
          if (questionText) questionText.textContent = data.question;

          let optionsHtml = '';
          data.options.forEach(opt => {
            optionsHtml += `
              <button type="button" class="quiz-option-item" data-option="${opt.letter}" data-correct="${opt.correct}" data-feedback="${data.feedback}">
                <span class="opt-letter">${opt.letter}</span>
                <span class="opt-text">${opt.text}</span>
              </button>
            `;
          });
          optionsGroup.innerHTML = optionsHtml;

          if (feedbackBox) feedbackBox.classList.add('d-none');
          attachOptionListeners();
        });
      });

      attachOptionListeners();
    }
  }

  /**
   * ==========================================================
   * 13. OYUN & MİNİ ETKİNLİK MODAL YÖNETİMİ
   * ==========================================================
   */
  function initGamesModal() {
    const gameButtons = document.querySelectorAll('[data-game-modal]');
    const gameModalEl = document.getElementById('gameModal');

    if (!gameModalEl) return;

    gameButtons.forEach(btn => {
      btn.addEventListener('click', function () {
        const title = this.getAttribute('data-game-title') || 'Mini Oyun';
        const desc = this.getAttribute('data-game-desc') || 'Yarışma kitaplarındaki kavramları ve olayları eğlenerek pekiştirin.';
        
        const titleEl = document.getElementById('gameModalLabel');
        const descEl = document.getElementById('gameModalDesc');

        if (titleEl) titleEl.textContent = title;
        if (descEl) descEl.textContent = desc;

        if (typeof bootstrap !== 'undefined') {
          const modalInstance = bootstrap.Modal.getOrCreateInstance(gameModalEl);
          modalInstance.show();
        }
      });
    });
  }

  /**
   * ==========================================================
   * 14. PODCAST & VIDEO MEDYA OYNATICI MODAL YÖNETİMİ
   * ==========================================================
   */
  function initMediaModal() {
    const mediaModalEl = document.getElementById('mediaPlayerModal');
    if (!mediaModalEl) return;

    const iframeEl = document.getElementById('mediaPlayerIframe');
    const titleEl = document.getElementById('mediaPlayerModalLabel');
    const descEl = document.getElementById('mediaPlayerModalDesc');
    const tagBadgeEl = document.getElementById('mediaPlayerTagBadge');
    const durationBadgeEl = document.getElementById('mediaPlayerDurationBadge');

    mediaModalEl.addEventListener('show.bs.modal', function (event) {
      const triggerCard = event.relatedTarget || (event.target ? event.target.closest('.media-card-custom') : null);
      if (!triggerCard) return;

      const tag = triggerCard.getAttribute('data-media-tag') || 'PODCAST';
      const tagClass = triggerCard.getAttribute('data-media-tag-class') || 'podcast';
      const title = triggerCard.getAttribute('data-media-title') || 'Podcast & Video';
      const duration = triggerCard.getAttribute('data-media-duration') || '00:00';
      const url = triggerCard.getAttribute('data-media-url') || '';
      const desc = triggerCard.getAttribute('data-media-desc') || 'Ufka Yolculuk rehber içerikleri ve sohbetler.';

      if (titleEl) titleEl.textContent = title;
      if (descEl) descEl.textContent = desc;
      if (durationBadgeEl) durationBadgeEl.textContent = `⏱️ ${duration}`;

      if (tagBadgeEl) {
        tagBadgeEl.textContent = tag;
        tagBadgeEl.className = `badge px-3 py-2 fw-bold fs-6 rounded-pill ${tagClass === 'podcast' ? 'bg-warning text-dark' : 'bg-primary text-white'}`;
      }

      if (iframeEl && url) {
        iframeEl.src = url;
      }
    });

    // Modal kapandığında oynatmayı durdur (iframe src temizle)
    mediaModalEl.addEventListener('hidden.bs.modal', function () {
      if (iframeEl) {
        iframeEl.src = '';
      }
    });
  }

})();
