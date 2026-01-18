<!-- Sidebar -->
<aside class="sidebar">
    <nav>
        <ul>
            <li class="active"><a href="#dashboard">Dashboard</a></li>
            <li><a href="#folders">Folders</a></li>
            <li><a href="#files">Files</a></li>
            <li><a href="#users">Users</a></li>
            <li><a href="#settings">Settings</a></li>
        </ul>
    </nav>
</aside>

<style>
  :root {
  --primary-dark: #1a237e;
  --primary: #3949ab;
  --primary-light: #5c6bc0;
  --accent: #00897b;
  --accent-hover: #00695c;
  --danger: #c62828;
  --bg-main: #fafafa;
  --bg-white: #ffffff;
  --bg-sidebar: #f5f7fa;
  --text-dark: #212121;
  --text-medium: #424242;
  --text-light: #757575;
  --border-light: #e0e0e0;
  --shadow-sm: 0 2px 4px rgba(0,0,0,0.08);
  --shadow-md: 0 4px 12px rgba(0,0,0,0.12);
  --shadow-lg: 0 8px 24px rgba(0,0,0,0.15);
  --radius-sm: 4px;
  --radius-md: 8px;
  --radius-lg: 12px;
  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
  .sidebar {
    width: 250px;
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
    height: 85vh;
    position: fixed;
    left: 0;
    top: 100px;
    padding: 20px 0;
}


.sidebar nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar nav li {
    margin: 0;
}

.sidebar nav a {
    display: block;
    padding: 15px 25px;
    color: #ecf0f1;
    text-decoration: none;
    transition: background-color 0.3s ease;
    font-size: 16px;
}

.sidebar nav a:hover {
    background-color: #ffffffff;
}

.sidebar nav a:hover {
    background-color: #ffffffff;
      color: #212121;
}

.sidebar nav li.active a {
    background-color: #3498db;
    border-left: 4px solid #2980b9;
}
</style>