<?php

$title = 'Create :: Question Category';

include __DIR__ . '/../../common/session.php';
include __DIR__ . '/../../common/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'create') {
    if ($query = $mysql->prepare("INSERT INTO `questions_categories` SET `name` = ?, `description` = ?, `active` = ?")) {
        if ($query->bind_param("ssi", $_POST['name'], $_POST['description'], $_POST['active'])) {
            if ($query->execute()) {
                $_SESSION['flash'] = '<div class="alert alert-info" role="alert">Question Category created successfully!</div>';

                header('location: /questions/categories/index.php');
                exit();
            } else {
                $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question category!</div>';
            }
        } else {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question category!</div>';
        }
    } else {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question category!</div>';
    }
}

?>

<div class="header">
    <div class="row">
        <div class="col-6">
            <h1><i class="far fa-question-circle"></i> Question Category :: Create</h1>
        </div>
        <div class="col-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['flash'])) echo $_SESSION['flash']; unset($_SESSION['flash']); ?>

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-body">
                <form action="" id="frmCreate" method="post">
                    <input name="action" value="create" type="hidden">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Name">
                        <small id="nameHelp" class="form-text text-muted">Enter a short identifier for this question.</small>
                    </div>
                    <div class="form-group">
                        <label for="question">Description</label>
                        <textarea name="description" rows="10" class="form-control" id="question" aria-describedby="descriptionHelp" placeholder="Enter the description here..."></textarea>
                        <small id="descriptionHelp" class="form-text text-muted">Please provide a description above. Be as specific as possible and remember to check or grammar and spelling.</small>
                    </div>
                    <div class="form-group">
                        <label for="active">Active</label>
                        <select class="form-control selectpicker" name="active">
                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6"><a class="btn btn-block btn-outline-dark" href="/questions/categories/"><i class="fas fa-ban"></i> Cancel</a></div>
                        <div class="col-6"><button type="submit" class="btn btn-block btn-info"><i class="fas fa-save"></i> Save Category</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#frmCreate").validate({
            rules: {
                name: {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    },
                    minlength: 2,
                    maxlength: 128
                },
                description: {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    },
                    minlength: 2
                }
            }
        });
    });
</script>

<?php include __DIR__ . '/../../common/footer.php'; ?>
