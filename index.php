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

      <!-- icon plus -->
      <div class="icon-plus">
  <button><i data-feather="plus"></i></button>
</div>

      <!-- Search icon -->
      <div class="navbar-extra search-container">
      <i data-feather="search" class="search-icon"></i>
      <input
      type="text"
      name="search"
      placeholder="Search"
      autofocus
      size="20"/>
      </div>
      <!-- Navbar Menu -->
      <div class="navbar-nav">
        <ul>
          <li><a href="">Home</a></li>
          <li><a href="">Project</a></li>
          <li><a href="">Finish</a></li>
          <li><a href=""><i data-feather="log-out"></i></a></li>
        </ul>
      </div>
    </nav>

    <!-- Project Table -->
    <div class="projectTable">

<div class="projectCard">
  <h2>Project1</h2>
  <a href="projectDetail.php" class="Detail">
    <div class="description">
      Detail: Lorem ipsum dolor sit amet, consectetur adipiscing elit.
      Mauris imperdiet quam eu blandit vestibulum.
    </div>
  </a>

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
    <button><i data-feather="edit"></i></button>
    <button><i data-feather="trash-2"></i></button>
  </div>
</div>

<div class="projectCard">
  <h2>Project1</h2>
  <a href="projectDetail.php" class="Detail">
    <div class="description">
      Detail: Lorem ipsum dolor sit amet, consectetur adipiscing elit.
      Mauris imperdiet quam eu blandit vestibulum.
    </div>
  </a>

  <p>Created by: Alfito</p>
  <label for="statusSelect2">Status:</label>
  <select
    id="statusSelect2"
    class="statusDropdown green"
    onchange="updateStatus(this)"
  >
    <option value="Finished" selected>Finished</option>
    <option value="Unfinish">Unfinish</option>
    <option value="On Progress">On Progress</option>
  </select>

  <div class="buttons">
    <button><i data-feather="edit"></i></button>
    <button><i data-feather="trash-2"></i></button>
  </div>
    </div>
    <script>
     feather.replace();
    </script>

    <!-- Script -->
    <script src="script.js"></script>
  </body>
</html>
