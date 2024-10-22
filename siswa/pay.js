var payButton = document.getElementById('pay');
payButton.addEventListener('click', async function (e) {
    e.preventDefault();
    const data = new FormData();
    try{
        const response = await fetch('midtrans.php', {
        method : 'POST',
        body : data,
    });
    const token = await response.text();
    window.snap.pay(token);
    }catch (err) {
        console.log(err.message);
    }
});