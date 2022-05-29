<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>Project name</th><th>Status</th><th>Application status</th>
    </tr>
    <?php
        if(!empty($projects))
            foreach($projects as $project)
            {
                echo '<tr>';
                echo '<td><a href="teamup.php?rt=projects/show&id_project=' . $project[0]->id . '">' . $project[0]->title . '</a></td>';
                echo '<td>' . $project[0]->status . '</td>';
                echo '<td>' . $project[2] . '</td>';
                echo '</tr>';
            }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>