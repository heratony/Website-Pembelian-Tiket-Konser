    <!-- <div id="navbar">
        <div class="logo">
            <img src="asset/img/AVH.png" alt="Logo" onclick="window.location.href='home.php'">
            <div class="hamburger">
                <span class="bar"></span>    
                <span class="bar"></span>    
                <span class="bar"></span>    
            </div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>    
                <li class="nav-item"><a href="ticket.php" class="nav-link">Ticket</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                <?php
                    if (isset($_SESSION['email']) && $_SESSION['email'] === 'admin@gmail.com') {
                        echo '<li><a href="inputdata.php">Input</a></li>';
                    }
                ?> 
                <li class="nav-item"> 
                    <form action="search.php" method="post">
                        <input type="text" name="search" id="search" placeholder="Search">
                        <button type="submit" id="searchb"><i class="fas fa-magnifying-glass"></i></button>
                    </form>
                </li>
                <li class="nav-item"><a href="conf/logout.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </div> -->