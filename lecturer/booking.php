<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book a Room</title>
<style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background-color: #f3f4f6;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .booking-container {
      background: #ffffff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    h1 {
      text-align: center;
      color: #1d4ed8;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-weight: 500;
      color: #374151;
      margin-bottom: 8px;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      font-size: 16px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      border-color: #2563eb;
      outline: none;
    }

    .submit-btn {
      width: 100%;
      background-color: #2563eb;
      color: white;
      padding: 12px;
      font-size: 16px;
      font-weight: 500;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .submit-btn:hover {
      background-color: #1d4ed8;
    }

    .message {
      margin-top: 15px;
      font-size: 15px;
      text-align: center;
    }

    .message.success {
      color: green;
    }

    .message.error {
      color: red;
    }

    .return-home-btn {
            position: fixed;
            right: 30px;
            bottom: 30px;
            background: #1e3a8a;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: background 0.2s;
            text-align: center;
            z-index: 100;
        }
        .return-home-btn:hover {
            background: #2563eb;
        }
  </style>
</head>
<body>
  <div class="booking-container">
    <h1>Book a Room</h1>
    <form id="bookingForm" method="post" action="submit-booking.php"> <!-- submit-booking.php -->
      <!-- <input type="hidden" name="room_id"> -->
      <div class="form-group">
        <label for="room">Room</label>
        <input type="text" id="room" name="room" required>

      </div>
      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" required />
      </div>
      <div class="form-group">
        <label for="startTime">Start Time</label>
        <input type="time" id="startTime" name="startTime" required />
      </div>
      <div class="form-group">
        <label for="endTime">End Time</label>
        <input type="time" id="endTime" name="endTime" required />
      </div>
      <div class="form-group">
        <label for="purpose">Purpose</label>
        <textarea id="purpose" name="purpose" rows="3" required></textarea>
      </div>

      <input type="submit" id="submit" class="submit-btn" value="Submit Booking" name="submit">
      <?php if(isset($_GET['edit'])): ?>
        <input type="hidden" name="book_id" id="book_id">
      <?php endif; ?>
      <div class="message" id="responseMessage"></div>

      <script>
          const searchParams = new URLSearchParams(window.location.search);
          const bookingID = searchParams.get('bookId');
          const previousRoomID = searchParams.get('roomId');
          const previousDate = searchParams.get('date');
          const previousStartTime = searchParams.get('startTime').substring(0, 5);
          const previousEndTime = searchParams.get('endTime').substring(0, 5);
          const purpose = searchParams.get('purpose');
          const editFlag = searchParams.get('edit');

          console.log(bookingID);
          console.log(previousRoomID);
          console.log(editFlag);
          console.log(previousDate);

          if(previousRoomID) {
            document.getElementById('room').value = previousRoomID;
          }

          if(editFlag) {
            document.getElementById('bookingForm').action = 'modifybooking.php';
            document.getElementById('book_id').value = bookingID;
            document.getElementById('room').value = previousRoomID;
            document.getElementById('date').value = previousDate;
            document.getElementById('startTime').value = previousStartTime;
            document.getElementById('endTime').value = previousEndTime;
            document.getElementById('purpose').value = purpose;
            document.getElementById('submit').value = "Modify booking";
          }
        </script>
    </form>
  </div>
<a href="../Homepage.php" class="return-home-btn">&#8592; Return Home</a>
</body>
</html>
