// Inisialisasi Office JS
Office.onReady((info) => {
    if (info.host === Office.HostType.Word || info.host === Office.HostType.Excel || info.host === Office.HostType.PowerPoint) {
        document.getElementById('status').textContent = 'Office JS ready. Host: ' + info.host;
    } else {
        document.getElementById('status').textContent = 'Running in browser mode (not in Office client)';
        setupStandaloneMode();
    }
});

// Fungsi untuk mode standalone (di browser)
function setupStandaloneMode() {
    // Setup editor untuk mode browser
    document.getElementById('editor').innerHTML = `
        <p>Office JS is running in browser mode. For full functionality, please use within an Office Add-in.</p>
        <p>You can still open and edit files, but real-time collaboration requires Office integration.</p>
    `;
    
    // Event listeners untuk tombol
    document.getElementById('new-doc').addEventListener('click', () => {
        createNewDocument('word');
    });
    
    document.getElementById('new-sheet').addEventListener('click', () => {
        createNewDocument('excel');
    });
    
    document.getElementById('new-slides').addEventListener('click', () => {
        createNewDocument('powerpoint');
    });
    
    document.getElementById('open-file').addEventListener('click', () => {
        document.getElementById('file-input').click();
    });
    
    document.getElementById('file-input').addEventListener('change', handleFileSelect);
    
    document.getElementById('save-file').addEventListener('click', saveFile);
    
    document.getElementById('collaborate').addEventListener('click', startCollaboration);
}

// Fungsi untuk membuat dokumen baru
function createNewDocument(type) {
    let content = '';
    switch(type) {
        case 'word':
            content = '<h1>New Document</h1><p>Start editing your new Word document...</p>';
            break;
        case 'excel':
            content = '<table border="1"><tr><th>A</th><th>B</th><th>C</th></tr><tr><td>1</td><td>2</td><td>3</td></tr></table>';
            break;
        case 'powerpoint':
            content = '<div style="text-align:center"><h1>New Slide</h1><p>Presentation content goes here</p></div>';
            break;
    }
    
    document.getElementById('editor').innerHTML = content;
    document.getElementById('status').textContent = `Created new ${type} document`;
}

// Fungsi untuk menangani pemilihan file
function handleFileSelect(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    const reader = new FileReader();
    reader.onload = function(e) {
        // Untuk demo, kita hanya menampilkan nama file
        document.getElementById('editor').innerHTML = `
            <h2>${file.name}</h2>
            <p>File type: ${file.type}</p>
            <p>Size: ${(file.size / 1024).toFixed(2)} KB</p>
            <p>Note: In a real implementation, this would display the actual file content using Office JS APIs.</p>
        `;
        document.getElementById('status').textContent = `Opened file: ${file.name}`;
    };
    reader.readAsArrayBuffer(file);
}

// Fungsi untuk menyimpan file
function saveFile() {
    // Dalam implementasi nyata, ini akan menggunakan Office JS untuk menyimpan
    document.getElementById('status').textContent = 'File saved (simulated in browser mode)';
    alert('In a real implementation, this would save the file using Office JS APIs.');
}

// Fungsi untuk kolaborasi real-time
function startCollaboration() {
    // Simulasi kolaborasi dengan menambahkan user acak
    const users = ['Alice', 'Bob', 'Charlie', 'Diana', 'Eve'];
    const randomUsers = [...new Set(Array(3).fill().map(() => users[Math.floor(Math.random() * users.length)]))];
    
    const usersList = document.getElementById('users');
    usersList.innerHTML = '';
    randomUsers.forEach(user => {
        const li = document.createElement('li');
        li.textContent = user;
        usersList.appendChild(li);
    });
    
    document.getElementById('status').textContent = `Collaboration started with ${randomUsers.length} users`;
}

// Jika dijalankan dalam Office Add-in
function setupOfficeAddin() {
    // Implementasi untuk Office Add-in akan lebih kompleks
    // dan menggunakan Office JS API secara langsung
    document.getElementById('status').textContent = 'Office Add-in mode activated';
    
    // Contoh: Mendapatkan konten dokumen
    Word.run(function(context) {
        const body = context.document.body;
        context.load(body, 'text');
        
        return context.sync().then(function() {
            document.getElementById('editor').textContent = body.text;
        });
    }).catch(function(error) {
        console.error('Error: ' + JSON.stringify(error));
    });
}