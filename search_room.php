<?php 
require_once('auth.php');
require_once('config.php');

$jsonArray = [];

if (isset($_POST["roomsearch"])) {
  $roomToSearch = $conn->real_escape_string($_POST["roomsearch"]);
  $searchQuery = "SELECT * FROM room WHERE room_name LIKE '%$roomToSearch%'";
  $searchResult = mysqli_query($conn, $searchQuery);

  while ($rows = mysqli_fetch_assoc($searchResult)) {
    $jsonArray[] = $rows;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Room</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      margin: 0;
      padding: 40px;
      background-color: #f1f5f9;
    }

    h1 {
      text-align: center;
      color: #1d4ed8;
    }

    .room-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 20px;
      margin-top: 30px;
      padding: 0 20px;
    }

    .room-card {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: transform 0.2s;
    }

    .room-card:hover {
      transform: translateY(-5px);
    }

    .room-card h3 {
      margin-top: 0;
      color: #111827;
    }

    .room-card p {
      margin: 6px 0;
      color: #4b5563;
    }

    .btn {
      display: inline-block;
      margin-top: 10px;
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      font-weight: 500;
      cursor: pointer;
    }

    .btn.details {
      background-color: #facc15;
      color: #1e293b;
    }

    .btn.book {
      background-color: #2563eb;
      color: white;
      margin-left: 10px;
    }

    form {
      text-align: center;
    }

    input[type="text"] {
      padding: 8px;
      width: 250px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      width: 90%;
      max-width: 400px;
      background: white;
      padding: 20px;
      border-radius: 10px;
      transform: translate(-50%, -50%);
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      z-index: 1000;
    }

    .popup h3 {
      margin-top: 0;
    }

    .overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
    }

    .close-btn {
      margin-top: 15px;
      background-color: #e11d48;
      color: white;
    }
  </style>
</head>
<body>

<a href="homepage.php">← Back to Homepage</a>
<h1>🔍 Search Room</h1>

<form method="POST" action="search_room.php">
  <input type="text" name="roomsearch" placeholder="Enter room name..." required>
  <button type="submit">Search</button>
</form>

<?php
if (isset($_POST['roomsearch'])) {
  $count = count($jsonArray);
  echo "<h3 style='text-align:center;'>$count result(s) found.</h3>";
}
?>

<div class="room-list" id="roomList">
  <!-- Room cards will be rendered here -->
</div>

<!-- Popup Modal -->
<div class="overlay" id="overlay" onclick="closePopup()"></div>
<div class="popup" id="roomPopup">
  <h3 id="popupTitle">Room Details</h3>
  <p id="popupInfo"></p>
  <button class="btn close-btn" onclick="closePopup()">Close</button>
</div>

<script>
  const rooms = <?php echo json_encode($jsonArray); ?>;

  function loadRooms() {
    const container = document.getElementById('roomList');
    container.innerHTML = ''; // clear previous results
    rooms.forEach(room => {
      const card = document.createElement('div');
      card.className = 'room-card';
      card.innerHTML = `
        <h3>${room.room_name}</h3>
        <p><strong>ID:</strong> ${room.room_id}</p>
        <p><strong>Type:</strong> ${room.type}</p>
        <p><strong>Size:</strong> ${room.size} pax</p>
        <button class="btn details" onclick="showDetails(${room.room_id})">View Details</button>
        <a href="booking.html?roomId=${room.room_id}" class="btn book">Book</a>
      `;
      container.appendChild(card);
    });
  }

  function showDetails(id) {
    const room = rooms.find(r => r.room_id == id);
    document.getElementById('popupTitle').textContent = `${room.room_name} Details`;
    document.getElementById('popupInfo').innerHTML = `
      <strong>Type:</strong> ${room.type}<br>
      <strong>Size:</strong> ${room.size} pax<br>
      <em>No additional description available.</em>
    `;
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('roomPopup').style.display = 'block';
  }

  function closePopup() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('roomPopup').style.display = 'none';
  }

  loadRooms();
</script>

</body>
</html>
