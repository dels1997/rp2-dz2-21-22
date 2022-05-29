<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>Project name</th><th>Author</th><th>Status</th>
    </tr>
    <?php
        foreach($projectlist as $project)
        {
            echo '<tr>';
            echo '<td>';
            echo '<a href="teamup.php?rt=projects/show&id_project=' . $project[0]->id . '"';
            if($project[1] === $_SESSION['username'])
                echo ' style="background-color: lightgreen">';
            else
                echo '>';
            echo $project[0]->title . '</a></td>';
            echo '<td>' . $project[1] . '</td>';
            echo '<td>' . $project[0]->status . '</td>';
            echo '</tr>';
            // if($project[1] === $_SESSION['username'])
            //     echo '</div>';
        }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>