<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Customers</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../general/styles/header.css">
        <link rel="stylesheet" href="../general/styles/style.css">
        <link rel="stylesheet" href="../general/styles/menu.css">
        <link rel="stylesheet" href="../general/styles/table.css">
        <link rel="stylesheet" href="../general/styles/back-button.css">
    </head>
    <body>

        <div class="header">

        </div>

        <div class="menu">
            <div class="menu-content">
                <div class="menu-input">
                    <input type = "text" placeholder="Search">
                </div>

                <div class="menu-item">
                    <a href="all-leads.html">View All Leads</a>
                </div>

                <div class="menu-item">
                    <a href="admin.html">User Management</a>
                </div>
            </div>
        </div>

        <div class="welcome">
            <p>
                Customers
            </p>
        </div>

        <div class = "container">
            <div class="table-header">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Search customers">
                </div>
            </div>


            <table id="customerTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Interactions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>Google</td>
                        <td>john.doe@example.com</td>
                        <td>123-456-7890</td>
                        <td><button class="viewButton" onclick="viewCustomer(1)">View</button></td>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>Google</td>
                        <td>jane.smith@example.com</td>
                        <td>987-654-3210</td>
                        <td><button class="viewButton" onclick="viewCustomer(2)">View</button></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Michael Johnson</td>
                        <td>Google</td>
                        <td>michael.johnson@example.com</td>
                        <td>555-123-4567</td>
                        <td><button class="viewButton" onclick="viewCustomer(3)">View</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <script src="../general/scripts/header-admin.js"></script>
        <script src="../general/scripts/menu-animation.js"></script>
    </body>
</html>