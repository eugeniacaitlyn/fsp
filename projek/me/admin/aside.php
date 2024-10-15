<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/asideAdmin.css">
    <!-- <link rel="stylesheet" href="/path-to-project-folder/css/asideAdmin.css"> -->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>

</head>
<body>
    <aside>
        <div class="logo">
            <img src="/fsp/projek/me/images/logo.png" alt="Logo" class="logo">
        </div>
        <ul class="menu">
            <li>
                <a href="/fsp/projek/me/admin/home.php">
                    <i class='bx bxs-home'></i>
                    <span>Home</span>
                </a>
            </li>
            <li >
                <a href="/fsp/projek/me/admin/game/game.php" >
                    <i class='bx bxs-tennis-ball' ></i>
                    <span>Game</span>
                </a>
            </li>
            <li >
                <a href="/fsp/projek/me/admin/team/team.php" >
                    <i class='bx bxs-group' ></i>
                    <span>Team</span>
                </a>
            </li>
            <li>
                <a href="/fsp/projek/me/admin/proposal/proposal.php">
                    <i class='bx bxs-file'></i>
                    <span>Proposal</span>
                </a>
            </li>
            <li>
                <a href="/fsp/projek/me/admin/event/event.php">
                    <i class='bx bxs-calendar-event' ></i>
                    <span>Event</span>
                </a>
            </li>
            <li>
                <a href="/fsp/projek/me/admin/achievement/achievement.php">
                    <i class='bx bxs-medal' ></i>
                    <span>Achievement</span>
                </a>
            </li>
            <li class="logout">
                <a href="/fsp/projek/me/main.php">
                <i class='bx bx-log-out'></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside>
    <!-- <script>
        // Ambil semua item menu
        const menuItems = document.querySelectorAll('.menu li a');

        // Dapatkan nama file dari URL saat ini
        const currentPage = window.location.pathname;

        // Loop melalui setiap item menu
        menuItems.forEach(item => {
            // Cek apakah href dari item menu cocok dengan bagian dari path saat ini
            if (currentPage.includes(item.getAttribute('href').split('/').pop())) {
                item.parentElement.classList.add('active'); // Tambahkan kelas 'active' pada item yang sesuai
            }
        });
    </script> -->

    <script>
        // Ambil semua item menu
        const menuItems = document.querySelectorAll('.menu li a');

        // Dapatkan nama file dari URL saat ini
        const currentPage = window.location.pathname;

        // Loop melalui setiap item menu
        menuItems.forEach(item => {
            // Ambil URL dari item menu
            const itemHref = item.getAttribute('href');

            // Jika href item mengandung '/game/' dan halaman saat ini juga di bawah '/game/', tambahkan kelas 'active'
            if (itemHref.includes('/game/') && currentPage.includes('/game/')) {
                item.parentElement.classList.add('active'); // Tambahkan kelas 'active' pada item yang sesuai
            }
            else if (itemHref.includes('/team/') && currentPage.includes('/team/')) {
                item.parentElement.classList.add('active'); // Tambahkan kelas 'active' pada item yang sesuai
            }
            else if (itemHref.includes('/proposal/') && currentPage.includes('/proposal/')) {
                item.parentElement.classList.add('active'); // Tambahkan kelas 'active' pada item yang sesuai
            }
            else if (itemHref.includes('/event/') && currentPage.includes('/event/')) {
                item.parentElement.classList.add('active'); // Tambahkan kelas 'active' pada item yang sesuai
            }
            else if (itemHref.includes('/Achievement/') && currentPage.includes('/Achievement/')) {
                item.parentElement.classList.add('active'); // Tambahkan kelas 'active' pada item yang sesuai
            }
            else if (itemHref.includes('/home') && currentPage.includes('/home')) {
                item.parentElement.classList.add('active'); // Tambahkan kelas 'active' pada item yang sesuai
            }
        });
    </script>



</body>
</html>