function showAll() {
    const tweets = document.querySelectorAll('.tweet');
    tweets.forEach(tweet => {
        tweet.style.display = 'block'; // Show all tweets
    });
}

function showNewPosts() {
    const tweets = document.querySelectorAll('.tweet');
    tweets.forEach(tweet => {
        const time = tweet.getAttribute('data-time');
        // Show only tweets with "h ago" (hours ago) indicating recent posts
        if (time.includes('h')) {
            tweet.style.display = 'block';
        } else {
            tweet.style.display = 'none';
        }
    });
}

function showMyPosts() {
    const tweets = document.querySelectorAll('.tweet');
    tweets.forEach(tweet => {
        const author = tweet.getAttribute('data-author');
        // Show only tweets by the user "Felicia"
        if (author === 'Felicia') {
            tweet.style.display = 'block';
        } else {
            tweet.style.display = 'none';
        }
    });
}

function showSavedPosts() {
    const tweets = document.querySelectorAll('.tweet');
    tweets.forEach(tweet => {
        const saved = tweet.getAttribute('data-saved');
        // Show only saved tweets
        if (saved === 'true') {
            tweet.style.display = 'block';
        } else {
            tweet.style.display = 'none';
        }
    });
}

function save(element) {
    // Ambil elemen tweet terdekat di mana ikon save diklik
    const tweet = element.closest('.tweet');
    const isSaved = tweet.getAttribute('data-saved') === 'true';
    
    // Jika tweet sudah disimpan, ubah menjadi belum disimpan dan ganti ikon
    if (isSaved) {
        tweet.setAttribute('data-saved', 'false');
        element.src = 'ImagesFigma/save.png'; // Ubah ikon menjadi kosong
    } else {
        // Jika tweet belum disimpan, ubah menjadi disimpan dan ganti ikon
        tweet.setAttribute('data-saved', 'true');
        element.src = 'ImagesFigma/bookmark.png'; // Ubah ikon menjadi penuh
    }
}


