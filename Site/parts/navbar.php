<?php

echo "<style>.navbar-item img {
        max-height: 5rem;
    }</style>";

echo "<nav class='navbar' role='navigation' aria-label='main navigation'>
        <div class='navbar-brand'>
            <a class='navbar-item' href='index.php'>
                <img src='images/logotipo.avif' width='112' height='40'>
            </a>

            <a role='button' class='navbar-burger' aria-label='menu' aria-expanded='false' data-target='navbarBasicExample'>
                <span aria-hidden='true'></span>
                <span aria-hidden='true'></span>
                <span aria-hidden='true'></span>
            </a>
        </div>

        <div class='navbar-menu'>
            <div class='navbar-start'>
                <a class='navbar-item' href='pessoas.php'>
                Pessoas
                </a>

                <a class='navbar-item' href='carros.php'>
                Carros
                </a>
            </div>
        </div>
    </nav>";

?>