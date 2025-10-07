<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QCode Scanner || mine</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
  <!-- Adding basic CSS for styling -->
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f0f0f0;
    }
    #app {
      text-align: center;
    }
    #preview {
      width: 300px; /* Adjust as per your requirement */
      margin-bottom: 20px;
    }
    button {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
<body>
  <div id="app">
    <video id="preview"></video>
    <p>{{ scannedResult }}</p>
    <p v-if="response">{{ response }}</p>
    <!-- Corrected button function to export current date -->
    <button @click="exportDate()">Export Current Date</button>
  </div>
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        scanner: null,
        scannedResult: '',
        response: ''
      },
      mounted() {
        this.scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        this.scanner.addListener('scan', (content) => {
          this.scannedResult = content;
          // Call the function to send data via AJAX
          this.sendData(content);
        });
        Instascan.Camera.getCameras().then(cameras => {
          if (cameras.length > 0) {
            this.scanner.start(cameras[0]);
          } else {
            console.error('No cameras found.');
          }
        }).catch(err => {
          console.error(err);
        });
      },
      methods: {
        sendData(data) {
          // Create an AJAX request
          var xhr = new XMLHttpRequest();
          xhr.open('POST', 'actionscan.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
              if (xhr.status === 200) {
                console.log('Data sent successfully');
                this.response = xhr.responseText;
              } else {
                console.error('Error:', xhr.status, xhr.statusText); // Update error message
                this.response = 'Error sending data: ' + xhr.statusText; // Display error to user
              }
            }
          };
          xhr.send('data=' + encodeURIComponent(data));
        },
        exportDate() {
          var currentDate = new Date().toISOString().slice(0, 19).replace('T', ' ');
          this.date(currentDate);
        },
        date(value) {
          var xhr = new XMLHttpRequest();
          xhr.open('POST', 'export.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
              if (xhr.status === 200) {
                console.log('Data exported successfully');
                if (xhr.responseText) {
                  exportToExcel(JSON.parse(xhr.responseText));
                }
              } else {
                console.error('Error:', xhr.status, xhr.statusText); // Update error message
                this.response = 'Error exporting data: ' + xhr.statusText; // Display error to user
              }
            }
          };
          xhr.send('date=' + encodeURIComponent(value));
        }
      }
    });

    function exportToExcel(data) {
      var wb = XLSX.utils.book_new();
      var ws = XLSX.utils.json_to_sheet(data);
      XLSX.utils.book_append_sheet(wb, ws, "Login Data");
      var wbout = XLSX.write(wb, { type: 'binary', bookType: 'xlsx' });
      var blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });
      saveAs(blob, 'login_data.xlsx');
    }
    
    function s2ab(s) {
      var buf = new ArrayBuffer(s.length);
      var view = new Uint8Array(buf);
      for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
      return buf;
    }
  </script>
</body>
</html>
