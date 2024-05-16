<?php
define("DBNAME", "clothingstore");
define("DBHOST", "localhost:3307");
define("DBUSER", "root");
define("DBPASS", "");

function conection_database($dbname = DBNAME, $dbhost = DBHOST, $dbuser = DBUSER, $dbpass = DBPASS)
{

    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        return $pdo;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function my_header()
{
?>
    <header>
        <nav>
            <figure><img src="./images/Group 1.png" alt="logo" width="130"></figure>
            <H1> Welcome A+ e-clothing Store</H1>
            <lablel>Shop now for the latest and best international fashion accessories with ease and safety</lablel>
        </nav>
    </header>
<?php
}

function my_footer()
{
?>
    <footer>
        <nav>
            <small>Phone number: +972 59911542</small><br>
            <small>Email: a$plus-clothing@gmail.com</small><br>
            <small>Location: Rammallah Al-ersal street</small><br>
            <small>Last update: <time>10:36 PM</time></small><br>
            <button type="submit" onclick="window.location.href='contact_us.html';">Contact Us</button>
        </nav>
    </footer>
<?php
}
