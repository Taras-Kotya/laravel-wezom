<header class="mdc-top-app-bar mdc-top-app-bar--fixed">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <a href="/" class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button" aria-label="Open navigation menu">menu</a>
            <span class="mdc-top-app-bar__title"><?=(!empty($title) ? $title : 'Junior Taras')?></span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            <a href="/module-admin" class="mdc-button mdc-button--raised">Admin</a>
            <a href="/module-user" class="mdc-button mdc-button--raised">User</a>
        </section>
    </div>
</header>

<div id="main-content"></div>