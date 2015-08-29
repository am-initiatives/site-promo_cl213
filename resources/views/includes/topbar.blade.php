<?php $user = Auth::user(); ?>

<div class="contain-to-grid">
    <nav class="top-bar" data-topbar role="navigation">
        <ul class="title-area">
            <li class="name">
                <h1><a href="{{ route('home') }}">Cl213</a></h1>
            </li>
             <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
            <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
        </ul>

        <section class="top-bar-section">
            <!-- Right Nav Section -->
            <ul class="right">
                <li class="has-dropdown">
                    <a href="#">{{ $user->getTitle() }} <img style="height: 30px" src="{{ $user->getPictureLink() }}"></a>
                    <ul class="dropdown">
                        <li><a href="{{ route('users.show', $user->id) }}"><i class="fa fa-user"></i> Profil</a></li>
                        <li><a href="{{ route('accounts.show', $user->account->id) }}"><i class="fa fa-btc"></i> Mon compte</a></li>
                        <li><a href="{{ route('auth.logout') }}"><i class="fa fa-sign-out"></i> Déconnexion</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Left Nav Section -->
            <ul class="left">
                <li><a href="{{ route('users.index') }}"><i class="fa fa-users"></i> Annuaire</a></li>
                <li class="has-dropdown">
                    <a href="#"><i class="fa fa-btc"></i> Buqueur</a>
                    <ul class="dropdown">
                        <li><a href="{{ route('accounts.index') }}">Liste des comptes</a></li>
                        <li><a href="{{ route('transactions.index') }}">Derniers buquage</a></li>
                        <li><a href="{{ route('transactions.create') }}">Faire un buquage</a></li>
                    </ul>
                </li>
            </ul>
        </section>
    </nav>
</div>