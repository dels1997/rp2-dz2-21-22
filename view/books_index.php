<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>Naslov</th><th>Autor</th>
    </tr>
    <?php
        foreach($booklist as $book)
        {
            echo '<tr>';
            echo '<td>' . $book->title . '</td>';
            echo '<td>' . $book->author . '</td>';
            echo '</tr>';
        }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>