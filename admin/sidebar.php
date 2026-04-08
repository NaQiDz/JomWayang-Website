<head>
    <style>
        /* Sidebar */
.sidebar {
    width: 250px;
    background-color: #222;
    color: #fff;
    padding-top: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.sidebar h2 {
    color: #1E90FF;
    margin-bottom: 30px;
    font-size: 24px;
}
.sidebar a {
    text-decoration: none;
    color: #fff;
    padding: 15px;
    width: 100%;
    text-align: center;
    font-size: 16px;
    display: block;
}
.sidebar a:hover, .sidebar a.active {
    background-color: #1E90FF;
}
    </style>
</head>
<div class="sidebar">
    <h2>Jom Wayang Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_movies.php">Manage Movies</a>
        <a href="manage_staff.php">Manage Staff</a>
        <a href="manageslottime.php">Manage Time Slot</a>
        <a href="manage_food.php">Manage Food</a>
        <a href="viewsale.php">View Sales</a>
        <a href="logout.php">Logout</a>
</div>