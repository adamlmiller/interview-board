<?php

$title = 'Question Categories';

include __DIR__ . '/../../common/session.php';
include __DIR__ . '/../../common/header.php';

?>

<div class="header">
    <div class="row">
        <div class="col-6">
            <h1><i class="far fa-question-circle"></i> Question Categories</h1>
        </div>
        <div class="col-6">
            <div class="float-right">
                <a class="btn btn-dark" href="/questions/categories/create.php"><i class="fas fa-plus-square"></i> Create Category</a>
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

                $paginator = new Paginator($mysql, "SELECT id,name,description,active,created,modified FROM questions_categories ORDER BY id ASC");

                ?>
                <?php if ($categories = $paginator->fetch($limit, $page)) { ?>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="25px">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col" width="75px">Active</th>
                                <th scope="col" width="175px">Created</th>
                                <th scope="col" width="175px">Modified</th>
                                <th scope="col" width="100px"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        if (count($categories->data) >= 1) {
                            foreach ($categories->data AS $category) {
                                echo '<tr>';
                                echo '  <td>' . $category['id'] . '</td>';
                                echo '  <td>' . $category['name'] . '</td>';
                                echo '  <td>' . $category['description'] . '</td>';
                                echo '  <td>' . ($category['active'] ? '<span class="badge badge-pill badge-info">Active</span>':'<span class="badge badge-pill badge-danger">Disabled</span>') . '</td>';
                                echo '  <td>' . date("M jS, Y g:i:sA", strtotime($category['created'])) . '</td>';
                                echo '  <td>' . date("M jS, Y g:i:sA", strtotime($category['modified'])) . '</td>';
                                echo '  <td class="text-right">';
                                echo '    <a class="btn btn-sm btn-outline-dark" href="/questions/categories/read.php?id=' . $category['id'] . '"><i class="fas fa-glasses"></i></a>';
                                echo '    <a class="btn btn-sm btn-outline-info" href="/questions/categories/update.php?id=' . $category['id'] . '"><i class="fas fa-pencil-alt"></i></a>';
                                echo '    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="' . $category['id'] . '" type="button"><i class="fas fa-trash-alt"></i></button>';
                                echo '  </td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><th colspan="7">No categories found!</th></tr>';
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
                url: '/questions/categories/delete.php',
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

<?php include __DIR__ . '/../../common/footer.php'; ?>
