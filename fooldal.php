<?php
session_start();
require_once 'config.php';

// Debug információ
error_log("Session tartalma: " . print_r($_SESSION, true));

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['user_id'])) {
    error_log("Nincs bejelentkezve, átirányítás a login.php-ra");
    header("Location: login.php");
    exit();
}

$sql = "SELECT id, title, details, date FROM hirek ORDER BY date DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <script src="betolt.js"></script>
    <title>Kaposbusz</title>
    <style>
     @import url('https://fonts.googleapis.com/css?family=Open+Sans');

    :root {
        --primary-color:linear-gradient(to right, #211717,#b30000);
        --accent-color: #7A7474;
        --text-light: #fbfbfb;
        --background-light: #f8f9fa;
        --transition: all 0.3s ease;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Open Sans', sans-serif;
        color: var(--text-light);
        background: linear-gradient(to left, #a6a6a6, #e8e8e8);
    }

/*--------------------------------------------------------------------------------------------------------CSS - HEADER---------------------------------------------------------------------------------------------------*/
    .header {
        position: relative;
        background: var(--primary-color);
        color: var(--text-light);
        padding: 1rem;
    }

    .header h1 {
        text-align: center;
        font-size: 2rem;
        padding: 1rem 0;
        margin-left: 38%;
        display: inline-block;
    }

    .nav-wrapper {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 1000;
    }

    .nav-container {
        position: relative;
    }
/*--------------------------------------------------------------------------------------------------------HEADER END-----------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------------CSS - OTHER PARTS----------------------------------------------------------------------------------------------*/
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .hero {
        background-image: url('https://kaposvariprogramok.hu/sites/default/files/120845739_825620101509249_2047839847436415923_n.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: bottom center;
        height: 100vh;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
        margin-bottom: 20px;
        z-index: -2;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }

    .hero h1 {
        font-size: 46px;
        margin: -20px 0 20px;
    }

    .hero p {
        font-size: 20px;
        letter-spacing: 1px;
    }

    .content h2,
    .content h3 {
        font-size: 150%;
        margin: 20px 0;
    }

    .content p {
        color: #555;
        line-height: 30px;
        letter-spacing: 1.2px;
    }
/*--------------------------------------------------------------------------------------------------------OTHER PARTS END------------------------------------------------------------------------------------------------*/

/*UIverse card */
    .card-container{
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        max-width: 1200px; 
        margin-left: 17%;
    }

    .card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 290px;
        height: 400px;
        border-radius: 20px;
        background: #fcfcfc;
        position: relative;
        padding: 2rem;
        border: 2px solid #c3c6ce;
        transition: 0.5s ease-out;
        overflow: visible;
        margin-left: 7%;
        margin-bottom: 5%;
    }

    .card-details {
        color: black;
        height: 100%;
        gap: .5em;
        display: grid;
        place-content: center;
    }

    .card-button {
        transform: translate(-50%, 125%);
        width: 60%;
        border-radius: 1rem;
        border: none;
        background-color: #b30000;
        color: #fff;
        font-size: 1rem;
        padding: .5rem 1rem;
        position: absolute;
        left: 50%;
        bottom: 0;
        opacity: 0;
        transition: 0.3s ease-out;
    }

    .text-body {
        color: rgb(134, 134, 134);
    }

    /*Text*/
    .text-title {
        font-size: 1.5em;
        font-weight: bold;
    }

    /*Hover*/
    .card:hover {
        border-color:#b30000;
        box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.25);
    }

    .card:hover .card-button {
        transform: translate(-50%, 50%);
        opacity: 1;
    }

    .card-container .card {
        display: none; /* Alapértelmezetten rejtett */
    }

    .card-container .card:nth-child(-n+6) {
        display: inline-block; /* Az első 6 kártyát mutassa */
    }

    .news-date{
        background: #b30000;
        width: 90px;
        border-radius: 3px;
        padding:3px;
        color: #fbfbfb;
    }
/*End */

/*--------------------------------------------------------------------------------------------------------CSS - MORE NEWS BUTTON-----------------------------------------------------------------------------------------*/
    .btn-53{
        color: var(--text-light);
        background-color: #b30000;
        border-radius: 30px;
        padding: 15px;
        border: none;
        font-size: 1.5rem;
        margin-left: 42.5%;
        width: 15%;
    }

    .btn-53:hover{
        width: 16%;
        margin-left: 42%;
        background-color:#b60220;
        color:#f5e1e1;
    }
/*--------------------------------------------------------------------------------------------------------MORE NEWS BUTTON END-------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------------CSS - @MEDIA---------------------------------------------------------------------------------------------------*/
    @media (max-width: 480px) {
            /* Adjust the header */
            .header h1 {
                font-size: 1.5rem;
                margin-left: 12%;
                text-align: center;
            }

            /* Navigation adjustments */
            .nav-wrapper {
                position: static;
                text-align: center;
            }

            /* Hero section */
            .hero {
                height: 50vh;
                background-size: cover;
                padding: 1rem;
                text-align: center;
            }

            .hero h1 {
                font-size: 1.5rem;
            }

            .hero p {
                font-size: 1rem;
            }

            /* Card container and cards */
            .card-container {
                margin-left: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 90%;
                margin: 1rem 0;
            }

            .card img {
                width: 100px;
                height: 100px;
            }

            .card-button {
                font-size: 0.8rem;
                padding: 0.4rem 1rem;
            }

            .btn-53 {
                width: 60%;
                font-size: 1.3rem;
                padding: 0.5rem;
                margin-left: 20%;
            }

        }
/*--------------------------------------------------------------------------------------------------------@MEDIA END-----------------------------------------------------------------------------------------------------*/
  
/*--------------------------------------------------------------------------------------------------------CSS - FOOTER---------------------------------------------------------------------------------------------------*/
        footer {
            text-align: center;
            padding: 10px;
            background-color: var(--primary-color);
            color: var(--text-light);
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: var(--shadow);
            background: var(--primary-color);
            color: var(--text-light);
            padding: 3rem 2rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section h2 {
            margin-bottom: 1rem;
            color: var(--text-light);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: var(--text-light);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--accent-color);
        }
/*--------------------------------------------------------------------------------------------------------FOOTER END-----------------------------------------------------------------------------------------------------*/

    </style>
  </head>
  <body>
<!-- -----------------------------------------------------------------------------------------------------HTML - HEADER----------------------------------------------------------------------------------------------- -->
    <div class="header">
        <div class="nav-wrapper">
            <div class="nav-container">
                <button class="menu-btn" id="menuBtn">
                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <nav class="dropdown-menu" id="dropdownMenu">
                    <ul class="menu-items">
                        <li>
                            <a href="fooldal.php" class="active">
                                <img src="home.png" alt="Főoldal">
                                <span>Főoldal</span>
                            </a>
                        </li>
                        <li>
                            <a href="index.php" class="active">
                                <img src="placeholder.png" alt="Térkép">
                                <span>Térkép</span>
                            </a>
                        </li>
                        <li>
                            <a href="buy.php">
                                <img src="tickets.png" alt="Jegyvásárlás">
                                <span>Késés Igazolás</span>
                            </a>
                        </li>
                        <li>
                            <a href="menetrend.php">
                                <img src="calendar.png" alt="Menetrend">
                                <span>Menetrend</span>
                            </a>
                        </li>
                        <li>
                            <a href="jaratok.php">
                                <img src="bus.png" alt="járatok">
                                <span>Járatok</span>
                            </a>
                        </li>
                        <li>
                            <a href="info.php">
                                <img src="information-button.png" alt="Információ">
                                <span>Információ</span>
                            </a>
                        </li>
                        <li>
                            <a href="logout.php">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Kijelentkezés</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
            <h1>Kaposvár Közlekedési Zrt.</h1>
        </div>
<!-- -----------------------------------------------------------------------------------------------------HEADER END-------------------------------------------------------------------------------------------------- -->

<!-- -----------------------------------------------------------------------------------------------------HTML - HERO-------------------------------------------------------------------------------------------------- -->
    <div class="hero">
      <div class="container">
        <h1>Üdvözöljük a Kaposbusz megújult weboldalán</h1>
      </div>
    </div>
<!-- -----------------------------------------------------------------------------------------------------HERO END----------------------------------------------------------------------------------------------------- -->

<!-- -----------------------------------------------------------------------------------------------------HTML - NEWS-------------------------------------------------------------------------------------------------- -->
    <h1 style="color: #b30000; padding-left: 20%; margin-bottom: 3%; margin-top: 5%;">Hírek</h1>

    <div class="card-container">
        <?php
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="card">';
                echo '<div class="card-details">';         
                echo '<h2 class="text-title">' . htmlspecialchars($row["title"]) . '</h2>';
                echo '<p class="news-date">' . htmlspecialchars($row["date"]) . '</p>';
                echo '<p class="card-details">' . htmlspecialchars(substr($row["details"], 0, 50)) . '...</p>';
                echo '</div>';
                echo '<a href="news.php?id=' . $row["id"] . '" class="card-button" style="text-align:center;">Részletek</a>';
                echo '</div>';
            }
        } else {
            echo '<p>Nincsenek hírek.</p>';
        }
        ?>
    </div>
<!-- -----------------------------------------------------------------------------------------------------NEWS END----------------------------------------------------------------------------------------------------- -->

<!-- -----------------------------------------------------------------------------------------------------HTML - MORE NEWS BUTTON-------------------------------------------------------------------------------------- -->
    <button class="btn-53" id="btnMoreNews" data-expanded="false">
        Még több hír >> 
    </button>
<!-- -----------------------------------------------------------------------------------------------------MORE NEWS BUTTON END----------------------------------------------------------------------------------------- -->

<!-- -----------------------------------------------------------------------------------------------------HTML - FOOTER------------------------------------------------------------------------------------------------ -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h2>Kaposvár közlekedés</h2>
                <p style="font-style: italic">Megbízható közlekedési szolgáltatások<br> az Ön kényelméért már több mint 50 éve.</p><br>
                <div class="social-links">
                    <a style="color: darkblue; padding:1px;" href="https://www.facebook.com/VOLANBUSZ/"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" style="max-width:10px;"><path fill="#00008b" d="M279.1 288l14.2-92.7h-88.9v-60.1c0-25.4 12.4-50.1 52.2-50.1h40.4V6.3S260.4 0 225.4 0c-73.2 0-121.1 44.4-121.1 124.7v70.6H22.9V288h81.4v224h100.2V288z"/></svg></a>
                    <a style="color: lightblue; padding:1px;"href="https://x.com/volanbusz_hu?mx=2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="max-width:15px;"><path fill="#add8e6" d="M459.4 151.7c.3 4.5 .3 9.1 .3 13.6 0 138.7-105.6 298.6-298.6 298.6-59.5 0-114.7-17.2-161.1-47.1 8.4 1 16.6 1.3 25.3 1.3 49.1 0 94.2-16.6 130.3-44.8-46.1-1-84.8-31.2-98.1-72.8 6.5 1 13 1.6 19.8 1.6 9.4 0 18.8-1.3 27.6-3.6-48.1-9.7-84.1-52-84.1-103v-1.3c14 7.8 30.2 12.7 47.4 13.3-28.3-18.8-46.8-51-46.8-87.4 0-19.5 5.2-37.4 14.3-53 51.7 63.7 129.3 105.3 216.4 109.8-1.6-7.8-2.6-15.9-2.6-24 0-57.8 46.8-104.9 104.9-104.9 30.2 0 57.5 12.7 76.7 33.1 23.7-4.5 46.5-13.3 66.6-25.3-7.8 24.4-24.4 44.8-46.1 57.8 21.1-2.3 41.6-8.1 60.4-16.2-14.3 20.8-32.2 39.3-52.6 54.3z"/></svg></a>
                    <a style="color: red; padding:1px;"href="https://www.instagram.com/volanbusz/"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="max-width:15px;"><path fill="#ff0000" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg></a>
                </div>
            </div>
           
            <div  class="footer-section">
                <h3>Elérhetőség</h3>
                <ul class="footer-links">
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="max-width:17px;"><path fill="#ffffff" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg> +36-82/411-850</li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="max-width:17px;"><path fill="#ffffff" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg> titkarsag@kkzrt.hu</li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="max-width:16px;"><path fill="#ffffff" d="M172.3 501.7C27 291 0 269.4 0 192 0 86 86 0 192 0s192 86 192 192c0 77.4-27 99-172.3 309.7-9.5 13.8-29.9 13.8-39.5 0zM192 272c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80z"/></svg> 7400 Kaposvár, Cseri út 16.</li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="max-width:16px;"><path fill="#ffffff" d="M172.3 501.7C27 291 0 269.4 0 192 0 86 86 0 192 0s192 86 192 192c0 77.4-27 99-172.3 309.7-9.5 13.8-29.9 13.8-39.5 0zM192 272c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80z"/></svg> Áchim András utca 1.</li>
                </ul>
            </div>
        </div>
        <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">
            <p>© 2024 Kaposvár közlekedési Zrt. Minden jog fenntartva.</p>
        </div>
    </footer>
<!-- -----------------------------------------------------------------------------------------------------FOOTER END--------------------------------------------------------------------------------------------------- -->
    <script>
/*--------------------------------------------------------------------------------------------------------JS - DROPDOWNMENU----------------------------------------------------------------------------------------------*/
        document.getElementById('menuBtn').addEventListener('click', function() {
            this.classList.toggle('active');
            document.getElementById('dropdownMenu').classList.toggle('active');
        });

        // Kívülre kattintás esetén bezárjuk a menüt
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('dropdownMenu');
            const menuBtn = document.getElementById('menuBtn');
            
            if (!menu.contains(event.target) && !menuBtn.contains(event.target)) {
                menu.classList.remove('active');
                menuBtn.classList.remove('active');
            }
        });

        // Aktív oldal jelölése
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const menuItems = document.querySelectorAll('.menu-items a');
            
            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentPage) {
                    item.classList.add('active');
                }
            });
        });
/*--------------------------------------------------------------------------------------------------------DROPDOWNMENU END-----------------------------------------------------------------------------------------------*/
    
    document.getElementById('btnMoreNews').addEventListener('click', function() {
        const cards = document.querySelectorAll('.card-container .card');
        const isExpanded = this.getAttribute('data-expanded') === 'true'; // Ellenőrzi a jelenlegi állapotot

        if (isExpanded) {
            // Állapot visszaállítása: csak 6 kártya
            cards.forEach((card, index) => {
                card.style.display = index < 6 ? 'inline-block' : 'none';
            });
            this.textContent = 'Még több hír >>'; // Visszaállítja a szöveget
            this.setAttribute('data-expanded', 'false'); // Állapot frissítése
        } else {
            // Minden kártya megjelenítése
            cards.forEach(card => {
                card.style.display = 'inline-block';
            });
            this.textContent = 'Kevesebb hír <<'; // Szöveg frissítése
            this.setAttribute('data-expanded', 'true'); // Állapot frissítése
        }
    });
    </script>

  </body>
</html>
