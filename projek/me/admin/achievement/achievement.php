<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achievement</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
    <?php
        include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php')
    ?>
    <div class="main">
    <main class="table">
        <div class="table__header">
            <h1>Achievements</h1>
            <div class="search-container">
                <div class="input-box">
                    <input type="text" name="keyword" placeholder="Search data">
                    <i class='bx bx-search'></i>
                </div>
                <button type='submit' name='submit' value='Search'>Search </button>
            </div>
            <a href="/fsp/projek/me/admin/achievement/achievementAdd.php">
                <button class="add-new-button">Add achievement
                    <i class='bx bx-plus'></i>
                </button>
            </a>
        </div>
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Event Name</th>
                        <th>Team</th>
                        <th>Date</th>
                        <th>Desc</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> 1 </td>
                        <td> event 1 </td>
                        <td> game 1 </td>
                        <td> date 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            
                            <button class="icon-button trash">                                
                                <i class='bx bxs-trash-alt'href ='achivementDelete.php?id=$idachievement' onclick="return confirm('Apakah Anda yakin ingin menghapus achievement ini?')"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                    <td> 1 </td>
                        <td> event 1 </td>
                        <td> game 1 </td>
                        <td> date 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                    <td> 1 </td>
                        <td> event 1 </td>
                        <td> game 1 </td>
                        <td> date 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                    <td> 1 </td>
                        <td> event 1 </td>
                        <td> game 1 </td>
                        <td> date 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                    <td> 1 </td>
                        <td> event 1 </td>
                        <td> game 1 </td>
                        <td> date 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                    <td> 1 </td>
                        <td> event 1 </td>
                        <td> game 1 </td>
                        <td> date 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                    <td> 1 </td>
                        <td> event 1 </td>
                        <td> game 1 </td>
                        <td> date 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                    <td> 1 </td>
                        <td> event 1 </td>
                        <td> game 1 </td>
                        <td> date 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                    <td> 1 </td>
                        <td> event 1 </td>
                        <td> game 1 </td>
                        <td> date 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt'></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination-container">
            <label for="rows">Rows per page: </label>
            <select name="rows" id="rows">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </main>
    </div>
</body>
</html>