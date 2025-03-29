<!DOCTYPE html>
<html lang="en">
<head>
    <x-head />
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <x-header />
    <x-sidebar  />
    <main id="main" class="main">
        {{ $slot }}
    </main>
    <x-footer />

</body>
</html>