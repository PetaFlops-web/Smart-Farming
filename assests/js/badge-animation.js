const anchor = document.getElementById('badge-anchor');
const pendulum = document.getElementById('badge-pendulum');
const string = pendulum.querySelector('.badge-string');

let isDragging = false;
const DEFAULT_STRING_LENGTH = 120; // Sesuai dengan CSS height

// Fungsi untuk memulai drag
const startDrag = (e) => {
    isDragging = true;
    pendulum.classList.add('dragging');
    // Tambahkan transisi halus saat pertama kali diklik menuju posisi kursor
    pendulum.style.transition = 'transform 0.1s ease-out';
};

// Fungsi saat kursor bergerak
const onDrag = (e) => {
    if (!isDragging) return;

    // Ambil posisi kursor (mendukung mouse & layar sentuh)
    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
    const clientY = e.touches ? e.touches[0].clientY : e.clientY;

    // Cari koordinat titik jangkar (poros atas)
    const anchorRect = anchor.getBoundingClientRect();
    const anchorX = anchorRect.left + (anchorRect.width / 2);
    const anchorY = anchorRect.top;

    // Hitung jarak (delta) antara kursor dan poros
    const dx = clientX - anchorX;
    const dy = clientY - anchorY;

    // Hitung Sudut (Rotasi) menggunakan arctangent
    // Dikurangi Math.PI/2 karena posisi default 0 derajat kita adalah menghadap ke bawah
    const angleRad = Math.atan2(dy, dx) - (Math.PI / 2);
    const angleDeg = angleRad * (180 / Math.PI);

    // Hitung Jarak (Panjang tali) menggunakan pythagoras
    const distance = Math.hypot(dx, dy);
    
    // Kurangi jarak dengan setengah tinggi badge agar kursor pas berada di tengah badge, bukan di ujung tali
    const badgeHeightOffset = 40; 
    const newStringLength = Math.max(20, distance - badgeHeightOffset); // Minimal panjang tali 20px

    // Terapkan perubahan ke elemen
    pendulum.style.transform = `rotate(${angleDeg}deg)`;
    string.style.height = `${newStringLength}px`;
    
    // Hapus transisi setelah pergerakan awal agar tidak lag
    setTimeout(() => { if(isDragging) pendulum.style.transition = 'none'; }, 100);
};

// Fungsi saat dilepas (kembali ke posisi semula)
const endDrag = () => {
    if (!isDragging) return;
    isDragging = false;
    
    pendulum.classList.remove('dragging');
    
    // Kembalikan transisi untuk efek memegas (snap back)
    pendulum.style.transition = 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
    pendulum.style.transform = ''; // Kembali ke animasi CSS
    string.style.height = `${DEFAULT_STRING_LENGTH}px`;
    
    // Bersihkan inline style transisi setelah selesai
    setTimeout(() => { pendulum.style.transition = ''; }, 500);
};

// Event Listeners untuk Mouse
pendulum.addEventListener('mousedown', startDrag);
window.addEventListener('mousemove', onDrag);
window.addEventListener('mouseup', endDrag);

// Event Listeners untuk Touch (Mobile)
pendulum.addEventListener('touchstart', (e) => { startDrag(e); e.preventDefault(); }, { passive: false });
window.addEventListener('touchmove', onDrag);
window.addEventListener('touchend', endDrag);