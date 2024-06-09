// for click event on concert list items
function handleConcertClick(event) {
  const clickedListItem = event.currentTarget;
  const concertId = clickedListItem.dataset.concertId;
  const url = `konser_detail.php?id=${concertId}`;
  window.location.href = url;
}

// for click event on concert list items
const concertListItems = document.querySelectorAll('li[data-concert-id]');
concertListItems.forEach(listItem => {
  listItem.addEventListener('click', handleConcertClick);
});

// for hamburger button
const mainMenu = document.querySelector('.mainMenu');
const closeMenu = document.querySelector('.closeMenu');
const openMenu = document.querySelector('.openMenu');
const menu_items = document.querySelectorAll('nav .mainMenu li a');

openMenu.addEventListener('click', show);
closeMenu.addEventListener('click', close);

// for closing menu when clicking one of the menu items
menu_items.forEach(item => {
    item.addEventListener('click', close);
});

function show() {
    mainMenu.style.display = 'flex';
    mainMenu.style.top = '0';
}

function close() {
    mainMenu.style.top = '-100%';
}

// dropdown button
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
};

// for real-time update of total price
document.addEventListener("DOMContentLoaded", function() {
  const ticketDataElement = document.getElementById('ticketData');
  if (!ticketDataElement) {
      console.error('ticketData element not found');
      return;
  }
  
  const ticketData = JSON.parse(ticketDataElement.textContent);
  const selectElement = document.getElementById('jenistiket');
  const hargaElement = document.getElementById('harga');
  const jumlahElement = document.getElementById('jumlah');
  const totalElement = document.getElementById('total');
  const errorStockElement = document.getElementById('errorStock'); // Add this line

  if (!selectElement || !hargaElement || !jumlahElement || !totalElement || !errorStockElement) {
      console.error('One or more elements not found');
      return;
  }

  function formatCurrency(amount) {
      return new Intl.NumberFormat('id-ID', {
          style: 'currency',
          currency: 'IDR'
      }).format(amount);
  }

  function updatePrice() {
      const selectedTicket = selectElement.value;
      const quantity = parseInt(jumlahElement.value, 10) || 0;
      let unitPrice = 0;
      let stock = 0;

      ticketData.forEach(ticket => {
          if (ticket.jenis === selectedTicket) {
              unitPrice = ticket.harga;
              stock = ticket.stock;
          }
      });

      const totalPrice = unitPrice * quantity;
      hargaElement.value = formatCurrency(unitPrice);
      totalElement.value = formatCurrency(totalPrice);
      
      // Check if quantity exceeds stock and update error message
      if (quantity > stock) {
          errorStockElement.innerHTML = "Jumlah melebihi stock!";
      } else {
          errorStockElement.innerHTML = ""; // Clear error message if within stock limit
      }
  }

  selectElement.addEventListener('change', updatePrice);
  jumlahElement.addEventListener('input', updatePrice);
});

// for alert pemesanan.php
function confirmBooking() {
  const ticketData = JSON.parse(document.getElementById('ticketData').textContent);
  const selectedTicket = document.getElementById('jenistiket').value;
  const selectedQuantity = document.getElementById('jumlah').value;
  const namaPemesan = document.getElementById('nama_pemesan').value;
  const tlpPemesan = document.getElementById('tlp_pemesan').value;
  const emailPemesan = document.getElementById('email_pemesan').value;

  const ticket = ticketData.find(t => t.jenis === selectedTicket);
  if (!ticket) {
      alert('Pilih jenis tiket yang valid');
      return;
  }

  const totalHarga = ticket.harga * selectedQuantity;
  document.getElementById('harga').value = ticket.harga;
  document.getElementById('total').value = totalHarga;

  const confirmationMessage = `
      Nama Pemesan: ${namaPemesan}\n
      No Tlp: ${tlpPemesan}\n
      Email: ${emailPemesan}\n
      Jenis Tiket: ${selectedTicket}\n
      Jumlah: ${selectedQuantity}\n
      Harga Satuan: ${ticket.harga}\n
      Total Harga: ${totalHarga}\n\n
      Apakah Anda ingin melanjutkan pemesanan?`;

  if (confirm(confirmationMessage)) {
      document.getElementById('bookingForm').submit();
  }
}