function showAll() {
  const tweets = document.querySelectorAll(".tweet");
  tweets.forEach((tweet) => {
    tweet.style.display = "block"; // Show all tweets
  });
}

const currentUserId = isset($currentUserId) ? $currentUserId : 'null'; // Ambil ID pengguna saat ini
function showNewPosts() {
  const allPosts = document.querySelectorAll('.tweet');
            allPosts.forEach(post => {
                if (post.classList.contains('new-post')) {
                    post.style.display = 'block';
                } else {
                    post.style.display = 'none';
                }
            });
        }

function showMyPosts() {
  document.querySelectorAll('.tweet').forEach(tweet => {
    const tweetUserId = tweet.getAttribute('data-user-id');
    if (tweetUserId == currentUserId) {
        tweet.style.display = 'block'; // Tampilkan postingan user saat ini
    } else {
        tweet.style.display = 'none'; // Sembunyikan postingan dari user lain
    }
});
}

function showSavedPosts() {
  const tweets = document.querySelectorAll(".tweet");
  tweets.forEach((tweet) => {
    const saved = tweet.getAttribute("data-saved");
    // Show only saved tweets
    if (saved === "true") {
      tweet.style.display = "block";
    } else {
      tweet.style.display = "none";
    }
  });
}

function save(element) {
  // Ambil elemen tweet terdekat di mana ikon save diklik
  const tweet = element.closest(".tweet");
  const isSaved = tweet.getAttribute("data-saved") === "true";

  // Jika tweet sudah disimpan, ubah menjadi belum disimpan dan ganti ikon
  if (isSaved) {
    tweet.setAttribute("data-saved", "false");
    element.src = "images/save.png"; // Ubah ikon menjadi kosong
  } else {
    // Jika tweet belum disimpan, ubah menjadi disimpan dan ganti ikon
    tweet.setAttribute("data-saved", "true");
    element.src = "images/bookmark.png"; // Ubah ikon menjadi penuh
  }
}

// Fungsi untuk menambahkan komentar baru ke DOM
function addComment(namaPengguna, waktuDibuat, komentar) {
  const commentsContainer = document.getElementById('commentsContainer');
  
  // Membuat elemen baru untuk komentar
  const newComment = document.createElement('div');
  newComment.classList.add('comment');
  newComment.innerHTML = `<p><strong>${namaPengguna}</strong> (${waktuDibuat})</p><p>${komentar}</p>`;
  
  // Menambahkan komentar baru ke container
  commentsContainer.appendChild(newComment);
}

// Menangani pengiriman form komentar
document.querySelector('.form-container form').addEventListener('submit', function(event) {
  event.preventDefault(); // Mencegah pengiriman form default

  const konten = document.getElementById('konten').value; // Ambil nilai dari textarea
  const namaPengguna = '<?= $nama; ?>'; // Ambil nama pengguna dari PHP
  const waktuDibuat = new Date().toLocaleString(); // Waktu saat ini

  // Menambahkan komentar baru ke DOM
  addComment(namaPengguna, waktuDibuat, konten);

  // Kosongkan textarea setelah komentar ditambahkan
  document.getElementById('konten').value = '';
});
