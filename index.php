<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kopi kenangan Diandra</title>
    <link rel="stylesheet" href="style.css" />
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar">
      <!-- Logo -->
      <a href="#" class="navbar-logo">Kenangan<span>Terindah</span></a>

      <!-- Search bar -->
      <div class="navbar-extra">
        <input
          type="text"
          name="search"
          placeholder="Search"
          autofocus
          size="20"
        />
        <!-- <i data-feather="search"></i> -->
      </div>

      <!-- Navbar Menu -->
      <div class="navbar-nav">
        <ul>
          <li><a href="">Home</a></li>
          <li><a href="">Project</a></li>
          <li><a href="">Finish</a></li>
          <li><a href="">Log Out</a></li>
        </ul>
      </div>
    </nav>

    <!-- Project Table -->
    <div class="projectTable">
      <div class="projectCard">
        <h2>Project1</h2>
        <div class="description">
          Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.
          Mauris imperdiet quam eu blandit vestibulum.
        </div>
        <p>Created by: Diandra</p>
        <label for="statusSelect1">Status:</label>
        <select
          id="statusSelect1"
          class="statusDropdown green"
          onchange="updateStatus(this)"
        >
          <option value="Finished" selected>Finished</option>
          <option value="Unfinish">Unfinish</option>
          <option value="On Progress">On Progress</option>
        </select>
        <div class="buttons">
          <button>Edit</button>
          <button>Delete</button>
        </div>
      </div>

      <div class="projectCard">
        <h2>Project2</h2>
        <div class="description">
          Description: Another project description goes here. This is just a
          sample for testing flex layout.
        </div>
        <p>Created by: Alex</p>
        <label for="statusSelect2">Status:</label>
        <select
          id="statusSelect2"
          class="statusDropdown red"
          onchange="updateStatus(this)"
        >
          <option value="Finished">Finished</option>
          <option value="Unfinish" selected>Unfinish</option>
          <option value="On Progress">On Progress</option>
        </select>
        <div class="buttons">
          <button>Edit</button>
          <button>Delete</button>
        </div>
      </div>
    </div>

    <!-- Script -->
    <script src="script.js"></script>
  </body>
</html>
