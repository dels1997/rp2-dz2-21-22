<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>Ime</th><th>Prezime</th><th>Link na posudbe</th>
    </tr>
    <?php
        foreach($userlist as $user)
        {
            echo '<tr>';
            echo '<td>' . $user->name . '</td>';
            echo '<td>' . $user->surname . '</td>';
            echo '<td>';
            echo '<a href="index.php?rt=books/list&id_user=' . $user->id . '">';
            echo 'link';
            echo '</a>';
            echo '</td>';
            echo '</tr>';
        }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>