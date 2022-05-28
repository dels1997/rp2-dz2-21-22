<?php require_once __DIR__ . '/_header.php'; ?>

<form action="index.php?rt=books/searchResults" method="POST">
    Unesi ime autora:
    <input type="text" name="author">
    <button type="submit">Pretraži knjižnicu!</button>
</form>

<?php require_once __DIR__ . '/_footer.php'; ?>