<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Person Registration System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
  <style>
    body {
      background-color: #fef6eb;
      font-family: Arial, sans-serif;
    }
    .header {
      background-color: #e44b12;
      color: white;
      padding: 20px;
      border-bottom: 5px solid #d34a1cff;
      border-radius: 0 0 10px 10px;
      text-align: center;
    }
    .container {
      display: flex;
      justify-content: center;
      margin: 30px 20px;
      gap: 40px;
      flex-wrap: wrap;
    }
    .form-section, .list-section {
      background: white;
      border-radius: 12px;
      padding: 25px 30px;
      flex: 1 1 400px;
      box-shadow: 0 3px 15px rgb(0 0 0 / 0.1);
      max-width: 600px;
    }
    h2 {
      font-weight: 600;
      margin-bottom: 12px;
      border-bottom: 2px solid #f7be14;
      padding-bottom: 5px;
      color: #222f4a;
    }
    label {
      display: block;
      margin-top: 12px;
      margin-bottom: 5px;
      font-weight: 500;
      color: #e4611aff;
    }
    input[type="text"], input[type="tel"] {
      width: 100%;
      padding: 8px 10px;
      border-radius: 7px;
      border: 1px solid #ccd4e0;
      font-size: 1rem;
      transition: border-color 0.2s ease-in-out;
    }
    input[type="text"]:focus, input[type="tel"]:focus {
      outline: none;
      border-color: #f7be14;
    }
    button {
      cursor: pointer;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 7px;
      border: none;
      transition: background-color 0.3s ease;
      margin-top: 20px;
      user-select: none;
    }
    .button-update {
      background-color: #2a3a56;
      color: white;
      width: 100%;
    }
    .button-update:hover {
      background-color: #22314d;
    }
    .table-wrapper {
      overflow-x: auto;
      margin-top: 18px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      color: #cc7427ff;
    }
    th, td {
      text-align: left;
      padding: 10px 12px;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #2a3a56;
      color: white;
    }
    .action-btn {
      padding: 6px 12px;
      border-radius: 5px;
      font-weight: 600;
      margin-right: 6px;
      border: none;
      color: white;
      user-select: none;
    }
    .gen-qr {
      background-color: #2eb82e;
    }
    .gen-qr:hover {
      background-color: #279227;
    }
    .edit-btn {
      background-color: #f0b90b;
      color: #222f4a;
    }
    .edit-btn:hover {
      background-color: #d4a80a;
    }
    .del-btn {
      background-color: #e44141;
    }
    .del-btn:hover {
      background-color: #b83535;
    }
    #qr-container {
      margin-top: 30px;
      padding: 20px;
      background-color: #f5f5f5;
      border-radius: 12px;
      text-align: center;
      min-height: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }
    #qr-container canvas, #qr-container img {
      max-width: 180px;
      max-height: 180px;
      margin: 0 auto 15px;
      box-shadow: 0 2px 10px rgb(0 0 0 / 0.1);
    }
    #download-qr {
      background-color: #2a3a56;
      color: white;
      padding: 8px 16px;
      border-radius: 7px;
      border: none;
      display: none;
      cursor: pointer;
      font-weight: 600;
    }
    #download-qr:hover {
      background-color: #22314d;
    }
    .search-input {
      width: 100%;
      padding: 8px 12px;
      margin-bottom: 10px;
      border-radius: 8px;
      border: 1px solid #ccd4e0;
      font-size: 1rem;
    }
  </style>
</head>
<body>
  <header class="header">
    <h1 class="text-2xl font-bold">Person Registration System</h1>
    <p class="text-sm mt-1">Record management with QR code generation</p>
  </header>

  <main class="container">
    <section class="form-section">
      <h2>Person Registration</h2>
      <form id="registration-form" onsubmit="return false;">
        <label for="name">Name</label>
        <input id="name" type="text" required />

        <label for="section">Section</label>
        <input id="section" type="text" required />

        <label for="phone">Phone</label>
        <input id="phone" type="tel" required />

        <button id="update-btn" class="button-update" type="submit">Update</button>
      </form>

      <div id="qr-container" aria-label="QR of the Current Registration">
        <p>QR of the Current Registration</p>
        <!-- QR code will appear here -->
      </div>
      <button id="download-qr" aria-label="Download current QR code">Download QR</button>
    </section>

    <section class="list-section">
      <h2>Registered Persons</h2>
      <input id="search-input" class="search-input" type="text" placeholder="Search by name, section, or phone..." aria-label="Search registrations"/>
      <div class="table-wrapper">
        <table aria-label="Registered persons list">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Section</th>
              <th>Phone</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="persons-list">
            <!-- Dynamic person rows -->
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <script>
    // Dummy initial data
    let persons = [
      { id: 2, name: "Leopold", section: "1053", phone: "9931191901", date: "07/09/2025, 12:52:56 PM" },
      { id: 3, name: "Leopold", section: "1053", phone: "9931191901", date: "07/09/2025, 12:55:47 PM" },
      { id: 5, name: "ruby", section: "5090", phone: "65785855", date: "07/09/2025, 04:29:44 PM" },
      { id: 6, name: "ruby", section: "5090", phone: "65785855", date: "07/09/2025, 04:30:26 PM" }
    ];

    const form = document.getElementById('registration-form');
    const nameInput = document.getElementById('name');
    const sectionInput = document.getElementById('section');
    const phoneInput = document.getElementById('phone');
    const updateBtn = document.getElementById('update-btn');
    const personsList = document.getElementById('persons-list');
    const searchInput = document.getElementById('search-input');
    const qrContainer = document.getElementById('qr-container');
    const downloadBtn = document.getElementById('download-qr');

    let currentQRCanvas = null;

    // Render persons table rows
    function renderPersons(filter = '') {
      const filterLC = filter.toLowerCase();
      personsList.innerHTML = '';
      persons.filter(p => 
        p.name.toLowerCase().includes(filterLC) || 
        p.section.toLowerCase().includes(filterLC) || 
        p.phone.toLowerCase().includes(filterLC)
      ).forEach(person => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${person.id}</td>
          <td>${person.name}</td>
          <td>${person.section}</td>
          <td>${person.phone}</td>
          <td>${person.date}</td>
          <td>
            <button class="action-btn gen-qr" aria-label="Generate QR for ${person.name}">Generate QR</button>
            <button class="action-btn edit-btn" aria-label="Edit ${person.name}">Edit</button>
            <button class="action-btn del-btn" aria-label="Delete ${person.name}">Delete</button>
          </td>
        `;
        // Generate QR handler
        row.querySelector('.gen-qr').addEventListener('click', () => {
          generateAndShowQR(person);
        });
        // Edit handler
        row.querySelector('.edit-btn').addEventListener('click', () => {
          nameInput.value = person.name;
          sectionInput.value = person.section;
          phoneInput.value = person.phone;
          updateBtn.textContent = 'Update';
          updateBtn.dataset.personId = person.id;
          // Reset QR view
          clearQR();
        });
        // Delete handler
        row.querySelector('.del-btn').addEventListener('click', () => {
          persons = persons.filter(p => p.id !== person.id);
          renderPersons(searchInput.value);
          clearQR();
        });
        personsList.appendChild(row);
      });
    }

    function generateAndShowQR(person) {
      qrContainer.innerHTML = '';
      const qrText = `Name: ${person.name}\nSection: ${person.section}\nPhone: ${person.phone}\nDate: ${person.date}`;
      // Use the QRCode library to draw canvas
      const canvas = document.createElement('canvas');
      QRCode.toCanvas(canvas, qrText, { width: 180, margin: 2 }, function (error) {
        if (error) {
          qrContainer.innerHTML = '<p>Error generating QR code</p>';
          return;
        }
        qrContainer.appendChild(canvas);
        currentQRCanvas = canvas;
        // Show download button
        downloadBtn.style.display = 'inline-block';
      });
    }

    function clearQR() {
      qrContainer.innerHTML = '<p>QR of the Current Registration</p>';
      currentQRCanvas = null;
      downloadBtn.style.display = 'none';
    }

    // Download QR code as PNG
    downloadBtn.addEventListener('click', () => {
      if (!currentQRCanvas) return;
      const link = document.createElement('a');
      link.href = currentQRCanvas.toDataURL('image/png');
      link.download = 'qr_code.png';
      link.click();
    });

    // Update or add a person
    form.addEventListener('submit', () => {
      const name = nameInput.value.trim();
      const section = sectionInput.value.trim();
      const phone = phoneInput.value.trim();
      if(!name || !section || !phone) return;

      const personId = updateBtn.dataset.personId;
      if (personId) {
        // Update existing
        const idx = persons.findIndex(p => p.id == personId);
        if(idx > -1){
          persons[idx].name = name;
          persons[idx].section = section;
          persons[idx].phone = phone;
          persons[idx].date = new Date().toLocaleString();
        }
        // Reset button
        delete updateBtn.dataset.personId;
        updateBtn.textContent = 'Update';
      } else {
        // Add new person with new ID
        const newId = persons.length ? Math.max(...persons.map(p => p.id)) + 1 : 1;
        persons.push({
          id: newId,
          name,
          section,
          phone,
          date: new Date().toLocaleString()
        });
      }
      // Clear form
      nameInput.value = '';
      sectionInput.value = '';
      phoneInput.value = '';
      clearQR();
      renderPersons(searchInput.value);
    });

    // Search filter
    searchInput.addEventListener('input', () => {
      renderPersons(searchInput.value);
      clearQR();
    });

    // Initial render
    renderPersons();
    clearQR();
  </script>
</body>
</html>

