<div class="nav">
    <div class="container">
        <a class="logo" href="/public">
            <img src="assets/logo_v2.svg" alt="">
        </a>
        <ul class="nav_links">
            @if($_SESSION['role'] == 'admin'):
            <li><a href="administration">Administration</a></li>
            <li><a href="imprimantes">Imprimants</a></li>
            <li class="droplink">
                <a href="tickets">Tickets</a>
                <div class="dropmenu">
                    <a href="tickets">parcourir Les tickets</a>
                    <a href="ticket">Ajouter une Ticket</a>
                </div>
            </li>
            <li class="droplink">
                <a href="#">Gestion</a>
                <div class="dropmenu">
                    <a href="contrats">Contrat</a>
                    <a href="fournisseurs">Fournisseurs</a>
                    <a href="trace">Tracabilité</a>
                </div>
            </li>
            @elseif ($_SESSION['role'] == 'technicien')
            <li><a href="administration">Administration</a></li>
            <li><a href="imprimantes">Imprimants</a></li>
            <li class="droplink">
                <a href="tickets">Tickets</a>
                <div class="dropmenu">
                    <a href="tickets">parcourir Les tickets</a>
                    <a href="ticket">Ajouter une Ticket</a>
                </div>
            </li>
            @elseif ($_SESSION['role'] == 'user')
            <li><a href="userHome">Home</a></li>
            <li><a href="tickets">tickets creer</a></li>
            <li>
                <a href="ticket">Ajouter une Ticket</a>
            </li>
            @endif
            <li><a href="profil">Profile</a></li>
            <li><a href="logout">{{ $_SESSION['user_name'] }} <img src="assets/logout.png" alt=""></a></li>
        </ul>
    </div>
</div>
