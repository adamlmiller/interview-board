<?php

$title = 'Interviews';

include __DIR__ . '/../common/session.php';
include __DIR__ . '/../common/header.php';

?>

<div class="header">
    <div class="row">
        <div class="col-6">
            <h1><i class="fas fa-address-book"></i> Interviews</h1>
        </div>
        <div class="col-6">
            <div class="float-right">
                <a class="btn btn-dark" href="/interviews/create.php"><i class="fas fa-plus-square"></i> Create Interview</a>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['flash'])) echo $_SESSION['flash']; unset($_SESSION['flash']); ?>

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-body">
                <?php

                $limit = (isset($_GET['limit'])) ? $_GET['limit'] : 25;
                $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
                $links = (isset($_GET['links'])) ? $_GET['links'] : 5;

                $paginator = new Paginator($mysql, "SELECT * FROM interviews ORDER BY created ASC");

                ?>
                <?php if ($interviews = $paginator->fetch($limit, $page)) { ?>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="25px">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">E-Mail</th>
                                <th scope="col" width="100px">Hire?</th>
                                <th scope="col" width="100px">Phone</th>
                                <th scope="col" width="100px">Date</th>
                                <th scope="col" width="175px">Created</th>
                                <th scope="col" width="175px">Modified</th>
                                <th scope="col" width="100px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if (count($interviews->data) >= 1) {
                                foreach ($interviews->data AS $interview) {
                                    echo '<tr>';
                                    echo '  <td>' . $interview['id'] . '</td>';
                                    echo '  <td>' . $interview['first_name'] . ' ' . $interview['last_name'] . '</td>';
                                    echo '  <td>' . $interview['email'] . '</td>';
                                    echo '  <td>';

                                    if ($interview['hire'] == 0) echo '<span class="badge badge-pill badge-danger">No</span>';
                                    if ($interview['hire'] == 1) echo '<span class="badge badge-pill badge-info">Yes</span>';
                                    if ($interview['hire'] == 2) echo '<span class="badge badge-pill badge-warning">Unsure</span>';

                                    echo '  </td>';
                                    echo '  <td>' . $interview['phone'] . '</td>';
                                    echo '  <td>' . date($system['date_format_short'], strtotime($interview['date'])) . '</td>';
                                    echo '  <td>' . date($system['date_format_long'], strtotime($interview['created'])) . '</td>';
                                    echo '  <td>' . date($system['date_format_long'], strtotime($interview['modified'])) . '</td>';
                                    echo '  <td class="text-right">';
                                    echo '    <a class="btn btn-sm btn-outline-dark" href="/interviews/read.php?id=' . $interview['id'] . '"><i class="fas fa-glasses"></i></a>';
                                    echo '    <a class="btn btn-sm btn-outline-info" href="/interviews/update.php?id=' . $interview['id'] . '"><i class="fas fa-pencil-alt"></i></a>';
                                    echo '    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="' . $interview['id'] . '" type="button"><i class="fas fa-trash-alt"></i></button>';
                                    echo '  </td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><th colspan="9">No interviews found!</th></tr>';
                            }

                            ?>
                         </tbody>
                    </table>

                    <?php echo $paginator->links($links); ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.btn-delete').on('click', function() {
            $.ajax({
                url: '/interviews/delete.php',
                method: 'GET',
                data: {
                    id : $(this).data('id')
                },
                dataType: 'html'
            }).done(function(html) {
                $('.modal-delete .modal-content').html(html);
                $('.modal-delete').modal('show');
            });
        });
    });
</script>

<?php include __DIR__ . '/../common/footer.php'; ?>
